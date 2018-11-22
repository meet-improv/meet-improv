<?php

/**
 * @author yannloup
 *
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * The Team Entity represents a team composition.
 * It can hold Improvisator and me be associated to one Troupe
 * 
 * 
 * 
 * 
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * 
 */
class Team  extends ImprovGroup
{

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Troupe", inversedBy="teams")
     */
    private $troupe;

    public function getType() {
        return parent::TYPE_TEAM;
    }

    public function getTroupe(): ?Troupe
    {
        return $this->troupe;
    }

    public function setTroupe(?Troupe $troupe): self
    {
        $this->troupe = $troupe;

        return $this;
    }
    
  
}
