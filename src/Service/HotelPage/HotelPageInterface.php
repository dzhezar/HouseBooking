<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 08.01.19
 * Time: 3:12
 */

namespace App\Service\HotelPage;


use App\Entity\Comment;
use App\Entity\Hotel;
use App\Entity\User;

interface HotelPageInterface
{
    public function getHotel(string $id);
    public function getUser(string $name);
    public function setComment(string $id, string $text, User $user): Comment;
    public function setCheckoutDays(string $id, array $form, User $user): int ;
    public function setHotel(array $form): Hotel;

}