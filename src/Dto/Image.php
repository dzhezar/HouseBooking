<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 07.01.19
 * Time: 4:23
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