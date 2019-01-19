<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 30.12.18
 * Time: 23:40
 */

namespace App\Controller;


use App\Dto\HotelSearchForm;
use App\Form\FilterForm;
use App\Form\HotelSearchFormType;
use App\Hotel\HotelFilter;
use App\Service\CabinetPage\CabinetPageService;
use App\Service\HomePage\HomePageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends AbstractController
{
    public function index(Request $request, HomePageServiceInterface $service): Response
    {
        $mainHotels = $service->getMainHotels();

        $form = $this->createForm(HotelSearchFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            list('City' => $city,'Guests'=> $guests,'StartDate'=> $startDate,'EndDate'=> $endDate) =  $formData ;
            $session = new Session();
            $session->set('guests',$guests);
            $session->set('startDate',$startDate);
            $session->set('endDate',$endDate);

            $formDto = new HotelSearchForm($city,$guests,$startDate,$endDate);

            return $this->redirectToRoute('searchresult',[
                                                                'city' => $formDto->getCity(),
                                                                'guests' => $formDto->getGuests(),
                                                                'startDate' => $formDto->getStartDate(),
                                                                'endDate' => $formDto->getEndDate()
                                                                ]);
        }

        return $this->render('default/index.html.twig',[
            'form' => $form->createView(),
            'mainHotels' => $mainHotels
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

        $requestData = new HotelSearchForm($city,$guests,$startDate,$endDate,$category,$priceMin,$priceMax,$capacityMin,$capacityMax);

        $filterForm = $this->createForm(FilterForm::class);
        $filterForm->handleRequest($request);
        if ($filterForm->isSubmitted() && $filterForm->isValid()){

            $filterInfo = $filterForm->getData();
            $filterData = new HotelFilter($filterInfo['category'],$filterInfo['priceMin'],$filterInfo['priceMax'],$filterInfo['capacityMin'],$filterInfo['capacityMax']);

            return $this->redirectToRoute('searchresult',[
                                                                'city' => $city,
                                                                'guests' => $guests,
                                                                'startDate' => $startDate,
                                                                'endDate' => $endDate,
                                                                'category' => urlencode(serialize($filterData->getCategories()->getValues())),
                                                                'priceMin' => $filterData->getPriceMin(),
                                                                'priceMax' => $filterData->getPriceMax(),
                                                                'capacityMin' => $filterData->getCapacityMin(),
                                                                'capacityMax' => $filterData->getCapacityMax()
                                                                ]);
        }

        $searchResult = $service->searchHotels($requestData);


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


    public function showCabinet(CabinetPageService $service)
    {
        $user = $this->getUser();

        $bookedHotels = $service->getBookedHotels($user->getId());
        $ownedHotels = $service->getOwnedHotels($user->getId());

        return $this->render('default/cabinet.html.twig',[
             'bookedHotels' => $bookedHotels,
             'ownedHotels' => $ownedHotels,
         ]);

    }

}