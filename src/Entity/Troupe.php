<?php

/**
 * @author yannloup
 *
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * The Troupe Entity represents a Troup, a Group, an Association, a Ligue of improvisation.
 * 
 * 
 * @example AIA, LICA, Les Fruits des Fondus... 
 * 
 * 
 * @ORM\Entity(repositoryClass="App\Repository\TroupeRepository")
 * 
 */
class Troupe extends ImprovGroup
{
    public function getType() {
        return parent::TYPE_TROUPE;
    }
}

