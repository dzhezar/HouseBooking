<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 31.12.18
 * Time: 12:41
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