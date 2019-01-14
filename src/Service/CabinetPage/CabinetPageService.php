<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 14.01.19
 * Time: 2:32
 */

namespace App\Service\CabinetPage;


use App\Hotel\HotelCollection;
use App\Hotel\HotelMapper;
use App\Repository\Hotel\HotelRepository;
use App\Repository\UserRepository;

class CabinetPageService
{
    private $hotelRepository;
    private $userRepository;

    public function __construct(HotelRepository $hotelRepository, UserRepository $userRepository)
    {
        $this->hotelRepository = $hotelRepository;
        $this->userRepository = $userRepository;
    }

    public function getUser(string $name)
    {
        return $this->userRepository->findUserByName($name);
    }

    public function getBookedHotels(int $id): HotelCollection
    {
       $bookedHotels = $this->hotelRepository->findBookedHotelsByUser($id);
       $collection = new HotelCollection();
       $dataMapper = new HotelMapper();

        foreach ($bookedHotels as $bookedHotel) {
            $collection->addHotel($dataMapper->entityToDto($bookedHotel));
       }
        return $collection;
    }

    public function getOwnedHotels(int $id)
    {

    }
}