<?php

/**
 * @author yannloup
 *
 */
namespace App\Entity;

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
    private $description;


    /**
     * @ORM\Column(type="string", length=20)   
     */
    private $shortName;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Gedmo\Slug(fields={"shortName"})
     */
    private $identifier;    
    
    public function  __construct(){
        $this->id = Uuid::uuid4();
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
}

