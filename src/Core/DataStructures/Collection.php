<?php
namespace App\Core\DataStructures;

interface Collection extends \IteratorAggregate
{
    public function isEmpty() : bool;

    public function add($element) : void;

    public function remove($element) : void;

    public function getIterator() : \ArrayIterator;
}
