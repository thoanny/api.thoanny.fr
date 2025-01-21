<?php

namespace App\DataFixtures\OnceHuman;

use App\Entity\OnceHuman\Scenario;
use App\Entity\OnceHuman\Specialization;
use App\Entity\OnceHuman\SpecializationGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class SpecializationFixtures extends Fixture implements DependentFixtureInterface
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $scenarios = $manager->getRepository(Scenario::class)->findAll();

        for ($j = 0; $j < 50; $j++) {
            $specialization = (new Specialization())
                ->setName($this->faker->words(4, true))
                ->setType($this->faker->randomElement(['formula-new', 'formula-boost', 'facility-new', 'facility-boost']))
                ->setDescription($this->faker->text())
                ->setLevels($this->faker->randomElement([
                    [5, 10, 15],
                    [20, 25, 30],
                    [35, 40, 45, 50],
                ]))
            ;
            $specialization->addScenario($this->faker->randomElement($scenarios));
            $manager->persist($specialization);
        }

        $manager->flush();

        $specializations = $manager->getRepository(Specialization::class)->findAll();

        for ($i = 1; $i <= 5; $i++) {
            $group = (new SpecializationGroup())
                ->setName(sprintf('Groupe %s', $i))
            ;

            for ($j = 1; $j <= 5; $j++) {
                $group->addSpecialization($this->faker->randomElement($specializations));
            }

            $manager->persist($group);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ScenarioFixtures::class
        ];
    }
}
