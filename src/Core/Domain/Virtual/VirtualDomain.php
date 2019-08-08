<?php
namespace App\Core\Domain\Virtual;

use App\Core\Domain\Domain;
use App\Core\DataStructures\Collection;
use App\Core\DataSource\DataSource;

class VirtualDomain implements Domain
{
    public function __construct(DataSource $dt)
    {

    }

    public function has($element) : bool
    {

    }

    public function isEmpty() : bool
    {

    }

    public function getElements() : Collection
    {

    }

    public function add(Domain $d)
    {

    }

    public function subtract(Domain $d){

    }

    public function intersect(Domain $d)
    {

    }

    public function excludeIntersect(Domain $d)
    {

    }
}
