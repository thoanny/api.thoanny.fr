<?php

namespace App\Entity\Enshrouded\Recipe;

use App\Entity\Enshrouded\Item\Item;
use App\Repository\Enshrouded\Recipe\SourceItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: SourceItemRepository::class)]
#[ORM\Table(name: 'enshrouded_recipe_source_item')]
class SourceItem extends Source
{
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['recipe'])]
    private ?Item $item = null;

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(Item $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    #[Groups(['recipes', 'recipes_sources'])]
    public function getName(): string
    {
        return $this->getItem()->getName();
    }

    #[Groups(['recipe', 'recipes', 'recipes_sources'])]
    public function getType(): string
    {
        return 'item';
    }
}
