<?php

namespace App\DataFixtures\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Entity\OnceHuman\Memetic;
use App\Entity\OnceHuman\MemeticCategory;
use App\Entity\OnceHuman\Scenario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class MemeticFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        $items = $manager->getRepository(Item::class)->findAll();
        $scenarios = $manager->getRepository(Scenario::class)->findAll();

        for ($i = 1; $i <= 4; $i++) {
            $category = (new MemeticCategory())
                ->setName(sprintf('Catégorie %s', $i))
            ;
            $manager->persist($category);

            for ($j = 0; $j < 10; $j++) {
                $memetic = (new Memetic())
                    ->setName($this->faker->words(3, true))
                    ->setDescription($this->faker->text(260))
                    ->setCategory($category)
                ;

                foreach($this->faker->randomElements($items, $this->faker->numberBetween(1, 5)) as $item) {
                    $memetic->addItem($item);
                }

                foreach($this->faker->randomElements($scenarios, $this->faker->numberBetween(1, count($scenarios))) as $scenario) {
                    $memetic->addScenario($scenario);
                }

                $manager->persist($memetic);
            }
        }

        $manager->flush();

    }

    public function getDependencies(): array
    {
        return [
            ItemFixtures::class,
            ScenarioFixtures::class
        ];
    }
}
