<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 18.01.19
 * Time: 14:21
 */

namespace App\Hotel;


use Doctrine\Common\Collections\ArrayCollection;

class HotelFilter
{
    private $categories;
    private $priceMin;
    private $priceMax;
    private $capacityMin;
    private $capacityMax;
    const DEFAULT_PRICE_MIN = 1;
    const DEFAULT_PRICE_MAX = 1000;
    const DEFAULT_CAPACITY_MIN = 1;
    const DEFAULT_CAPACITY_MAX = 10;

    public function __construct(ArrayCollection $categories = null, int $priceMin = null, int $priceMax = null, int $capacityMin = null, int $capacityMax = null)
    {
        $this->categories = $categories;
        $this->priceMin = $priceMin;
        $this->priceMax = $priceMax;
        $this->capacityMin = $capacityMin;
        $this->capacityMax = $capacityMax;
    }

    public function getCategories(): ArrayCollection
    {
        return $this->categories;
    }

    public function setCategories(ArrayCollection $categories): void
    {
        $this->categories = $categories;
    }

    public function getPriceMin(): int
    {
        return $this->priceMin ?? self::DEFAULT_PRICE_MIN;
    }

    public function setPriceMin(?int $priceMin): void
    {
        $this->priceMin = $priceMin;
    }

    public function getPriceMax(): int
    {
        return $this->priceMax  ?? self::DEFAULT_PRICE_MAX;
    }

    public function setPriceMax(?int $priceMax): void
    {
            $this->priceMax = $priceMax;
    }

    public function getCapacityMin(): int
    {
        return $this->capacityMin ?? self::DEFAULT_CAPACITY_MIN;
    }

    public function setCapacityMin(?int $capacityMin): void
    {
            $this->capacityMin = $capacityMin;
    }

    public function getCapacityMax(): int
    {
        return $this->capacityMax ?? self::DEFAULT_CAPACITY_MAX;
    }

    public function setCapacityMax(?int $capacityMax): void
    {
        $this->capacityMax = $capacityMax;
    }

}