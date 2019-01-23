<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Service\FilenameGeneration;

class StrategySha1 implements StrategyInterface
{
    public function generateFilename(string $id): string
    {
        return \sha1($id);
    }
}
