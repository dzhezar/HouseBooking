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

class Hotel
{
    private $id;
    private $name;
    private $address;
    private $image;
    private $owner;
    private $category;
    private $comments;
    private $busyDays;
    private $description;



    public function __construct(int $id, string $name, string $address, string $image, User $owner, Category $category, CommentsCollection $comments, BusyDaysCollection $busyDays, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->image = $image;
        $this->owner = $owner;
        $this->category = $category;
        $this->comments = $comments;
        $this->busyDays = $busyDays;
        $this->description = $description;
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

    public function getImage(): string
    {
        return $this->image;
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
}