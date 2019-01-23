<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Service\FilenameGeneration;

class StrategyMd5 implements StrategyInterface
{
    public function generateFilename(string $id): string
    {
        return \md5($id);
    }
}
