<?php

namespace App\Entity;

use App\Repository\UserPaymentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserPaymentsRepository::class)
 */
class UserPayments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="no")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToMany(targetEntity=PackageType::class, inversedBy="userPayments")
     */
    private $package_type;

    /**
     * @ORM\Column(type="date")
     */
    private $purchase_date;

    public function __construct()
    {
        $this->package_type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection|PackageType[]
     */
    public function getPackageType(): Collection
    {
        return $this->package_type;
    }

    public function addPackageType(PackageType $packageType): self
    {
        if (!$this->package_type->contains($packageType)) {
            $this->package_type[] = $packageType;
        }

        return $this;
    }

    public function removePackageType(PackageType $packageType): self
    {
        $this->package_type->removeElement($packageType);

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(\DateTimeInterface $purchase_date): self
    {
        $this->purchase_date = $purchase_date;

        return $this;
    }
}
