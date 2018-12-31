<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 3:42
 */

namespace App\Hotel;


use App\Category\CategoryMapper;
use App\Dto\Hotel as HotelDto;
use App\Entity\Hotel;
use App\User\UserMapper;

class HotelMapper
{
    public function entityToDto(Hotel $entity): HotelDto
    {
        $categoryMapper = new CategoryMapper();
        $userMapper = new UserMapper();
        return new HotelDto(
            $entity->getName(),
            $entity->getAddress(),
            $entity->getImage(),
            $userMapper->entityToDto(($entity->getOwner())),
            $categoryMapper->entityToDto($entity->getCategory())
        );
    }
}