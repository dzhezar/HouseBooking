<?php

/*
 * This file is part of the "HouseBooking-project" package.
 * (c) Dzhezar Kadyrov <dzhezik@gmail.com>
 */

namespace App\Comment;

use App\Dto\Comment;

class CommentsCollection implements \IteratorAggregate
{
    private $comments;

    public function __construct(Comment ...$comments)
    {
        $this->comments = $comments;
    }

    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->comments);
    }
}
