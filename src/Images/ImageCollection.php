<?php
/**
 * Created by PhpStorm.
 * User: dzhezar-bazar
 * Date: 07.01.19
 * Time: 4:12
 */

namespace App\Images;

use App\Dto\Image;

class ImageCollection implements \IteratorAggregate
{
    private $images;

    public function __construct(Image ...$images)
    {
        $this->images = $images;
    }

    public function addImage(Image $image)
    {
        $this->images[] = $image;
    }
    public function getIterator()
    {
        return new \ArrayIterator($this->images);
    }

    public function shift(): Image
    {
        return \array_shift($this->images);
    }

}