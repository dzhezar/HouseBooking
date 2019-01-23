<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Form;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddHotelForm extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('category', ChoiceType::class, [
                'choices'  => $this->getCategories(),

                'choice_label' => function ($category, $key, $value) {
                    /* @var Category $category */
                    return $category->getName();
                },
                ])
            ->add('capacity', IntegerType::class)
            ->add('description', TextareaType::class)
            ->add('price', IntegerType::class)
            ->add('pacInput', TextType::class)
            ->add('info', HiddenType::class)
            ->add('images', FileType::class, [
                'label' => 'Images',
                'multiple' => true,
            ])
            ;
    }


    private function getCategories()
    {
        return $this->em->getRepository(Category::class)->findAll();
    }
}
