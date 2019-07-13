<?php
namespace App\Core\DataStructures;

use App\Domain\Element;

interface Collection
{
    public function isEmpty() : bool;

    public function add(Element $e);

    public function remove(Element $e);
}
