<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
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

    public function getOwnedHotels(int $id): HotelCollection
    {
        $ownedHotels = $this->hotelRepository->findOwnedHotelsByUser($id);
        $collection = new HotelCollection();
        $dataMapper = new HotelMapper();

        foreach ($ownedHotels as $ownedHotel) {
            $collection->addHotel($dataMapper->entityToDto($ownedHotel));
        }

        return $collection;
    }
}
