<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    private const CATEGORIES = ['Apartment','Hotel','Hostel'];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName) {
            $category = new Category();
            $category
                ->setName($categoryName);


            $manager->persist($category);

            $this->addReference(Category::class . '_' . $key, $category);
        }
        $manager->flush();
    }
}
