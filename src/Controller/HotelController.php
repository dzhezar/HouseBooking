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
use App\Service\HotelPage\HotelPageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HotelController extends AbstractController
{
     public function showHotel(string $id, HotelPageInterface $service, Request $request, AuthenticationUtils $authenticationUtils)
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['hotel' => $id]);
        $images = $this->getDoctrine()->getRepository(Images::class)->findBy(['hotel' => $id]);
        $hotel = $service->getHotel($id);
        $form = $this->createForm(CommentForm::class);
        $form->handleRequest($request);
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $service->getUser($lastUsername);

        if ($form->isSubmitted() && $form->isValid()){
            $comment = $service->setComment($id, $form->getData()['Text'],$user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();


            return $this->redirect($request->getUri());
        }
        return $this->render('default/hotel.html.twig',[
            'form' => $form->createView(),
            'hotel' => $hotel,
            'comments' => $comments,
            'images' => $images
        ]);
    }
}