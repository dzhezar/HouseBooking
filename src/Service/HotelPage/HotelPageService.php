<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
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
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class HotelPageService implements HotelPageServiceInterface
{
    private $hotelRepository;
    private $busyDaysRepository;
    private $em;
    private $mailer;
    private $environment;

    public function __construct(HotelRepository $hotelRepository, BusyDaysRepository $busyDaysRepository, EntityManagerInterface $em, \Swift_Mailer $mailer, Environment $environment)
    {
        $this->hotelRepository = $hotelRepository;
        $this->busyDaysRepository = $busyDaysRepository;
        $this->em = $em;
        $this->mailer = $mailer;
        $this->environment = $environment;
    }
    public function getHotel(string $id)
    {
        return $this->hotelRepository->findHotelById($id);
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

        $period = new \DatePeriod(
                new \DateTime($form['StartDate']),
                $interval,
                $realEnd
            );

        $nightsCounter = -1;

        foreach ($period as $date) {
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

    public function setHotel(User $user, array $form): Hotel
    {
        $address = \explode(',', $form['pacInput']);
        $city = $this->em->getRepository(City::class)->findOneBy(['name' => \ltrim($address[2])]);


        if (empty($city)) {
            $city = new City();
            $city->setName(\ltrim($address[2]));
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
            ->setIsPublished(true)
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
            ->setImage($fileName)
        ;

        $this->em->persist($file);
        $this->em->flush();
    }



    public function deleteHotel(Hotel $hotel, string $imagesDir)
    {
        $city = $hotel->getCity();
        $hotelsInSameCity = $this->em->getRepository(Hotel::class)->findBy(['city' => $city]);

        $images = $this->em->getRepository(Images::class)->findBy(['hotel' => $hotel]);

        foreach ($images as $image) {
            //\unlink($imagesDir . '/' . $image->getImage());
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

        if (1 == \count($hotelsInSameCity)) {
            $this->em->remove($city);
        }
        $this->em->flush();
    }

    public function unpublishHotel(Hotel $hotel)
    {
        $hotel->setIsPublished(false);
        $this->em->persist($hotel);
        $this->em->flush();
    }

    public function publishHotel(Hotel $hotel)
    {
        $hotel->setIsPublished(true);
        $this->em->persist($hotel);
        $this->em->flush();
    }

    public function mailToUser(string $email, User $user, Hotel $hotel, int $nightsCount, string $startDate, string $endDate, int $guests)
    {
        $message = (new \Swift_Message('You have booked a hotel '))
            ->setFrom($email)
            ->setTo($user->getEmail())
            ->setBody(
                $this->environment->render(
                    'email/checkoutToUser.html.twig',
                    [
                        'user' => $user,
                        'hotel' => $hotel,
                        'nights' => $nightsCount,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'guests'=> $guests,
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    public function mailToOwner(string $email, User $user, Hotel $hotel, int $nightsCount, string $startDate, string $endDate, int $guests)
    {
        $message = (new \Swift_Message('Somebody booked your hotel'))
            ->setFrom($email)
            ->setTo($hotel->getOwner()->getEmail())
            ->setBody(
                $this->environment->render(
                    'email/checkoutToOwner.html.twig',
                    [
                        'user' => $user,
                        'hotel' => $hotel,
                        'nights' => $nightsCount,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'guests' => $guests,
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }
}
