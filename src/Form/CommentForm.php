<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 07.01.19
 * Time: 18:36
 */

namespace App\Form;


use App\Security\LoginFormAuthenticator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options):void
    {
        $qq = new LoginFormAuthenticator();
        $builder
            ->add('Comment',TextareaType::class)
            ->add('User',HiddenType::class)
        ;
    }
}