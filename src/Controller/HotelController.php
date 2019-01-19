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
use App\Form\AddHotelForm;
use App\Form\CheckoutForm;
use App\Form\CommentForm;
use App\Service\HotelPage\HotelPageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class HotelController extends AbstractController
{
     public function showHotel(string $id, HotelPageServiceInterface $service, Request $request)
    {
        $comments = $this->getDoctrine()->getRepository(Comment::class)->findBy(['hotel' => $id]);
        $images = $this->getDoctrine()->getRepository(Images::class)->findBy(['hotel' => $id]);
        $hotel = $service->getHotel($id);
        $form = $this->createForm(CommentForm::class);
        $form->handleRequest($request);
        $user = $this->getUser();

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
    public function checkoutHotel(string $id, HotelPageServiceInterface $service,  Request $request)
    {
        $user = $this->getUser();
        $email = $this->getParameter('email');
        $hotel = $service->getHotel($id);
        $startDate = $this->get('session')->get('startDate');
        $endDate = $this->get('session')->get('endDate');
        $guests =  $this->get('session')->get('guests');

        $form = $this->createForm(CheckoutForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $nightsCount = $service->setCheckoutDays($id, $form->getData(), $user);
            $service->mailToUser($email,$user,$hotel,$nightsCount,$startDate, $endDate, $guests);
            $service->mailToOwner($email,$user,$hotel,$nightsCount,$startDate, $endDate, $guests);

            return $this->redirectToRoute('cabinet');
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

    public function addHotel(HotelPageServiceInterface $service,Request $request)
    {
        $form = $this->createForm(AddHotelForm::class);
        $form->handleRequest($request);
        $user = $this->getUser();


        if($form->isSubmitted() && $form->isValid()) {

                $hotel = $service->setHotel($user, $form->getData());
                foreach ($form->getData()['images'] as $image) {
                    $fileName = md5(uniqid()) . '.' . $image->guessExtension();
                    $service->setImage($hotel, $fileName);

                    try {
                        $image->move(
                            $this->getParameter('images_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {

                    }

                }
                return $this->redirectToRoute('cabinet');


        }

        return $this->render('default/addHotel.html.twig',[
            'form' => $form->createView(),

        ]);
    }

    public function unpublishHotel(string $id, HotelPageServiceInterface $service)
    {
        $hotel = $service->getHotel($id);
        $service->unpublishHotel($hotel);
        return $this->redirectToRoute('cabinet');
    }

    public function publishHotel(string $id, HotelPageServiceInterface $service)
    {
        $hotel = $service->getHotel($id);
        $service->publishHotel($hotel);
        return $this->redirectToRoute('cabinet');
    }

    public function deleteHotel(string $id, HotelPageServiceInterface $service)
    {

        $imagesDir = $this->getParameter('images_directory');
        $hotel = $service->getHotel($id);
        $service->deleteHotel($hotel, $imagesDir);
        return $this->redirectToRoute('cabinet');
    }
}