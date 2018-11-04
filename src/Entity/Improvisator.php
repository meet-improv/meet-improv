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
 * The Improvisator Entity represents an improvisator person.
 * 
 * 
 * @ORM\Entity(repositoryClass="App\Repository\ImprovisatorRepository")
 * 
 */
class Improvisator extends Contributor
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Membership", mappedBy="improvisator", orphanRemoval=true)
     */
    private $memberships;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="improvisator", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        parent::__construct();
        $this->memberships = new ArrayCollection();
    }
    
    public function getType() {
        return parent::TYPE_IMPROVISATOR;
    }

    public function  isImprovGroup(){
        return false;
    }
    
    /**
     * @return Collection|Membership[]
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    public function addMembership(Membership $membership): self
    {
        if (!$this->memberships->contains($membership)) {
            $this->memberships[] = $membership;
            $membership->setImprovisator($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): self
    {
        if ($this->memberships->contains($membership)) {
            $this->memberships->removeElement($membership);
            // set the owning side to null (unless already changed)
            if ($membership->getImprovisator() === $this) {
                $membership->setImprovisator(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newImprovisator = $user === null ? null : $this;
        if ($newImprovisator !== $user->getImprovisator()) {
            $user->setImprovisator($newImprovisator);
        }

        return $this;
    }
    

    
}
