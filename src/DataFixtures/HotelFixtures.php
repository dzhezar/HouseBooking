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
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class HotelFixtures extends Fixture
{
    private $categoryRepository;
    private $userRepository;

    public function __construct(CategoryRepository $categoryRepository, UserRepository $userRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    public function getCategories()
    {
        $categories = $this->categoryRepository->findAll();
        return $categories;
    }

    public function getUsers()
    {
        $categories = $this->categoryRepository->findAll();
        return $categories;
    }
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
     //   dd($manager->getRepository(User::class));

        $faker = Factory::create();

        for ($i = 0; $i<5; $i++){
            $hotel = new Hotel();

            $hotel
                ->setName($faker->name())
                ->setImage($faker->imageUrl())
                ->setAddress($faker->address)
                ->setOwner($faker->randomElement($this->userRepository->findAll()))
                ->setCategory($faker->randomElement($this->categoryRepository->findAll()))
            ;
            $manager->persist($hotel);

        }
        $manager->flush();
    }
}