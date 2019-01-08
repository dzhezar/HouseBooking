<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 30.12.18
 * Time: 23:40
 */

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Images;
use App\Form\CommentForm;
use App\Form\HomeForm;
use App\Service\HomePage\HomePageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(Request $request,HomePageServiceInterface $service): Response
    {
        $mainHotels = $service->getMainHotels();

        $form = $this->createForm(HomeForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $searchResult = $service->searchHotels($form->getData());
            $city = $form->getData()['City'];
            return $this->render('default/searchResult.html.twig',[
                'hotels' => $searchResult,
                'city' => $city
            ]);
        }

        return $this->render('default/index.html.twig',[
            'form' => $form->createView(),
            'mainHotels' => $mainHotels
        ]);
    }

    public function search(Request $request, HomePageServiceInterface $service)
    {
        $result = $service->ajaxSearch($request->get('slug'));
        if(empty($result)){
            return new Response('Not found');
        }
        return $this->render('default/ajax.html.twig',[
            'cities' =>$result
        ]);
    }
    public function searchResult($hotels)
    {
        return $this->render('default/searchResult.html.twig',[
            'hotels' => $hotels
        ]);
    }

}