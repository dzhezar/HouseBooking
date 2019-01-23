<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Service\HomePage;

use App\Dto\HotelFilter;
use App\Dto\HotelSearchForm;
use App\Hotel\HotelCollection;
use App\Hotel\HotelMapper;
use App\Repository\City\CityRepository;
use App\Repository\Hotel\HotelRepository;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class HomePageService implements HomePageServiceInterface
{
    private $hotelRepository;
    private $cityRepository;
    private $imageRepository;
    private $em;

    public function __construct(HotelRepository $hotelRepository, CityRepository $cityRepository, ImagesRepository $imageRepository, EntityManagerInterface $em)
    {
        $this->hotelRepository = $hotelRepository;
        $this->cityRepository = $cityRepository;
        $this->imageRepository =$imageRepository;
        $this->em = $em;
    }

    public function ajaxSearch(string $name)
    {
        return $this->cityRepository->findByName($name);
    }
    public function searchHotels(HotelSearchForm $form, HotelFilter $filterDto = null)
    {
        $begin = $form->getStartDate();
        $end = $form->getEndDate();

        $hotels = $this->hotelRepository->findAllFiltered($form, $filterDto);

        if (empty($hotels)) {
            return new Response('Not found');
        }
        $collection = new HotelCollection();
        $dataMapper = new HotelMapper();

        foreach ($hotels as $hotel) {
            $bool = false;
            $busyDays = $dataMapper->entityToDto($hotel)->getBusyDays()->getBusyDays();

            foreach ($busyDays as $busyDay) {
                $userDate = $busyDay->getDate()->format('Y/m/d');

                if ($this->checkInRange($begin, $end, $userDate)) {
                    $bool = true;
                    break;
                }
            }

            if (!$bool) {
                $collection->addHotel($dataMapper->entityToDto($hotel));
            }
        }

        return $collection;
    }

    private function checkInRange(string $start_date, string $end_date, string $date_from_user): bool
    {
        $start_ts = \strtotime($start_date);
        $end_ts = \strtotime($end_date);
        $user_ts = \strtotime($date_from_user);

        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

    public function getMainHotels(): HotelCollection
    {
        $mainHotels = $this->hotelRepository->findNumberOfHotels(4);
        $dataMapper = new HotelMapper();
        $collection = new HotelCollection();

        foreach ($mainHotels as $mainHotel) {
            $collection->addHotel($dataMapper->entityToDto($mainHotel));
        }

        return $collection;
    }
}
