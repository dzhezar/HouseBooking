<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Category;

use App\Dto\Category;

class CategoriesCollection implements \IteratorAggregate
{
    private $categories;

    public function __construct(Category ...$categories)
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->categories);
    }
}
