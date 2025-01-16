<?php

namespace App\DataFixtures\OnceHuman;

use App\Entity\OnceHuman\Scenario;
use App\Entity\OnceHuman\Server;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ScenarioFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        $data = [
            'PVE01-X' => 'Manibus',
            'W_Winter-X' => 'La Voie de l\'Hiver',
            'PVP01-X' => 'Appel de l\'Évolution',
            'P_Clash-X' => 'Affrontement du Primeverse',
        ];

        $difficulties = ['easy', 'normal', 'hard'];

        foreach ($data as $prefix => $name) {
            $scenario = (new Scenario())
                ->setName($name)
            ;
            for($i = 0; $i < 10; $i++) {
                $server = (new Server())
                    ->setName(
                        implode('-', [
                            $prefix,
                            str_pad($i, 4, '0', STR_PAD_LEFT)
                        ])
                    )
                    ->setDifficulty($this->faker->randomElement($difficulties))
                    ->setStartAt(new \DateTimeImmutable($this->faker->dateTimeBetween('- 6 months', '+4 weeks')->format('Y-m-d H:i:s')))
                    ->setClosed($this->faker->boolean())
                ;
                $scenario->addServer($server);
            }

            $manager->persist($scenario);
        }

        $manager->flush();
    }
}
