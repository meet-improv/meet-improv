<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid_binary")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;
    
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Improvisator", inversedBy="user", cascade={"persist", "remove"})
     */
    private $improvisator;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contributor", mappedBy="superAdmins")
     */
    private $superAdminOfContributors;
    
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Contributor", mappedBy="admins")
     */
    private $adminOfContributors;
    
    public function  __construct(){
        $this->id = Uuid::uuid4();
        $this->superAdminOfContributors = new ArrayCollection();
        $this->adminOfContributors = new ArrayCollection();
    }
    
    /*
    public function __toString(){
        return $this->username;
    }  */

    public function getId()
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSuperAdminOfContributors()
    {
        return $this->superAdminOfContributors;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAdminOfContributors()
    {
        return $this->adminOfContributors;
    }



    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $superAdminOfContributors
     */
    public function setSuperAdminOfContributors($superAdminOfContributors)
    {
        $this->superAdminOfContributors = $superAdminOfContributors;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $adminOfContributors
     */
    public function setAdminOfContributors($adminOfContributors)
    {
        $this->adminOfContributors = $adminOfContributors;
    }


    

}
