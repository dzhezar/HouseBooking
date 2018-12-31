<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 3:40
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