<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MambershipRepository")
 */
class Membership
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70, nullable=true)
     */
    private $role;

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
    private $isHidden;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Improvisator", inversedBy="memberships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $improvisator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ImprovGroup", inversedBy="memberships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $improvGroup;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): self
    {
        $this->role = $role;

        return $this;
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

    public function getIsHidden(): ?bool
    {
        return $this->isHidden;
    }

    public function setIsHidden(bool $isHidden): self
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    public function getImprovisator(): ?Improvisator
    {
        return $this->improvisator;
    }

    public function setImprovisator(?Improvisator $improvisator): self
    {
        $this->improvisator = $improvisator;

        return $this;
    }

    public function getImprovGroup(): ?ImprovGroup
    {
        return $this->improvGroup;
    }

    public function setImprovGroup(?ImprovGroup $improvGroup): self
    {
        $this->improvGroup = $improvGroup;

        return $this;
    }
}
