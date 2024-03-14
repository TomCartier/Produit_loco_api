<?php

namespace App\Entity;

use App\Repository\FarmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FarmRepository::class)]
class Farm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $street = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 5)]
    private ?string $postCode = null;

    #[ORM\Column(length: 50)]
    private ?string $country = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;

    #[ORM\OneToMany(targetEntity: OpenHours::class, mappedBy: 'farm', orphanRemoval: true)]
    private Collection $open_hours;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'farm')]
    private Collection $products;

    #[ORM\OneToOne(mappedBy: 'farm', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->open_hours = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): static
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    /**
     * @return Collection<int, OpenHours>
     */
    public function getOpenHours(): Collection
    {
        return $this->open_hours;
    }

    public function addOpenHour(OpenHours $openHour): static
    {
        if (!$this->open_hours->contains($openHour)) {
            $this->open_hours->add($openHour);
            $openHour->setFarm($this);
        }

        return $this;
    }

    public function removeOpenHour(OpenHours $openHour): static
    {
        if ($this->open_hours->removeElement($openHour)) {
            // set the owning side to null (unless already changed)
            if ($openHour->getFarm() === $this) {
                $openHour->setFarm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setFarm($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getFarm() === $this) {
                $product->setFarm(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setFarm(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getFarm() !== $this) {
            $user->setFarm($this);
        }

        $this->user = $user;

        return $this;
    }
}
