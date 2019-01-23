<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Dto;

class Comment
{
    private $hotel;
    private $author;
    private $text;


    public function __construct(string $text, User $author =null, Hotel $hotel = null)
    {
        $this->hotel = $hotel;
        $this->author = $author;
        $this->text = $text;
    }

    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
