<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\MemeticRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MemeticRepository::class)]
#[ORM\Table(name: 'oh_memetic')]
#[Vich\Uploadable]
class Memetic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['memetic_index'])]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    #[Groups(['memetic_index'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['memetic_index'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'memetics')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['memetic_index'])]
    private ?MemeticCategory $category = null;

    /**
     * @var Collection<int, Scenario>
     */
    #[ORM\JoinTable(name: 'oh_memetic_scenario')]
    #[ORM\ManyToMany(targetEntity: Scenario::class)]
    #[Groups(['memetic_index'])]
    private Collection $scenarios;

    /**
     * @var Collection<int, Item>
     */
    #[ORM\JoinTable(name: 'oh_memetic_item')]
    #[ORM\ManyToMany(targetEntity: Item::class, inversedBy: 'memetics')]
    #[Groups(['memetic_index'])]
    private Collection $items;

    #[ORM\ManyToOne(targetEntity: Memetic::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', nullable: true)]
    private ?Memetic $parent = null;

    #[ORM\OneToMany(targetEntity: Memetic::class, mappedBy: 'parent')]
    #[Groups(['memetic_index'])]
    private Collection $children;

    #[Vich\UploadableField(mapping: 'oh_memetics', fileNameProperty: 'icon')]
    private ?File $iconFile = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->scenarios = new ArrayCollection();
        $this->items = new ArrayCollection();
        $this->children = new ArrayCollection();
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

    /**
     * @return Collection<int, Memetic>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Memetic $memetic): static
    {
        if (!$this->children->contains($memetic)) {
            $this->children->add($memetic);
        }

        return $this;
    }

    public function removeChild(Memetic $memetic): static
    {
        $this->children->removeElement($memetic);

        return $this;
    }

    public function getParent(): ?Memetic
    {
        return $this->parent;
    }

    public function setParent(?Memetic $memetic): static
    {
        $this->parent = $memetic;

        return $this;
    }

    public function setIconFile(?File $iconFile = null): void
    {
        $this->iconFile = $iconFile;

        if (null !== $iconFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getIconFile(): ?File
    {
        return $this->iconFile;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    #[Groups(['memetic_index'])]
    public function getIconUrl(): ?string
    {
        $root = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/images/once-human/memetics/';
        return $this->icon ? $root.$this->icon : null;
    }
}
