<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 10.01.19
 * Time: 23:34
 */

namespace App\Dto;


class City
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}