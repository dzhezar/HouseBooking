<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 07.01.19
 * Time: 23:01
 */

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Images;
use App\Form\CommentForm;
use App\Security\LoginFormAuthenticator;
use App\Service\HotelPage\HotelPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HotelController extends AbstractController
{
     public function showHotel(string $id, HotelPageInterface $service, Request $request, LoginFormAuthenticator $authenticator)
    {
        $coments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['hotel' => $id]);
        $images = $this->getDoctrine()->getRepository(Images::class)->findBy(['hotel' => $id]);
        $hotel = $service->getHotel($id);
        $form = $this->createForm(CommentForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

        }

        return $this->render('default/hotel.html.twig',[
            'form' => $form->createView(),
            'hotel' => $hotel,
            'comments' => $coments,
            'images' => $images
        ]);
    }
}