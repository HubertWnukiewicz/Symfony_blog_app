<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=UserPayments::class, mappedBy="user_id")
     */
    private $no;

    /**
     * @ORM\OneToMany(targetEntity=BlogLimit::class, mappedBy="user_id")
     */
    private $blogLimits;

    public function __construct()
    {
        $this->no = new ArrayCollection();
        $this->blogLimits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|UserPayments[]
     */
    public function getNo(): Collection
    {
        return $this->no;
    }

    public function addNo(UserPayments $no): self
    {
        if (!$this->no->contains($no)) {
            $this->no[] = $no;
            $no->setUserId($this);
        }

        return $this;
    }

    public function removeNo(UserPayments $no): self
    {
        if ($this->no->removeElement($no)) {
            // set the owning side to null (unless already changed)
            if ($no->getUserId() === $this) {
                $no->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BlogLimit[]
     */
    public function getBlogLimits(): Collection
    {
        return $this->blogLimits;
    }

    public function addBlogLimit(BlogLimit $blogLimit): self
    {
        if (!$this->blogLimits->contains($blogLimit)) {
            $this->blogLimits[] = $blogLimit;
            $blogLimit->setUserId($this);
        }

        return $this;
    }

    public function removeBlogLimit(BlogLimit $blogLimit): self
    {
        if ($this->blogLimits->removeElement($blogLimit)) {
            // set the owning side to null (unless already changed)
            if ($blogLimit->getUserId() === $this) {
                $blogLimit->setUserId(null);
            }
        }

        return $this;
    }

}
