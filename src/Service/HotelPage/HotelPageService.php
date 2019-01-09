<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 08.01.19
 * Time: 3:00
 */

namespace App\Service\HotelPage;


use App\Entity\Comment;
use App\Entity\User;
use App\Repository\Hotel\HotelRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HotelPageService implements HotelPageInterface
{
    private $hotelRepository;
    private $userRepository;


    public function __construct(HotelRepository $hotelRepository, UserRepository $userRepository)
    {
        $this->hotelRepository = $hotelRepository;
        $this->userRepository = $userRepository;
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

        return $comment;
    }
}