<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Repository\BusyDays;

interface BusyDaysRepositoryInterface
{
    public function findBusyHotels(array $parameter);
}
