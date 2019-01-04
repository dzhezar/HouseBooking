<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 02.01.19
 * Time: 22:34
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