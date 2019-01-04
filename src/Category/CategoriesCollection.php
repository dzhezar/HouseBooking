<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 30.12.18
 * Time: 23:24
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