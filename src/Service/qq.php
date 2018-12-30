<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 30.12.18
 * Time: 23:26
 */

namespace App\Service;


use App\Repository\CategoryRepository;
use App\Repository\HotelRepository;
use App\Repository\UserRepository;
use Faker\Factory;

class qq
{
    private $categoryRepository;
    private $hotelRepository;
    private $userRepository;

    public function __construct(CategoryRepository $categoryRepository, HotelRepository $hotelRepository, UserRepository $userRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->hotelRepository = $hotelRepository;
        $this->userRepository = $userRepository;
    }

    public function getCategories()
    {
        $categories = $this->categoryRepository->findAll();
        return $categories;
    }

    public function getHotels()
    {
        $hotels = $this->hotelRepository->findAll();
        return $hotels;
    }

    public function getUsers()
    {
        $faker = Factory::create();
        $users = ($faker->randomElement($this->userRepository->findAll()));
        return $users;
    }
}