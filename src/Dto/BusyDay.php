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