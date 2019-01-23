<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\User;

use App\Dto\User;

class UserCollection implements \IteratorAggregate
{
    private $users;

    public function __construct(User ...$users)
    {
        $this->users = $users;
    }

    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->users);
    }
}
