<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OpenDateRepository")
 */
class OpenDate
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid_binary")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublic;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isClosed;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contributor", inversedBy="ownedOpenDates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contributor", inversedBy="invitedToOpenDates")
     * @ORM\JoinTable(name="open_dates_invitations")
     */
    private $invitedContributors;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(handlers={
 *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\RelativeSlugHandler", options={
 *          @Gedmo\SlugHandlerOption(name="relationField", value="owner"),
 *          @Gedmo\SlugHandlerOption(name="relationSlugField", value="identifier"),
 *          @Gedmo\SlugHandlerOption(name="separator", value="_")
 *      })
 * },fields={"start","name"},dateFormat="Y-m-d")
     */
    private $identifier;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->invitedContributors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->isPublic;
    }
    
    public function isPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): self
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getIsClosed(): ?bool
    {
        return $this->isClosed;
    }

    public function setIsClosed(bool $isClosed): self
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    public function getOwner(): ?Contributor
    {
        return $this->owner;
    }

    public function setOwner(?Contributor $owner): self
    {
        $this->owner = $owner;

        return $this;
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Contributor[]
     */
    public function getInvitedContributors(): Collection
    {
        return $this->invitedContributors;
    }

    public function addInvitedContributor(Contributor $invitedContributor): self
    {
        if (!$this->invitedContributors->contains($invitedContributor)) {
            $this->invitedContributors[] = $invitedContributor;
        }

        return $this;
    }

    public function removeInvitedContributor(Contributor $invitedContributor): self
    {
        if ($this->invitedContributors->contains($invitedContributor)) {
            $this->invitedContributors->removeElement($invitedContributor);
        }

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
