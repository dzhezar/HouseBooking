<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\BusyDays;
use App\Entity\Hotel;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class BusyDaysFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5000; $i++) {
            $busyDay = new BusyDays();

            $hotel = $this->getReference(Hotel::class . '_' . $faker->numberBetween(0, 999));
            $user = $this->getReference(User::class . '_' . $faker->numberBetween(0, 19));

            $busyDay
                ->setHotel($hotel)
                ->setDate($faker->dateTimeThisDecade)
                ->setUser($user)
            ;
            $manager->persist($busyDay);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            HotelFixtures::class,
        ];
    }
}
