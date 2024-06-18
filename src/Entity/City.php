<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    private ?Department $department = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $uri = null;

    #[ORM\Column(length: 8)]
    private ?string $postalCode = null;

    #[ORM\Column]
    private ?int $population = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: CityAlias::class, orphanRemoval: true)]
    private Collection $cityAliases;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->cityAliases = new ArrayCollection();
        $this->latitude = 0;
        $this->longitude = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

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

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getPopulation(): ?int
    {
        return $this->population;
    }

    public function setPopulation(int $population): self
    {
        $this->population = $population;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return Collection<int, CityAlias>
     */
    public function getCityAliases(): Collection
    {
        return $this->cityAliases;
    }

    public function addCityAlias(CityAlias $cityAlias): static
    {
        if (!$this->cityAliases->contains($cityAlias)) {
            $this->cityAliases->add($cityAlias);
            $cityAlias->setCity($this);
        }

        return $this;
    }

    public function removeCityAlias(CityAlias $cityAlias): static
    {
        if ($this->cityAliases->removeElement($cityAlias)) {
            // set the owning side to null (unless already changed)
            if ($cityAlias->getCity() === $this) {
                $cityAlias->setCity(null);
            }
        }

        return $this;
    }
}
