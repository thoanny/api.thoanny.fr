<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ORM\Table(name: 'oh_recipe')]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['item_show_recipe', 'recipe_index', 'recipe_show'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'recipe')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups(['recipe_index', 'recipe_show'])]
    private ?Item $item = null;

    #[ORM\Column]
    #[Groups(['item_show_recipe', 'recipe_index', 'recipe_show'])]
    private ?int $quantity = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    #[Groups(['item_show_recipe', 'recipe_index', 'recipe_show'])]
    private ?Item $workshop = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['item_show_recipe', 'recipe_show'])]
    private ?int $duration = null;

    /**
     * @var Collection<int, RecipeIngredient>
     */
    #[ORM\OneToMany(targetEntity: RecipeIngredient::class, mappedBy: 'recipe', cascade: ['persist'], orphanRemoval: true)]
    #[Groups(['item_show_recipe'])]
    private Collection $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getWorkshop(): ?Item
    {
        return $this->workshop;
    }

    public function setWorkshop(?Item $workshop): static
    {
        $this->workshop = $workshop;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(RecipeIngredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->setRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(RecipeIngredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            // set the owning side to null (unless already changed)
            if ($ingredient->getRecipe() === $this) {
                $ingredient->setRecipe(null);
            }
        }

        return $this;
    }
}
