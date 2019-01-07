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
use App\Images\ImageCollection;
use App\Images\ImageMapper;
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

        $imagesCollection = new ImageCollection();
        $imageMapper = new ImageMapper();
        $images = $entity->getImages();
        foreach ($images as $image){
            $imagesCollection->addImage($imageMapper->entityToDtoWithoutHotel($image));
        }
        return new HotelDto(
            $entity->getId(),
            $entity->getName(),
            $entity->getAddress(),
            $userMapper->entityToDto($entity->getOwner()),
            $categoryMapper->entityToDto($entity->getCategory()),
            $commentsCollection,
            $busyDaysCollection,
            $entity->getDescription(),
            $entity->getPrice(),
            $imagesCollection
        );
    }
}