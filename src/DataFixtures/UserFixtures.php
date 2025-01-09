<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            'admin@api.thoanny.fr' => ['ROLE_ADMIN'],
            'manager@api.thoanny.fr' => ['ROLE_MANAGER'],
            'enshrouded@api.thoanny.fr' => ['ROLE_MANAGER', 'ROLE_ENSHROUDED'],
            'oncehuman@api.thoanny.fr' => ['ROLE_MANAGER', 'ROLE_ONCEHUMAN'],
            'palia@api.thoanny.fr' => ['ROLE_MANAGER', 'ROLE_PALIA'],
            'user@api.thoanny.fr' => ['ROLE_USER'],
        ];

        foreach ($users as $email => $roles) {
            list($username) = explode('@', $email);

            $user = (new User())
                ->setUsername($username)
                ->setEmail($email)
                ->setVerified(false)
                ->setRoles($roles)
                ->setCreatedAt(new \DateTimeImmutable())
            ;

            $password = $this->hasher->hashPassword($user, $email);
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();
        }

    }
}
