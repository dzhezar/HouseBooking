<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 01.01.19
 * Time: 16:55
 */

namespace App\Form;


use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class HomeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options):void
    {
        $builder
            ->add('City',TextType::class)
            ->add('StartDate',HiddenType::class,[
                'data' => $this->getDates()['start']
            ])
            ->add('EndDate',HiddenType::class,[
                'data' => $this->getDates()['end']
            ])
            ->add('Guests',IntegerType::class)
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