<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i<20 ; $i++) {
            $user = new User();
            $user
                ->setName($faker->name())
                ;

            $manager->persist($user);

            $this->addReference(User::class . '_' . $i, $user);
        }
        $manager->flush();
    }
}
