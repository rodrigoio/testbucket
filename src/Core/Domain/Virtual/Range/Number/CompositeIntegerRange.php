<?php
namespace App\Core\Domain\Virtual\Range\Number;

use App\Core\Domain\Domain;
use App\Core\Domain\Element\ElementInterface;
use App\Core\Domain\Virtual\Range\Range;

class CompositeIntegerRange implements Range,Domain
{
    protected $startValue;
    protected $endValue;
    protected $ranges;

    public function __construct(\ArrayObject $ranges)
    {
        $this->ranges = $ranges;
    }

    //TODO: test the use of composite for range domains.
    public function has(ElementInterface $element): bool
    {
        // TODO: Implement has() method.
    }

    public function add(Domain $domain): Domain
    {
        // TODO: Implement add() method.
    }

    public function subtract(Domain $domain): Domain
    {
        // TODO: Implement subtract() method.
    }

    public function intersect(Domain $domain): Domain
    {
        // TODO: Implement intersect() method.
    }

    public function excludeIntersect(Domain $domain): Domain
    {
        // TODO: Implement excludeIntersect() method.
    }

    public function getStartValue() : ElementInterface
    {
        // TODO: Implement getStartValue() method.
    }

    public function getEndValue() : ElementInterface
    {
        // TODO: Implement getEndValue() method.
    }
}
