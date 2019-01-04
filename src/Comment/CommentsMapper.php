<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 02.01.19
 * Time: 22:34
 */

namespace App\Comment;


use App\Dto\Comment as CommentDto;
use App\Entity\Comment;
use App\Hotel\HotelMapper;

class CommentsMapper
{
    public function entityToDto(Comment $entity): CommentDto
    {
        $hotelMapper = new HotelMapper();

        return new CommentDto(
            $entity->getAuthor(),
            $entity->getText(),
            $hotelMapper->entityToDto($entity->getHotel())
        );
    }
    public function entityToDtoWithoutHotel(Comment $entity): CommentDto
    {
        return new CommentDto(

            $entity->getAuthor(),
            $entity->getText()
        );
    }
}