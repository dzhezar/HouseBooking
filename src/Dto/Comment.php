<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 02.01.19
 * Time: 22:17
 */

namespace App\Dto;


class Comment
{
    private $hotel;
    private $author;
    private $text;


    public function __construct(string $author, string $text, Hotel $hotel = null)
    {
        $this->hotel = $hotel;
        $this->author = $author;
        $this->text = $text;
    }

    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getText(): string
    {
        return $this->text;
    }
}