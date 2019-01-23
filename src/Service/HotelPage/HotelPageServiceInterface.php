<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
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
    public function setHotel(User $user, array $form): Hotel;
    public function mailToUser(string $email, User $user, Hotel $hotel, int $nightsCount, string $startDate, string $endDate, int $guests);
    public function mailToOwner(string $email, User $user, Hotel $hotel, int $nightsCount, string $startDate, string $endDate, int $guests);
    public function deleteHotel(Hotel $hotel, string $imagesDir);
    public function unpublishHotel(Hotel $hotel);
    public function publishHotel(Hotel $hotel);
}
