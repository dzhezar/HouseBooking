<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Dto;

class HotelFilter
{
    private $category;
    private $priceMin;
    private $priceMax;
    private $capacityMin;
    private $capacityMax;
    const DEFAULT_PRICE_MIN = 1;
    const DEFAULT_PRICE_MAX = 1000;
    const DEFAULT_CAPACITY_MIN = 1;
    const DEFAULT_CAPACITY_MAX = 10;

    public function __construct(string $category = null, int $priceMin = null, int $priceMax = null, int $capacityMin = null, int $capacityMax = null)
    {
        $this->category = \unserialize(\urldecode($category));
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
        $this->capacityMin = $capacityMin;
        $this->capacityMax = $capacityMax;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category): void
    {
        $this->category = $category;
    }

    public function getPriceMin(): int
    {
        return $this->priceMin ?? self::DEFAULT_PRICE_MIN;
    }

    public function setPriceMin(?int $priceMin): void
    {
        $this->priceMin = $priceMin ?? self::DEFAULT_PRICE_MIN;
    }

    public function getPriceMax(): int
    {
        return $this->priceMax ?? self::DEFAULT_PRICE_MAX;
    }

    public function setPriceMax(?int $priceMax): void
    {
        $this->priceMax = $priceMax ?? self::DEFAULT_PRICE_MAX;
    }

    public function getCapacityMin(): int
    {
        return $this->capacityMin ?? self::DEFAULT_CAPACITY_MIN;
    }

    public function setCapacityMin(?int $capacityMin): void
    {
        $this->capacityMin = $capacityMin ?? self::DEFAULT_CAPACITY_MIN;
    }

    public function getCapacityMax(): int
    {
        return $this->capacityMax ?? self::DEFAULT_CAPACITY_MAX;
    }

    public function setCapacityMax(?int $capacityMax): void
    {
        $this->capacityMax = $capacityMax ?? self::DEFAULT_CAPACITY_MAX;
    }

}
