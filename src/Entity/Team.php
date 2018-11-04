<?php

/**
 * @author yannloup
 *
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

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
    public function getType() {
        return parent::TYPE_TEAM;
    }
    
  
}
