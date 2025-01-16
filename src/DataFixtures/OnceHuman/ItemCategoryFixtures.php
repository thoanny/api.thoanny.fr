<?php

namespace App\DataFixtures\OnceHuman;

use App\Entity\OnceHuman\ItemCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ItemCategoryFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $itemCategory = (new ItemCategory())
                ->setName($this->faker->words($this->faker->numberBetween(2, 4), true))
            ;
            $manager->persist($itemCategory);
        }

        $manager->flush();
    }
}
