<?php namespace IA\ApplicationCoreBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use IA\CmsBundle\Entity\Page;

class Settings
{   
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="maintenanceMode", type="boolean", options={"default":"0"}, nullable=false)
     */
    protected $maintenanceMode;
    
    /**
     * @ORM\OneToOne(targetEntity="IA\CmsBundle\Entity\Page")
     */
    protected $maintenancePage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="languages", type="string")
     */
    protected $languages;
    
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
    
    public function setLanguages($languages)
    {
        $this->languages = $languages;
        
        return $this;
    }
    
    public function getLanguages()
    {
        return $this->languages;
    }
}
