<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 02.01.19
 * Time: 22:03
 */

namespace App\DataFixtures;


use App\Entity\Comment;
use App\Entity\Hotel;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 500; $i++){
            $comment = new Comment();

            $hotel = $this->getReference(Hotel::class . '_' . $faker->numberBetween(0,49));
            $author = $this->getReference(User::class . '_' . $faker->numberBetween(0,19));

            $comment
                ->setAuthor($author)
                ->setHotel($hotel)
                ->setText($faker->sentence)
                ;
            $manager->persist($comment);
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
            HotelFixtures::class,
            UserFixtures::class,
            CategoryFixtures::class
        );
    }
}