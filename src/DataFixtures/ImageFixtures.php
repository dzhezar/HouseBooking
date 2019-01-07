<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 07.01.19
 * Time: 4:07
 */

namespace App\DataFixtures;


use App\Entity\Hotel;
use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 2000; $i++){
            $image = new Images();
            $hotel = $this->getReference(Hotel::class.'_'.$faker->numberBetween(0,99));

            $image
                ->setHotel($hotel)
                ->setImage($faker->imageUrl())
            ;
            $manager->persist($image);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            CategoryFixtures::class,
            CityFixtures::class,
            HotelFixtures::class,
        );
    }
}