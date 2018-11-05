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
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * The Contributor abstract class represents any form of event contributor.
 * It can be a Troup, a Team or an Improvisator.
 *
 * @ORM\Entity
 * @ORM\Table(name="contributor", indexes={@ORM\Index(name="type_idx", columns={"type"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string", length=3)
 * @ORM\DiscriminatorMap({
 *     "TRO"="Troupe",
 *     "TEA"="Team",
 *     "IMP"="Improvisator",
 *     "Grou" = "ImprovGroup"
 * })
 */
abstract class Contributor
{
    use TimestampableEntity;
    
    
    const TYPE_TROUPE = "troupe";
    const TYPE_TEAM  = "team";
    const TYPE_IMPROVISATOR = "improvisator";

    abstract public function getType();
    abstract public function isImprovGroup();
    
    
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid_binary")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description='';


    /**
     * @ORM\Column(type="string", length=70)   
     */
    private $shortName;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"shortName"})
     */
    private $identifier; 
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $location='';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="superAdminOfContributors")
     * @ORM\JoinTable(name="contributors_super_admins")
     */
    private $superAdmins;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     * @ORM\JoinTable(name="contributors_admins")
     */
    private $admins;
    
    public function getLocation(): ?string
    {
        return $this->location;
    }
    
    public function setLocation(string $location): self
    {
        $this->location = $location;
        
        return $this;
    }
    
    public function  __construct(){
        $this->id = Uuid::uuid4();
        $this->superAdmins = new ArrayCollection();
        $this->admins = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
  

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSuperAdmins(): Collection
    {
        return $this->superAdmins;
    }

    public function addSuperAdmin(User $superAdmin): self
    {
        if (!$this->superAdmins->contains($superAdmin)) {
            $this->superAdmins[] = $superAdmin;
        }

        return $this;
    }

    public function removeSuperAdmin(User $superAdmin): self
    {
        if ($this->superAdmins->contains($superAdmin)) {
            $this->superAdmins->removeElement($superAdmin);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(User $admin): self
    {
        if (!$this->admins->contains($admin)) {
            $this->admins[] = $admin;
        }

        return $this;
    }

    public function removeAdmin(User $admin): self
    {
        if ($this->admins->contains($admin)) {
            $this->admins->removeElement($admin);
        }

        return $this;
    }
}

