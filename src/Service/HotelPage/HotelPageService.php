<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 08.01.19
 * Time: 3:00
 */

namespace App\Service\HotelPage;


use App\Entity\BusyDays;
use App\Entity\Comment;
use App\Entity\Hotel;
use App\Entity\User;
use App\Repository\BusyDays\BusyDaysRepository;
use App\Repository\Hotel\HotelRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class HotelPageService implements HotelPageInterface
{
    private $hotelRepository;
    private $userRepository;
    private $busyDaysRepository;
    private $em;

    public function __construct(HotelRepository $hotelRepository, UserRepository $userRepository, BusyDaysRepository $busyDaysRepository, EntityManagerInterface $em)
    {
        $this->hotelRepository = $hotelRepository;
        $this->userRepository = $userRepository;
        $this->busyDaysRepository = $busyDaysRepository;
        $this->em = $em;
    }
    public function getHotel(string $id)
    {
        return $this->hotelRepository->findHotelById($id);
    }

    public function getUser(string $name)
    {
        return $this->userRepository->findUserByName($name);
    }

    public function setComment(string $id, string $text, User $user): Comment
    {
        $hotel = $this->getHotel($id);

        $comment = new Comment();
        $comment->setText($text)
            ->setAuthor($user)
            ->setHotel($hotel)
        ;
        $this->em->persist($comment);
        $this->em->flush();
        return $comment;
    }

    public function setCheckoutDays(string $id, array $form, User $user): int
    {
        $hotel = $this->getHotel($id);

        $interval = new \DateInterval('P1D');
        $realEnd = new \DateTime($form['EndDate']);
        $realEnd->add($interval);

        $period = new \DatePeriod(new \DateTime($form['StartDate']),
                                  $interval,
                                  $realEnd);
        $nightsCounter = -1;

        foreach ($period as $date){
            $busyDay = new BusyDays();
            $busyDay
                ->setUser($user)
                ->setHotel($hotel)
                ->setDate($date)
            ;
            $this->em->persist($busyDay);
            $nightsCounter++;
        }

        $this->em->flush();

        return $nightsCounter;
    }

}