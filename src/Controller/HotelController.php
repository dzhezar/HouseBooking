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
use App\Form\CheckoutForm;
use App\Form\CommentForm;
use App\Service\HotelPage\HotelPageInterface;
use App\Service\HotelPage\HotelPageService;
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
            $service->setComment($id, $form->getData()['Text'],$user);

            return $this->redirect($request->getUri());
        }
        return $this->render('default/hotel.html.twig',[
            'form' => $form->createView(),
            'hotel' => $hotel,
            'comments' => $comments,
            'images' => $images
        ]);
    }
    public function checkoutHotel(string $id, HotelPageService $service,  Request $request, AuthenticationUtils $authenticationUtils, \Swift_Mailer $mailer)
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $service->getUser($lastUsername);
        $hotel = $service->getHotel($id);

        $session = new Session();
        $startDate = $session->get('startDate');
        $endDate = $session->get('endDate');
        $guests =  $session->get('guests');

        $form = $this->createForm(CheckoutForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $nightsCount = $service->setCheckoutDays($id, $form->getData(), $user);

            $message = (new \Swift_Message("You have booked a hotel " ))
                ->setFrom('dzhezik@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/checkoutToUser.html.twig', [
                            'user' => $user,
                            'hotel' => $hotel,
                            'nights' => $nightsCount,
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                            'guests'=> $guests
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $message = (new \Swift_Message('Somebody booked your hotel'))
                ->setFrom('dzhezik@gmail.com')
                ->setTo($hotel->getOwner()->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/checkoutToOwner.html.twig', [
                            'user' => $user,
                            'hotel' => $hotel,
                            'nights' => $nightsCount,
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                            'guests' => $guests
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $this->redirectToRoute('index');
        }

        return $this->render('default/checkout.html.twig',[
            'form' => $form->createView(),
            'hotel' => $hotel,
            'user' => $user,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'guests' => $guests
        ]);
    }
}