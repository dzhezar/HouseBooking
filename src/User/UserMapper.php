<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\User;

use App\Dto\User as UserDto;
use App\Entity\User;

class UserMapper
{
    public function entityToDto(User $entity): UserDto
    {
        return new UserDto(
            $entity->getUsername(),
            $entity->getFirstName(),
            $entity->getSurname(),
            $entity->getEmail()
        );
    }
}
