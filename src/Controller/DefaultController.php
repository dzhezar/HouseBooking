<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 30.12.18
 * Time: 23:40
 */

namespace App\Controller;


use App\Service\qq;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(qq $qq): Response
    {
        $hotels = $qq->getUsers();

        dd($hotels);
        return $this->render('base.html.twig',[
            'hotels' => $hotels
        ]);

    }
}