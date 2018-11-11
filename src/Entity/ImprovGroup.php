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
 * The ImprovGroup abstract class represents any form of ImprovGroup that can hold a list of Improvisator.
 * It can be a Troup or a Team.
 *
 * @ORM\Entity
 * @ORM\Table(name="Improvgroup", indexes={@ORM\Index(name="type_idx", columns={"type"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=3)
 * @ORM\DiscriminatorMap({
 *     "TRO"="Troupe",
 *     "TEA"="Team"
 * })
 */
abstract class ImprovGroup extends Contributor
{
    // attributes: creationDate, Location (can be null), list of improvisator
    


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Membership", mappedBy="improvGroup", orphanRemoval=true)
     */
    private $memberships;

    public function __construct()
    {
        parent::__construct();
        $this->memberships = new ArrayCollection();
    }
    
    public function  isImprovGroup(){
        return true;
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
            $membership->setImprovGroup($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): self
    {
        if ($this->memberships->contains($membership)) {
            $this->memberships->removeElement($membership);
            // set the owning side to null (unless already changed)
            if ($membership->getImprovGroup() === $this) {
                $membership->setImprovGroup(null);
            }
        }

        return $this;
    }
}

