<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Images;

use App\Dto\Image as ImageDto;
use App\Entity\Images;
use App\Hotel\HotelMapper;

class ImageMapper
{
    public function entityToDto(Images $entity): ImageDto
    {
        $hotelMapper = new HotelMapper();

        return new ImageDto(
            $entity->getImage(),
            $hotelMapper->entityToDto($entity->getHotel())
        );
    }
    public function entityToDtoWithoutHotel(Images $entity): ImageDto
    {
        return new ImageDto(
            $entity->getImage()
        );
    }
}
