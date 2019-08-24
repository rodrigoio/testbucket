<?php
namespace App\Core\Domain;

use App\Core\Domain\ElementInterface;

interface Domain
{
    public function has(ElementInterface $element) : bool;

    public function add(Domain $domain) : Domain;

    public function subtract(Domain $domain) : Domain;

    public function intersect(Domain $domain) : Domain;

    public function excludeIntersect(Domain $domain) : Domain;
}
