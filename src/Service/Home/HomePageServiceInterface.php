<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 01.01.19
 * Time: 17:18
 */

namespace App\Service\Home;



interface HomePageServiceInterface
{
    public function searchHotels(array $form);
    public function ajaxSearch(string $text);
    public function getHotel(string $id);

}