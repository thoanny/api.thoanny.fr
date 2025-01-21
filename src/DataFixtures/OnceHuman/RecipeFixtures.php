<?php

namespace App\DataFixtures\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Entity\OnceHuman\Recipe;
use App\Entity\OnceHuman\RecipeIngredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $items = $manager->getRepository(Item::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $recipe = (new Recipe())
                ->setItem($this->faker->randomElement($items))
                ->setWorkshop($this->faker->randomElement($items))
                ->setQuantity($this->faker->numberBetween(1, 10))
                ->setDuration($this->faker->numberBetween(10, 300))
            ;

            $max = $this->faker->numberBetween(2, 4);
            for($j = 0; $j < $max; $j++) {
                $ingredient = (new RecipeIngredient())
                    ->setItem($this->faker->randomElement($items))
                    ->setQuantity($this->faker->numberBetween(1, 10))
                ;
                $recipe->addIngredient($ingredient);
            }

            $manager->persist($recipe);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ItemCategoryFixtures::class
        ];
    }
}
