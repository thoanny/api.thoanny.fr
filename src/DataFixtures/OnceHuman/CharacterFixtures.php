<?php

namespace App\DataFixtures\OnceHuman;

use App\DataFixtures\UserFixtures;
use App\Entity\OnceHuman\Character;
use App\Entity\OnceHuman\Server;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class CharacterFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $servers = $manager->getRepository(Server::class)->findAll();

        for ($i = 0; $i < 20; $i++) {
            $character = (new Character())
                ->setName($this->faker->userName())
                ->setStatus($this->faker->randomElement(['hidden', 'private', 'public']))
                ->setUser($this->faker->randomElement($users))
                ->setServer($this->faker->randomElement($servers))
            ;
            $manager->persist($character);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ScenarioFixtures::class,
        ];
    }
}
