<?php

namespace App\Entity\OnceHuman;

use App\Repository\OnceHuman\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ORM\Table(name: 'oh_item')]
#[Vich\Uploadable]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['item_index', 'item_show', 'item_show_recipe', 'recipe_index', 'recipe_show', 'recipe_show_ingredient', 'memetic_index'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['item_index', 'item_show', 'item_show_recipe', 'recipe_index', 'recipe_show', 'recipe_show_ingredient', 'memetic_index'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['item_show', 'recipe_show'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['item_show'])]
    private ?string $howToGet = null;

    #[ORM\Column(length: 10)]
    #[Groups(['item_index', 'item_show', 'item_show_recipe', 'recipe_index', 'recipe_show', 'recipe_show_ingredient', 'memetic_index'])]
    private ?string $rarity = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['item_show'])]
    private ?int $weight = null;

    #[ORM\ManyToOne]
    #[Groups(['item_index', 'item_show'])]
    private ?ItemCategory $category = null;

    /**
     * @var Collection<int, Recipe>
     */
    #[ORM\OneToMany(targetEntity: Recipe::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $recipes;

    /**
     * @var Collection<int, RecipeIngredient>
     */
    #[ORM\OneToMany(targetEntity: RecipeIngredient::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $recipeIngredients;

    /**
     * @var Collection<int, Scenario>
     */
    #[ORM\JoinTable(name: 'oh_item_scenario')]
    #[ORM\ManyToMany(targetEntity: Scenario::class, cascade: ['persist'])]
    private Collection $scenario;

    /**
     * @var Collection<int, Memetic>
     */
    #[ORM\ManyToMany(targetEntity: Memetic::class, mappedBy: 'items')]
    private Collection $memetics;

    #[Vich\UploadableField(mapping: 'oh_items', fileNameProperty: 'icon')]
    private ?File $iconFile = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->recipeIngredients = new ArrayCollection();
        $this->scenario = new ArrayCollection();
        $this->memetics = new ArrayCollection();
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

    public function getHowToGet(): ?string
    {
        return $this->howToGet;
    }

    public function setHowToGet(?string $howToGet): static
    {
        $this->howToGet = $howToGet;

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

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCategory(): ?ItemCategory
    {
        return $this->category;
    }

    public function setCategory(?ItemCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->setItem($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            // set the owning side to null (unless already changed)
            if ($recipe->getItem() === $this) {
                $recipe->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
            $recipeIngredient->setItem($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if ($this->recipeIngredients->removeElement($recipeIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngredient->getItem() === $this) {
                $recipeIngredient->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Scenario>
     */
    public function getScenario(): Collection
    {
        return $this->scenario;
    }

    public function addScenario(Scenario $scenario): static
    {
        if (!$this->scenario->contains($scenario)) {
            $this->scenario->add($scenario);
        }

        return $this;
    }

    public function removeScenario(Scenario $scenario): static
    {
        $this->scenario->removeElement($scenario);

        return $this;
    }

    /**
     * @return Collection<int, Memetic>
     */
    public function getMemetics(): Collection
    {
        return $this->memetics;
    }

    public function addMemetic(Memetic $memetic): static
    {
        if (!$this->memetics->contains($memetic)) {
            $this->memetics->add($memetic);
            $memetic->addItem($this);
        }

        return $this;
    }

    public function removeMemetic(Memetic $memetic): static
    {
        if ($this->memetics->removeElement($memetic)) {
            $memetic->removeItem($this);
        }

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

    #[Groups(['item_index', 'item_show'])]
    public function getIconUrl(): ?string
    {
        $root = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/images/once-human/items/';
        return $this->icon ? $root.$this->icon : null;
    }
}
