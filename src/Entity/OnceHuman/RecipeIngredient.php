<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\RecipeIngredientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: RecipeIngredientRepository::class)]
#[ORM\Table(name: 'oh_recipe_ingredient')]
class RecipeIngredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recipe_show_ingredient'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ingredients')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Recipe $recipe = null;

    #[ORM\ManyToOne(inversedBy: 'recipeIngredients')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups(['item_show_recipe', 'recipe_show_ingredient'])]
    private ?Item $item = null;

    #[ORM\Column]
    #[Groups(['item_show_recipe', 'recipe_show_ingredient'])]
    private ?int $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }
}
