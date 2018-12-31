<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 30.12.18
 * Time: 23:26
 */

namespace App\Service;


use App\Hotel\HotelCollection;
use App\Hotel\HotelMapper;
use App\Repository\Category\CategoryRepository;
use App\Repository\Hotel\HotelRepository;
use App\Repository\User\UserRepository;


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

    }

    public function getHotels()
    {
        $hotels = $this->hotelRepository->findAllWithCategories();
        $collection = new HotelCollection();
        $dataMapper = new HotelMapper();
        foreach ($hotels as $hotel) {
            $collection->addHotel($dataMapper->entityToDto($hotel));
        }
        return $collection;
    }

    public function getUsers()
    {
        $users = $this->userRepository->findAll();
        return $users;
    }
}