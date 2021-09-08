<?php

namespace App\Entity;

use App\Repository\PackageTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PackageTypeRepository::class)
 */
class PackageType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $package_limit;

    /**
     * @ORM\Column(type="integer")
     */
    private $buy_limit;

    /**
     * @ORM\ManyToMany(targetEntity=UserPayments::class, mappedBy="package_type")
     */
    private $userPayments;

    public function __construct()
    {
        $this->userPayments = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPackageLimit(): ?int
    {
        return $this->package_limit;
    }

    public function setPackageLimit(int $package_limit): self
    {
        $this->package_limit = $package_limit;

        return $this;
    }

    public function getBuyLimit(): ?int
    {
        return $this->buy_limit;
    }

    public function setBuyLimit(int $buy_limit): self
    {
        $this->buy_limit = $buy_limit;

        return $this;
    }

    /**
     * @return Collection|UserPayments[]
     */
    public function getUserPayments(): Collection
    {
        return $this->userPayments;
    }

    public function addUserPayment(UserPayments $userPayment): self
    {
        if (!$this->userPayments->contains($userPayment)) {
            $this->userPayments[] = $userPayment;
            $userPayment->addPackageType($this);
        }

        return $this;
    }

    public function removeUserPayment(UserPayments $userPayment): self
    {
        if ($this->userPayments->removeElement($userPayment)) {
            $userPayment->removePackageType($this);
        }

        return $this;
    }
}
