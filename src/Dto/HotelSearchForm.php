<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Dto;

class HotelSearchForm
{
    private $city;
    private $guests;
    private $startDate;
    private $endDate;

    public function __construct(string $city =null, string $guests = null, string $startDate = null, string $endDate = null)
    {
        $this->city = $city;
        $this->guests = $guests;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getGuests(): ?string
    {
        return $this->guests;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setGuests(string $guests): void
    {
        $this->guests = $guests;
    }

    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }
}
