<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Service\FilenameGeneration;

class FilenameGeneratorService
{
    private $filename;
    private $randomNumber;

    public function __construct()
    {
        $this->randomNumber = $this->getRandomNumber();

        switch ($this->randomNumber) {
            case 1:
                $this->filename = \md5(\uniqid());
                break;
            case 2:
                $this->filename = \crc32(\uniqid());
                break;
            case 3:
                $this->filename = \sha1(\uniqid());
        }
    }

    public function getRandomNumber()
    {
        return \mt_rand(1, 3);
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
