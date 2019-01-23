<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Comment;

use App\Dto\Comment as CommentDto;
use App\Entity\Comment;
use App\Hotel\HotelMapper;
use App\User\UserMapper;

class CommentsMapper
{
    public function entityToDto(Comment $entity): CommentDto
    {
        $hotelMapper = new HotelMapper();
        $userMapper = new UserMapper();

        return new CommentDto(
            $userMapper->entityToDto($entity->getAuthor()),
            $entity->getText(),
            $hotelMapper->entityToDto($entity->getHotel())
        );
    }
    public function entityToDtoWithOnlyText(Comment $entity): CommentDto
    {
        return new CommentDto(
            $entity->getText()
        );
    }
}
