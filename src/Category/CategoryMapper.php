<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
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
