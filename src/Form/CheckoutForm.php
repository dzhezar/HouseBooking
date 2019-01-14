<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 12.01.19
 * Time: 13:42
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CheckoutForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options):void
    {
        $builder
            ->add('FirstName',TextType::class)
            ->add('Surname',TextType::class)
            ->add('Email',EmailType::class)
            ->add('StartDate',TextType::class)
            ->add('EndDate',TextType::class)
            ->add('Guests',IntegerType::class)
        ;
    }
}