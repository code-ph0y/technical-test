<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setUsername('testuser');
        $user->setApiKey('946bdc1a-f91c-497b-b4a8-b3b35b2242c8');

        $manager->persist($user);

        $manager->flush();
    }
}
