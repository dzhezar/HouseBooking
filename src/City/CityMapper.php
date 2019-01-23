<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\City;

use App\Dto\City as CityDto;
use App\Entity\City;

class CityMapper
{
    public function entityToDto(City $entity): CityDto
    {
        return new CityDto(
            $entity->getName()
        );
    }
}
