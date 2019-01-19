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

interface HotelPageServiceInterface
{
    public function getHotel(string $id);
    public function setComment(string $id, string $text, User $user): Comment;
    public function setCheckoutDays(string $id, array $form, User $user): int ;
    public function setHotel(User $user,array $form): Hotel;
    public function mailToUser(string $email, User $user, Hotel $hotel, int $nightsCount, string $startDate, string $endDate, int $guests);
    public function mailToOwner(string $email, User $user, Hotel $hotel, int $nightsCount, string $startDate, string $endDate, int $guests);
}