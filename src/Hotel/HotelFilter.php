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
        return $this->priceMin ?? 1;
    }

    public function setPriceMin(?int $priceMin): void
    {
        if($priceMin == null){
            $this->priceMin = 1;
        }
        else {
            $this->priceMin = $priceMin;
        }
    }

    public function getPriceMax(): int
    {
        return $this->priceMax ?? 1000;
    }

    public function setPriceMax(?int $priceMax): void
    {
        if($priceMax == null){
            $this->priceMax = 1000;
        }
        else {
            $this->priceMax = $priceMax;
        }
    }

    public function getCapacityMin(): int
    {
        return $this->capacityMin ?? 1;
    }

    public function setCapacityMin(?int $capacityMin): void
    {
        if($capacityMin == null){
            $this->capacityMin = 1;
        }
        else {
            $this->capacityMin = $capacityMin;
        }
    }

    public function getCapacityMax(): int
    {
        return $this->capacityMax ?? 10;
    }

    public function setCapacityMax(?int $capacityMax): void
    {
        if($capacityMax == null){
            $this->capacityMax= 10;
        }
        else {
            $this->capacityMax = $capacityMax;
        }
    }

}