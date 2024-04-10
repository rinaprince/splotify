<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // User admin
        $admin = new User(); //25
        $admin
            ->setUsername('admin')
            ->setPassword($this->hasher->hashPassword($admin, "admin"))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $this->addReference('usuari_admin', $admin);


        $admin = new User(); //28
        $admin
            ->setUsername('user')
            ->setPassword($this->hasher->hashPassword($admin, "user"))
            ->setRoles(['ROLE_USER']);

        $manager->persist($admin);

        $this->addReference('usuari_normal', $admin);

        // User normal
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setUsername($faker->userName)
                ->setPassword(password_hash('user', PASSWORD_DEFAULT))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
