<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 04.01.19
 * Time: 14:04
 */

namespace App\Repository\BusyDays;


interface BusyDaysRepositoryInterface
{
    public function findBusyHotels(array $parameter);
}