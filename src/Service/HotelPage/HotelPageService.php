<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 08.01.19
 * Time: 3:00
 */

namespace App\Service\HotelPage;


use App\Entity\BusyDays;
use App\Entity\City;
use App\Entity\Comment;
use App\Entity\Hotel;
use App\Entity\Images;
use App\Entity\User;
use App\Repository\BusyDays\BusyDaysRepository;
use App\Repository\Hotel\HotelRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HotelPageService implements HotelPageInterface
{
    private $hotelRepository;
    private $userRepository;
    private $busyDaysRepository;
    private $em;
    private $authenticationUtils;

    public function __construct(HotelRepository $hotelRepository, UserRepository $userRepository, BusyDaysRepository $busyDaysRepository, EntityManagerInterface $em, AuthenticationUtils $authenticationUtils)
    {
        $this->hotelRepository = $hotelRepository;
        $this->userRepository = $userRepository;
        $this->busyDaysRepository = $busyDaysRepository;
        $this->em = $em;
        $this->authenticationUtils = $authenticationUtils;
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

    public function setHotel(array $form): Hotel
    {
        $lastUsername = $this->authenticationUtils->getLastUsername();
        $user = $this->getUser($lastUsername);
        $address = explode(',',$form['pacInput']);
        $city = $this->em->getRepository(City::class)->findOneBy(['name' => ltrim($address[2])]);


        if (empty($city)){
            $city = new City();
            $city->setName(ltrim($address[2]));
            $this->em->persist($city);
            $this->em->flush();
        }
        $hotel = new Hotel();
        $hotel
            ->setName($form['name'])
            ->setCategory($form['category'])
            ->setCity($city)
            ->setDescription($form['description'])
            ->setOwner($user)
            ->setCapacity($form['capacity'])
            ->setPrice($form['price'])
            ->setAddress($form['pacInput'])
            ->setCoordinates($form['info'])
            ;
        $this->em->persist($hotel);
        $this->em->flush();



        return $hotel;
    }

    public function setImage(Hotel $hotel, string $fileName)
    {
        $file = new Images();
        $file
            ->setHotel($hotel)
            ->setImage('/uploads/images/'.$fileName)
        ;

        $this->em->persist($file);
        $this->em->flush();
    }

    public function deleteHotel(Hotel $hotel, $publicDir)
    {
        $city = $hotel->getCity();
        $hotelsInSameCity = $this->em->getRepository(Hotel::class)->findBy(['city' => $city]);

        $images = $this->em->getRepository(Images::class)->findBy(['hotel' => $hotel]);
        foreach ($images as $image){
            unlink($publicDir.$image->getImage());
            $this->em->remove($image);
        }
        $this->em->flush();

        $comments = $this->em->getRepository(Comment::class)->findBy(['hotel' => $hotel]);
        foreach ($comments as $comment) {
            $this->em->remove($comment);
        }
        $this->em->flush();

        $busyDays = $this->em->getRepository(BusyDays::class)->findBy(['hotel' => $hotel]);
        foreach ($busyDays as $busyDay) {
            $this->em->remove($busyDay);
        }
        $this->em->flush();

        $this->em->remove($hotel);

        if (count($hotelsInSameCity) == 1){
            $this->em->remove($city);
        }
        $this->em->flush();
    }
}