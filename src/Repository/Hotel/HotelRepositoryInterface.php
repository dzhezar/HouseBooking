<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Repository\Hotel;

use App\Dto\HotelFilter;
use App\Dto\HotelSearchForm;

interface HotelRepositoryInterface
{
    public function findAllWithCategories();
    public function findAllByCategory(string $category);
    public function findHotelById(int $id);
    public function findNumberOfHotels(int $count);
    public function findBookedHotelsByUser(int $id);
    public function findOwnedHotelsByUser(int $id);
    public function findAllFiltered(HotelSearchForm $form, HotelFilter $filterDto);
}
