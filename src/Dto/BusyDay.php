<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 02.01.19
 * Time: 22:17
 */

namespace App\Dto;


class BusyDay
{
    private $hotel;
    private $date;


    public function __construct(\DateTimeInterface $date, Hotel $hotel = null)
    {
        $this->hotel = $hotel;
        $this->date = $date;
    }

    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

}