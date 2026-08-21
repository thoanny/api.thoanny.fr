<?php

namespace App\Entity\Vestigia;

use App\Repository\Vestigia\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'vestigia_item')]
#[Vich\Uploadable]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['items', 'me', 'goals', 'loot'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['items', 'goals', 'loot'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['items'])]
    private ?string $description = null;

    #[ORM\Column(length: 25)]
    #[Groups(['items'])]
    private ?string $type = null;

    #[ORM\Column(length: 10)]
    #[Groups(['items', 'loot'])]
    private ?string $rarity = null;

    #[ORM\Column]
    #[Groups(['items'])]
    private ?bool $stackable = null;

    #[Vich\UploadableField(mapping: 'vestigia_item', fileNameProperty: 'icon')]
    private ?File $iconFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['items', 'loot'])]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, LootItem>
     */
    #[ORM\OneToMany(targetEntity: LootItem::class, mappedBy: 'item', cascade: ['persist'], orphanRemoval: true)]
    private Collection $loots;

    public function __construct()
    {
        $this->loots = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): static
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function isStackable(): ?bool
    {
        return $this->stackable;
    }

    public function setStackable(bool $stackable): static
    {
        $this->stackable = $stackable;

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

    /**
     * @return Collection<int, LootItem>
     */
    public function getLoots(): Collection
    {
        return $this->loots;
    }

    public function addLoot(LootItem $loot): static
    {
        if (!$this->loots->contains($loot)) {
            $this->loots->add($loot);
            $loot->setItem($this);
        }

        return $this;
    }

    public function removeLoot(LootItem $loot): static
    {
        if ($this->loots->removeElement($loot)) {
            // set the owning side to null (unless already changed)
            if ($loot->getItem() === $this) {
                $loot->setItem(null);
            }
        }

        return $this;
    }

    #[Groups(['items'])]
    public function isLootable(): bool
    {
        return $this->loots->count() > 0;
    }

    #[Groups(['items'])]
    public function isConsumable(): bool
    {
        // TODO : à changer quand en place
        return false;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
