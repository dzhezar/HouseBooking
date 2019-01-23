<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Dto;

use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class CategoryToIdTransformer implements DataTransformerInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function transform($category)
    {
        // TODO : Implement transform method
    }

    public function reverseTransform($category)
    {
        if (null == $category) {
            return new ArrayCollection();
        }
        $categories = $category->map(function (Category $category) {
            return $category;
        });

        return $categories;
    }
}
