<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 3:35
 */

namespace App\Category;


use App\Dto\Category as CategoryDto;
use App\Entity\Category;

class CategoryMapper
{
    public function entityToDto(Category $entity): CategoryDto
    {
        return new CategoryDto(
            $entity->getName()
        );
    }
}