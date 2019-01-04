<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 4:04
 */

namespace App\Repository\Hotel;


interface HotelRepositoryInterface
{
    public function findAllWithCategories();
    public function findAllByCategory(string $category);
    public function findFreeHotels(string $city);
    public function ajaxSearch(string $data);
    public function findHotelById(string $id);
}