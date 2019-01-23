<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Dto;

class BusyDay
{
    private $hotel;
    private $date;
    private $user;


    public function __construct(\DateTimeInterface $date, Hotel $hotel = null, User $user = null)
    {
        $this->hotel = $hotel;
        $this->date = $date;
        $this->user = $user;
    }

    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
