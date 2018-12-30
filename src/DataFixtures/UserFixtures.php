<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private const NAMES = ['Anton','Hera','Gosha'];

    public function load(ObjectManager $manager)
    {
        // $faker = Factory::create();

        foreach (self::NAMES as $key => $userName) {
            $user = new User();
            $user
                ->setName($userName);

            $manager->persist($user);

            $this->addReference(User::class . '_' . $key, $user);
        }
        $manager->flush();
    }
}
