<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OpenDateRepository")
 */
class OpenDate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $start;

    /**
     * @ORM\Column(type="date", nullable=true)
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

    public function __construct()
    {
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
}
