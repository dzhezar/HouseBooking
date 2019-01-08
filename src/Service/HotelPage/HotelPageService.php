<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 08.01.19
 * Time: 3:00
 */

namespace App\Service\HotelPage;


use App\Repository\Hotel\HotelRepository;

class HotelPageService implements HotelPageInterface
{
    private $hotelRepository;


    public function __construct(HotelRepository $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
    }
    public function getHotel(string $id)
    {
        return $this->hotelRepository->findHotelById($id);

    }

    public function addComment()
    {
        $form;
    }

}