<?php
namespace App\Domain;

interface Domain
{
    public function __construct(DataSource $dt);

    public function has(Element $e) : bool;

    public function isEmpty() : bool;

    public function getElements() : Collection;

    public function add(Domain $d);

    public function subtract(Domain $d);

    public function intersect(Domain $d);

    public function excludeIntersect(Domain $d);
}