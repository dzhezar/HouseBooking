<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Form;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CheckoutForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', TextType::class)
            ->add('Surname', TextType::class)
            ->add('Email', EmailType::class)
            ->add('StartDate', TextType::class,[
                'data' => $this->getDates()['start']
            ])
            ->add('EndDate', TextType::class,[
                'data' => $this->getDates()['end']
            ])
            ->add('Guests', IntegerType::class)
        ;
    }

    private function getDates()
    {
        $dates['start'] = date('Y-m-d');
        $date =  new DateTime();
        $dates['end'] = $date->modify('+1 week')->format('Y-m-d');
        return $dates;
    }
}
