<?php

namespace App\DataFixtures\OnceHuman;

use App\Entity\OnceHuman\Character;
use App\Entity\OnceHuman\Hive;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Uid\Uuid;

class HiveFixtures extends Fixture implements DependentFixtureInterface
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $characters = $manager->getRepository(Character::class)->findAll();

        for ($i = 0; $i < 4; $i++) {
            $hive = (new Hive())
                ->setLeader($this->faker->randomElement($characters))
                ->setName($this->faker->words(2, true))
                ->setStatus($this->faker->randomElement(['hidden', 'private', 'public']))
                ->setToken(Uuid::v7()->toBase58())
            ;

            for($j = 0; $j < $this->faker->numberBetween(5, 10); $j++) {
                $hive->addMember($this->faker->randomElement($characters));
            }

            $manager->persist($hive);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CharacterFixtures::class,
        ];
    }
}
