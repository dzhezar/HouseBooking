<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 3:25
 */

namespace App\Dto;


class User
{
    private $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }

    public function getName(): string
    {
        return $this->username;
    }

}