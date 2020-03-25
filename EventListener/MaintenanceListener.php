<?php namespace IA\ApplicationCoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityRepository;

use IA\ApplicationCoreBundle\Twig\Alerts;

class MaintenanceListener
{
    private $container;
    private $repo;
    private $user;
    
    public function __construct( ContainerInterface $container, EntityRepository $repo )
    {
        $this->repo         = $repo;
        $this->container    = $container;
        
        $token              = $this->container->get( 'security.token_storage' )->getToken();
        if ( $token ) {
            $this->user         = $token->getUser();
        }
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
        $settings           = $this->repo->findBy( [], ['id'=>'DESC'], 1, 0 );
        $maintenanceMode    = false;
        $maintenancePage    = false;
        $debug              = false;
        
        if( isset( $settings[0] ) ) {
            $maintenanceMode    = $settings[0]->getMaintenanceMode();
            $maintenancePage    = $settings[0]->getMaintenancePage();
            
            // This will detect if we are in dev environment (app_dev.php)
            $debug              = in_array( $this->container->get('kernel')->getEnvironment(), ['dev'] );
        }
        
        // https://symfony.com/doc/current/security.html#hierarchical-roles
        // If maintenance is active and in prod environment and user is not admin
        if ( $maintenanceMode ) {
            if (
                ( ! $this->user || ! $this->user->hasRole( 'ROLE_ADMIN' ) )
                && ! $debug
            ) {
                $event->setResponse( new Response( $maintenancePage->getText(), 503 ) );
                
                $event->stopPropagation();
            } else {
                Alerts::$messages[]   = 'The System is in Maintenance Mode !';
            }   
        }
    }
}
