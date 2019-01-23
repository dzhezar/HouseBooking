<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Service\FilenameGeneration;

interface StrategyInterface
{
    public function generateFilename(string $id): string;
}
