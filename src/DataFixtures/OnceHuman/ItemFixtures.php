<?php

namespace App\DataFixtures\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Entity\OnceHuman\ItemCategory;
use App\Entity\OnceHuman\Scenario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(ItemCategory::class)->findAll();
        $scenarios = $manager->getRepository(Scenario::class)->findAll();

        $rarity = ['white', 'green', 'blue', 'purple', 'orange'];

        for($i = 0; $i < 50; $i++) {
            $item = (new Item())
                ->setCategory($this->faker->randomElement($categories))
                ->setName($this->faker->words($this->faker->numberBetween(2, 4), true))
                ->setDescription($this->faker->text(260))
                ->setHowToGet($this->faker->text(260))
                ->setRarity($this->faker->randomElement($rarity))
                ->setWeight($this->faker->numberBetween(50, 1000));
            ;

            $itemScenarios = $this->faker->randomElements($scenarios);
            foreach ($itemScenarios as $itemScenario) {
                $item->addScenario($itemScenario);
            }

            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ItemCategoryFixtures::class,
            ScenarioFixtures::class
        ];
    }
}
