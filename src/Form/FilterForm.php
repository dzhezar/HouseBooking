<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 17.01.19
 * Time: 3:02
 */

namespace App\Form;


use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options): void
    {
        $builder
            ->add('category',EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'required' => false
            ])
            ->add('capacityMin',IntegerType::class, [
                'required' => false
            ])
            ->add('capacityMax',IntegerType::class, [
                'required' => false
            ])
            ->add('priceMin',IntegerType::class, [
                'required' => false
            ])
            ->add('priceMax',IntegerType::class, [
                'required' => false
            ])
        ;
    }
}