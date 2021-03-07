<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Integer;

use TestBucket\Core\Domain\Virtual\Contracts\AbstractFactory;
use TestBucket\Core\Domain\Virtual\Contracts\ElementCalculable;
use TestBucket\Core\Domain\Virtual\Contracts\ElementPrecision;
use TestBucket\Core\Domain\Virtual\Contracts\Range;
use TestBucket\Core\Domain\Virtual\Contracts\RangeList;
use TestBucket\Core\Domain\Virtual\Contracts\RangeSet;
use TestBucket\Core\Domain\Virtual\Integer\Precision\UnitPrecision;

class IntegerAbstractFactory implements AbstractFactory
{
    public function createRangeSet(): RangeSet
    {
        return new IntegerRangeSet($this);
    }

    public function createRangeList(): RangeList
    {
        return new IntegerRangeList();
    }

    public function createRange(ElementCalculable $start, ElementCalculable $end): Range
    {
        return new IntegerRange($start, $end, $this);
    }

    public function createElement($value, ?ElementPrecision $elementPrecision=null): ElementCalculable
    {
        $element = new Element($this, $value);
        if ($elementPrecision) {
            $element->setPrecision($elementPrecision);
        }
        return $element;
    }

    public function createInfinityElement(): ElementCalculable
    {
        return new Element($this, null);
    }

    public function createPrecision(?int $value=null): ElementPrecision
    {
        return new UnitPrecision($value);
    }
}
