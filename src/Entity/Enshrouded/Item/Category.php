<?php

namespace App\Entity\Enshrouded\Item;

use App\Repository\Enshrouded\Item\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'enshrouded_item_category')]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['categories', 'item', 'items', 'recipe'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['categories', 'item', 'items', 'recipe', 'searchable'])]
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

    public function __toString(): string
    {
        return $this->name;
    }
}
