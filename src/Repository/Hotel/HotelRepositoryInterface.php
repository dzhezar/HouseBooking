<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 4:04
 */

namespace App\Repository\Hotel;


use App\Dto\HotelSearchForm;

interface HotelRepositoryInterface
{
    public function findAllWithCategories();
    public function findAllByCategory(string $category);
    public function findHotelById(int $id);
    public function findNumberOfHotels(int $count);
    public function findBookedHotelsByUser(int $id);
    public function findOwnedHotelsByUser(int $id);
    public function findAllFiltered(HotelSearchForm $form);
}