<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Controller;

use App\Dto\HotelFilter;
use App\Dto\HotelSearchForm;
use App\Form\FilterForm;
use App\Form\HotelSearchFormType;
use App\Service\CabinetPage\CabinetPageService;
use App\Service\HomePage\HomePageServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends AbstractController
{
    public function index(Request $request, HomePageServiceInterface $service): Response
    {
        $mainHotels = $service->getMainHotels();

        $formDto = new HotelSearchForm();

        $form = $this->createForm(HotelSearchFormType::class, $formDto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = new Session();
            $session->set('guests', $formDto->getGuests());
            $session->set('startDate', $formDto->getStartDate());
            $session->set('endDate', $formDto->getEndDate());



            return $this->redirectToRoute('searchresult', [
                                                                'city' => $formDto->getCity(),
                                                                'guests' => $formDto->getGuests(),
                                                                'startDate' => $formDto->getStartDate(),
                                                                'endDate' => $formDto->getEndDate(),
                                                                ]);
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'mainHotels' => $mainHotels,
        ]);
    }

    public function showSearchResult(Request $request, HomePageServiceInterface $service)
    {
        $city = $request->query->get('city');
        $guests = $request->query->get('guests');
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');
        $category = $request->query->get('category');
        $priceMin  = $request->query->get('priceMin');
        $priceMax  = $request->query->get('priceMax');
        $capacityMin  = $request->query->get('capacityMin');
        $capacityMax  = $request->query->get('capacityMax');

        $requestData = new HotelSearchForm($city, $guests, $startDate, $endDate);

        $filterData = new HotelFilter($category, $priceMin, $priceMax, $capacityMin, $capacityMax);

        if ($filterData->getCategory() == false) {
            $filterData->setCategory(new ArrayCollection());
        }

        $filterDto = new HotelFilter();
        $filterForm = $this->createForm(FilterForm::class,$filterDto);
        $filterForm->handleRequest($request);

        if ($filterForm->isSubmitted() && $filterForm->isValid()) {


            return $this->redirectToRoute('searchresult', [
                                                                'city' => $city,
                                                                'guests' => $guests,
                                                                'startDate' => $startDate,
                                                                'endDate' => $endDate,
                                                                'category' => \urlencode(\serialize($filterDto->getCategory())),
                                                                'priceMin' => $filterDto->getPriceMin(),
                                                                'priceMax' => $filterDto->getPriceMax(),
                                                                'capacityMin' => $filterDto->getCapacityMin(),
                                                                'capacityMax' => $filterDto->getCapacityMax(),
                                                                ]);
        }

        $searchResult = $service->searchHotels($requestData, $filterData);
        return $this->render('default/searchResult.html.twig', [
            'form' =>$filterForm->createView(),
            'hotels' => $searchResult,
            'city' => $city,
        ]);
    }


    public function search(Request $request, HomePageServiceInterface $service)
    {
        $result = $service->ajaxSearch($request->get('slug'));

        if (empty($result)) {
            return new Response('Not found');
        }

        return $this->render('default/ajax.html.twig', [
            'cities' =>$result,
        ]);
    }


    public function showCabinet(CabinetPageService $service)
    {
        $user = $this->getUser();

        $bookedHotels = $service->getBookedHotels($user->getId());
        $ownedHotels = $service->getOwnedHotels($user->getId());

        return $this->render('default/cabinet.html.twig', [
             'bookedHotels' => $bookedHotels,
             'ownedHotels' => $ownedHotels,
         ]);
    }
}
