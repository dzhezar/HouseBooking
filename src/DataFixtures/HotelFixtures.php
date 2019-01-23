<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Hotel;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class HotelFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 1000; $i++) {
            $hotel = new Hotel();
            $category = $this->getReference(Category::class . '_' . $faker->numberBetween(0, 2));
            $owner = $this->getReference(User::class . '_' . $faker->numberBetween(0, 19));
            $city = $this->getReference(City::class . '_' . $faker->numberBetween(0, 9));

            $hotel
                ->setName($faker->sentence)
                ->setAddress($faker->address)
                ->setOwner($owner)
                ->setCategory($category)
                ->setCity($city)
                ->setDescription($faker->text(750))
                ->setPrice($faker->numberBetween(1, 1000))
                ->setCoordinates($faker->latitude . ', ' . $faker->longitude)
                ->setCapacity($faker->numberBetween(1, 10))
                ->setIsPublished($faker->boolean(80));
            ;
            $manager->persist($hotel);

            $this->addReference(Hotel::class . '_' . $i, $hotel);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }
}
