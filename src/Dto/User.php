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
    private $firstName;
    private $surname;
    private $email;

    public function __construct(string $username, string $firstName, string $surname, string $email)
    {
        $this->username = $username;
        $this->firstName = $firstName;
        $this->surname = $surname;
        $this->email = $email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}