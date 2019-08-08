<?php
namespace App\Core\Domain;

use App\Core\DataStructures\Collection;

interface Domain
{
    public function has($element) : bool;

    public function isEmpty() : bool;

    public function getElements() : Collection;

    public function add(Domain $d);

    public function subtract(Domain $d);

    public function intersect(Domain $d);

    public function excludeIntersect(Domain $d);
}
