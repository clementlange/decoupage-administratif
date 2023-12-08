<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 3)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'departments')]
    private ?Region $region = null;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: City::class)]
    private Collection $cities;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Event::class)]
    private Collection $events;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Structure::class)]
    private Collection $structures;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: DirectoryCategory::class)]
    private Collection $directoryCategories;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->structures = new ArrayCollection();
        $this->directoryCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setDepartment($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getDepartment() === $this) {
                $city->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setDepartment($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getDepartment() === $this) {
                $event->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getStructures(): Collection
    {
        return $this->structures;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure)) {
            $this->structures->add($structure);
            $structure->setDepartment($this);
        }

        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->removeElement($structure)) {
            // set the owning side to null (unless already changed)
            if ($structure->getDepartment() === $this) {
                $structure->setDepartment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DirectoryCategory>
     */
    public function getDirectoryCategories(): Collection
    {
        return $this->directoryCategories;
    }

    public function addDirectoryCategory(DirectoryCategory $directoryCategory): self
    {
        if (!$this->directoryCategories->contains($directoryCategory)) {
            $this->directoryCategories->add($directoryCategory);
            $directoryCategory->setDepartment($this);
        }

        return $this;
    }

    public function removeDirectoryCategory(DirectoryCategory $directoryCategory): self
    {
        if ($this->directoryCategories->removeElement($directoryCategory)) {
            // set the owning side to null (unless already changed)
            if ($directoryCategory->getDepartment() === $this) {
                $directoryCategory->setDepartment(null);
            }
        }

        return $this;
    }
}
