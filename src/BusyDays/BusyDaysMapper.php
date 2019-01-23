<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\BusyDays;

use App\Dto\BusyDay as BusyDayDto;
use App\Entity\BusyDays;
use App\Hotel\HotelMapper;
use App\User\UserMapper;

class BusyDaysMapper
{
    public function entityToDto(BusyDays $entity): BusyDayDto
    {
        $hotelMapper = new HotelMapper();
        $userMapper = new UserMapper();

        return new BusyDayDto(
            $entity->getDate(),
            $hotelMapper->entityToDto($entity->getHotel()),
            $userMapper->entityToDto($entity->getUser())
        );
    }

    public function entityToDtoWithOnlyDate(BusyDays $entity): BusyDayDto
    {
        return new BusyDayDto(
           $entity->getDate()
        );
    }
}
