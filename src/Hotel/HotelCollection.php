<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Hotel;

use App\Dto\Hotel;

class HotelCollection implements \IteratorAggregate
{
    private $hotels;

    public function __construct(Hotel ...$hotels)
    {
        $this->hotels = $hotels;
    }

    public function addHotel(Hotel $hotel)
    {
        $this->hotels[] = $hotel;
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->hotels);
    }
}
