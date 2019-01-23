<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Form;

use App\Dto\CategoryToIdTransformer;
use App\Dto\HotelFilter;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterForm extends AbstractType
{
    private $transformer;

    public function __construct(CategoryToIdTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('capacityMin', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 10
                ]
            ])
            ->add('capacityMax', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 10
                ]
            ])
            ->add('priceMin', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 1000
                ]
            ])
            ->add('priceMax', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 1000
                ]
            ])
        ;
        $builder->get('category')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HotelFilter::class,
        ]);
    }
}
