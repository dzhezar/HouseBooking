<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 18.01.19
 * Time: 19:02
 */

namespace App\Dto;


class HotelSearchForm
{
    private $city;
    private $guests;
    private $startDate;
    private $endDate;
    private $category;
    private $priceMin;
    private $priceMax;
    private $capacityMin;
    private $capacityMax;

    const DEFAULT_PRICE_MIN = 1;
    const DEFAULT_PRICE_MAX = 1000;
    const DEFAULT_CAPACITY_MIN = 1;
    const DEFAULT_CAPACITY_MAX = 10;

    public function __construct(string $city, string $guests, string $startDate, string $endDate, string $category = null, int $priceMin = null,int $priceMax = null, int $capacityMin = null, int $capacityMax = null)
    {
        $this->city = $city;
        $this->guests = $guests;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->category = unserialize(urldecode($category));
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
        $this->capacityMin = $capacityMin;
        $this->capacityMax = $capacityMax;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getGuests(): string
    {
        return $this->guests;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getPriceMin(): int
    {
        return $this->priceMin ?? self::DEFAULT_PRICE_MIN;
    }

    public function getPriceMax(): int
    {
        return $this->priceMax ?? self::DEFAULT_PRICE_MAX;
    }

    public function getCapacityMin(): int
    {
        return $this->capacityMin ?? self::DEFAULT_CAPACITY_MIN;
    }

    public function getCapacityMax(): int
    {
        return $this->capacityMax ?? self::DEFAULT_CAPACITY_MAX;
    }



}