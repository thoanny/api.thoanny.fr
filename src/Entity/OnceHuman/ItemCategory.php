<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\ItemCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ItemCategoryRepository::class)]
#[ORM\Table(name: 'oh_item_category')]
class ItemCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['item_index', 'category_index', 'item_show'])]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    #[Groups(['item_index', 'category_index', 'item_show'])]
    private ?string $name = null;

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
}
