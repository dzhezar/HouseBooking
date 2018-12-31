<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 3:26
 */

namespace App\Dto;

class Hotel
{
    private $name;
    private $address;
    private $image;
    private $owner;
    private $category;

    public function __construct(string $name, string $address, string $image, User $owner, Category $category)
    {
        $this->name = $name;
        $this->address = $address;
        $this->image = $image;
        $this->owner = $owner;
        $this->category = $category;
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
}