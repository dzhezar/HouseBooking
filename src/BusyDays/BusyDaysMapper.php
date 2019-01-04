<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 02.01.19
 * Time: 23:43
 */

namespace App\BusyDays;


use App\Dto\BusyDay as BusyDayDto;
use App\Entity\BusyDays;
use App\Hotel\HotelMapper;

class BusyDaysMapper
{
    public function entityToDto(BusyDays $entity): BusyDayDto
    {
        $hotelMapper = new HotelMapper();

        return new BusyDayDto(
            $entity->getDate(),
            $hotelMapper->entityToDto($entity->getHotel())
        );
    }

    public function entityToDtoWithoutHotel(BusyDays $entity): BusyDayDto
    {

        return new BusyDayDto(
           $entity->getDate()
        );
    }
}