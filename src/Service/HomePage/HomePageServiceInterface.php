<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Service\HomePage;

use App\Dto\HotelFilter;
use App\Dto\HotelSearchForm;

interface HomePageServiceInterface
{
    public function searchHotels(HotelSearchForm $form, HotelFilter $filterDto);
    public function ajaxSearch(string $text);
    public function getMainHotels();
}
