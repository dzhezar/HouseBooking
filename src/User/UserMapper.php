<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 3:38
 */

namespace App\User;


use App\Dto\User as UserDto;
use App\Entity\User;

class UserMapper
{
    public function entityToDto(User $entity): UserDto
    {
        return new UserDto(
            $entity->getUsername()
        );
    }
}