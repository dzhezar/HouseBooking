<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 3:26
 */

namespace App\Dto;

use App\BusyDays\BusyDaysCollection;
use App\Comment\CommentsCollection;
use App\Images\ImageCollection;

class Hotel
{
    private $id;
    private $name;
    private $address;
    private $owner;
    private $category;
    private $comments;
    private $busyDays;
    private $description;
    private $price;
    private $images;
    private $city;
    private $coordinates;
    private $capacity;



    public function __construct(int $id, string $name, string $address, User $owner, Category $category, CommentsCollection $comments, BusyDaysCollection $busyDays, string $description, float $price, ImageCollection $images, City $city, string $coordinates, int $capacity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->owner = $owner;
        $this->category = $category;
        $this->comments = $comments;
        $this->busyDays = $busyDays;
        $this->description = $description;
        $this->price = $price;
        $this->images = $images;
        $this->city = $city;
        $this->coordinates = $coordinates;
        $this->capacity = $capacity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getComments(): CommentsCollection
    {
        return $this->comments;
    }

    public function getBusyDays(): BusyDaysCollection
    {
        return $this->busyDays;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImages(): ImageCollection
    {
        return $this->images;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function getCoordinates(): string
    {
        return $this->coordinates;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }
}