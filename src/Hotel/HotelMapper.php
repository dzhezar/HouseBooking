<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 3:42
 */

namespace App\Hotel;


use App\BusyDays\BusyDaysCollection;
use App\BusyDays\BusyDaysMapper;
use App\Category\CategoryMapper;
use App\Comment\CommentsCollection;
use App\Comment\CommentsMapper;
use App\Dto\Hotel as HotelDto;
use App\Entity\Hotel;
use App\User\UserMapper;

class HotelMapper
{
    public function entityToDto(Hotel $entity): HotelDto
    {
        $categoryMapper = new CategoryMapper();
        $userMapper = new UserMapper();

        $commentsCollection = new CommentsCollection();
        $commentsMapper = new CommentsMapper();
        $comments = $entity->getComments();
        foreach ($comments as $comment) {
            $commentsCollection->addComment($commentsMapper->entityToDtoWithoutHotel($comment));
        }

        $busyDaysCollection = new BusyDaysCollection();
        $busyDaysMapper = new BusyDaysMapper();
        $busyDays = $entity->getBusyDays();
        foreach ($busyDays as $busyday){
            $busyDaysCollection->addBusyDay($busyDaysMapper->entityToDtoWithoutHotel($busyday));
        }
        return new HotelDto(
            $entity->getId(),
            $entity->getName(),
            $entity->getAddress(),
            $entity->getImage(),
            $userMapper->entityToDto($entity->getOwner()),
            $categoryMapper->entityToDto($entity->getCategory()),
            $commentsCollection,
            $busyDaysCollection,
            $entity->getDescription()
        );
    }
}