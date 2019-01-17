<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 30.12.18
 * Time: 23:40
 */

namespace App\Controller;


use App\Form\FilterForm;
use App\Form\HomeForm;
use App\Service\CabinetPage\CabinetPageService;
use App\Service\HomePage\HomePageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DefaultController extends AbstractController
{
    public function index(Request $request,HomePageServiceInterface $service): Response
    {
        $mainHotels = $service->getMainHotels();

        $form = $this->createForm(HomeForm::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $service->handleForm($form->getData());
            return $this->redirectToRoute('searchresult');
        }

        return $this->render('default/index.html.twig',[
            'form' => $form->createView(),
            'mainHotels' => $mainHotels
        ]);
    }

    public function showSearchResult(Request $request, HomePageServiceInterface $service)
    {
        $session = new Session();
        $city = $session->get('city');

        $filterForm = $this->createForm(FilterForm::class);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted()){
            $searchResult = $service->searchByFilter($filterForm->getData());
        }
        else{
            $searchResult = $service->searchHotels($service->getData());
        }

        return $this->render('default/searchResult.html.twig',[
            'form' =>$filterForm->createView(),
            'hotels' => $searchResult,
            'city' => $city,
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


    public function showCabinet(CabinetPageService $service, AuthenticationUtils $authenticationUtils)
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = $service->getUser($lastUsername);

        $bookedHotels = $service->getBookedHotels($user->getId());
        $ownedHotels = $service->getOwnedHotels($user->getId());

        return $this->render('default/cabinet.html.twig',[
             'bookedHotels' => $bookedHotels,
             'ownedHotels' => $ownedHotels,
         ]);

    }

}