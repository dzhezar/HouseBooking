<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 30.12.18
 * Time: 23:26
 */

namespace App\Service\HomePage;


use App\Hotel\HotelCollection;
use App\Hotel\HotelMapper;
use App\Repository\City\CityRepository;
use App\Repository\Hotel\HotelRepository;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class HomePageService implements HomePageServiceInterface
{
    private $hotelRepository;
    private $cityRepository;
    private $imageRepository;
    private $em;

    public function __construct(HotelRepository $hotelRepository, CityRepository $cityRepository, ImagesRepository $imageRepository,EntityManagerInterface $em)
    {
        $this->hotelRepository = $hotelRepository;
        $this->cityRepository = $cityRepository;
        $this->imageRepository =$imageRepository;
        $this->em = $em;
    }

    public function ajaxSearch(string $text)
    {
        return $this->cityRepository->ajaxSearch($text);

    }
    public function searchHotels(array $form)
    {
        $begin = $form['StartDate'];
        $end = $form['EndDate'];

        $hotels = $this->hotelRepository->findFreeHotels($form['City'],$form['Guests']);
        $collection = new HotelCollection();
        $dataMapper = new HotelMapper();

        foreach ($hotels as $hotel) {
            $bool = false;
            $busyDays = $dataMapper->entityToDto($hotel)->getBusyDays()->getBusyDays();

            foreach ($busyDays as $busyDay) {
                $userDate = $busyDay->getDate()->format('Y/m/d');
                if($this->check_in_range($begin,$end,$userDate)){
                    $bool = true;
                    break;
                }
            }
            if (!$bool) {
                $collection->addHotel($dataMapper->entityToDto($hotel));
            }
        }
        return $collection;

    }

    private function check_in_range(string $start_date,string $end_date,string $date_from_user):bool
    {

        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);

        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }

    public function getMainHotels(): HotelCollection
    {
        $mainHotels = $this->hotelRepository->findNumberOfHotels(4);
        $dataMapper = new HotelMapper();
        $collection = new HotelCollection();

        foreach ($mainHotels as $mainHotel){
            $collection->addHotel($dataMapper->entityToDto($mainHotel));
        }
    return $collection;
    }

    public function handleForm(array $form)
    {
        $begin = $form['StartDate'];
        $end = $form['EndDate'];
        $guests = $form['Guests'];
        $city = $form['City'];

        $session = new Session();
        $session->set('startDate', $begin);
        $session->set('endDate', $end);
        $session->set('guests', $guests);
        $session->set('city', $city);
    }
    public function getData(): array
    {
        $session = new Session();
        $data['StartDate'] = $session->get('startDate');
        $data['EndDate'] = $session->get('endDate');
        $data['Guests'] = $session->get('guests');
        $data['City'] = $session->get('city');

        return $data;
    }
    public function searchByFilter($data)
    {
        $session = new Session();
        $city = $this->cityRepository->findOneBy(['name' => $session->get('city')]);
        $cityId = $city->getId();

        $result = $this->hotelRepository->filterHotels($data, $cityId);
        $collection = new HotelCollection();
        $dataMapper = new HotelMapper();
        foreach ($result as $value){
            $collection->addHotel($dataMapper->entityToDto($value));
        }
        return $collection;
    }
}
