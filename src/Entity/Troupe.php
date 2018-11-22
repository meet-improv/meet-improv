<?php

/**
 * @author yannloup
 *
 */
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Team", mappedBy="troupe")
     */
    private $teams;

    public function __construct()
    {
        parent::__construct();
        $this->teams = new ArrayCollection();
    }

    public function getType() {
        return parent::TYPE_TROUPE;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setTroupe($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getTroupe() === $this) {
                $team->setTroupe(null);
            }
        }

        return $this;
    }
}

