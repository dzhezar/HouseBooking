<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\BusyDays;

use App\Dto\BusyDay;

class BusyDaysCollection implements \IteratorAggregate
{
    private $busyDays;

    public function __construct(BusyDay ...$busyDays)
    {
        $this->busyDays = $busyDays;
    }

    public function addBusyDay(BusyDay $busyDay)
    {
        $this->busyDays[] = $busyDay;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->busyDays);
    }

    public function shift(): BusyDay
    {
        return \array_shift($this->busyDays);
    }

    public function getBusyDays(): array
    {
        return $this->busyDays;
    }
}
