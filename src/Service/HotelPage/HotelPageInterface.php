<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 08.01.19
 * Time: 3:12
 */

namespace App\Service\HotelPage;


interface HotelPageInterface
{
    public function getHotel(string $id);
    public function addComment();
}