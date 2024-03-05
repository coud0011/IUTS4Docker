<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'user@example.com',
            'firstname' => 'Peter',
            'lastname' => 'Parker',
            'roles' => ['ROLE_USER'],
        ]);
        UserFactory::createOne([
            'email' => 'root@example.com',
            'firstname' => 'Tony',
            'lastname' => 'Stark',
            'roles' => ['ROLE_ADMIN'],
        ]);
        UserFactory::createMany(10);
    }
}
