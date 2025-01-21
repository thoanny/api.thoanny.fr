<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\MemeticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemeticRepository::class)]
#[ORM\Table(name: 'oh_memetic')]
class Memetic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'memetics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MemeticCategory $category = null;

    /**
     * @var Collection<int, Scenario>
     */
    #[ORM\JoinTable(name: 'oh_memetic_scenario')]
    #[ORM\ManyToMany(targetEntity: Scenario::class)]
    private Collection $scenarios;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\JoinTable(name: 'oh_memetic_item')]
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'memetics')]
    private Collection $items;

    public function __construct()
    {
        $this->scenarios = new ArrayCollection();
        $this->items = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?MemeticCategory
    {
        return $this->category;
    }

    public function setCategory(?MemeticCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Scenario>
     */
    public function getScenarios(): Collection
    {
        return $this->scenarios;
    }

    public function addScenario(Scenario $scenario): static
    {
        if (!$this->scenarios->contains($scenario)) {
            $this->scenarios->add($scenario);
        }

        return $this;
    }

    public function removeScenario(Scenario $scenario): static
    {
        $this->scenarios->removeElement($scenario);

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        $this->items->removeElement($item);

        return $this;
    }
}
