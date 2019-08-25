<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Domain;
use App\Core\Domain\Virtual\Range;
use App\Core\Domain\ElementInterface;

class EmptyDomain implements Domain, Range
{
    public function has(ElementInterface $element): bool
    {
        return false;
    }

    public function add(Domain $domain): Domain
    {
        return $domain;
    }

    public function subtract(Domain $domain): Domain
    {
        return $this;
    }

    public function getStartValue(): ElementInterface
    {
        return new Element('E');
    }

    public function getEndValue(): ElementInterface
    {
        return new Element('E');
    }
}
