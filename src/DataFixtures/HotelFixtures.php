<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 0:09
 */

namespace App\DataFixtures;


use App\Entity\Category;
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

        for ($i = 0; $i<5; $i++){
            $hotel = new Hotel();
            $category = $this->getReference(Category::class.'_'.$faker->numberBetween(0,2));
            $owner = $this->getReference(User::class.'_'.$faker->numberBetween(0,2));

            $hotel
                ->setName($faker->sentence)
                ->setImage($faker->imageUrl())
                ->setAddress($faker->address)
                ->setOwner($owner)
                ->setCategory($category)
            ;
            $manager->persist($hotel);

        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );

    }
}