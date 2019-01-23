<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Dto;

class Image
{
    private $image;
    private $hotel;

    public function __construct(string $image, Hotel $hotel = null)
    {
        $this->image = $image;
        $this->hotel = $hotel;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getHotel(): Hotel
    {
        return $this->hotel;
    }
}
