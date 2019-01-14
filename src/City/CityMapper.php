<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 10.01.19
 * Time: 23:40
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