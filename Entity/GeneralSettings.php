<?php namespace IA\ApplicationCoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Resource\Model\ResourceInterface;

use IA\CmsBundle\Entity\Page;

/**
 * @ORM\Table(name="IACORE_GeneralSettings")
 * @ORM\Entity
 */
class GeneralSettings
{   
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="maintenanceMode", type="boolean", options={"default":"0"}, nullable=false)
     */
    private $maintenanceMode;
    
    /**
     * @ORM\OneToOne(targetEntity="IA\CmsBundle\Entity\Page")
     */
    private $maintenancePage;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
  
    public function setMaintenanceMode($maintenanceMode)
    {
        $this->maintenanceMode = $maintenanceMode;

        return $this;
    }

    public function getMaintenanceMode()
    {
        return $this->maintenanceMode;
    }
    
    public function getMaintenancePage(): ?Page
    {
        return $this->maintenancePage;
    }
    
    public function setMaintenancePage(?Page $maintenancePage): self
    {
        $this->maintenancePage = $maintenancePage;
        
        return $this;
    }
}
