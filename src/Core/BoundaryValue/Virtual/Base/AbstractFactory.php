<?php

namespace TestBucket\Core\BoundaryValue\Virtual\Base;

use TestBucket\Core\BoundaryValue\Virtual\Contracts\Factory;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\ElementCalculable;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\ElementPrecision;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\Range;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\RangeList;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\RangeSet;

abstract class AbstractFactory implements Factory
{
    public function createRangeSet(): RangeSet
    {
        return new BaseRangeSet($this);
    }

    public function createRangeList(): RangeList
    {
        return new BaseRangeList();
    }

    public function createRange(ElementCalculable $start, ElementCalculable $end): Range
    {
        return new BaseRange($start, $end, $this);
    }

    public function createElement($value, ?ElementPrecision $elementPrecision=null): ElementCalculable
    {
        $element = new BaseElement($this, $value);
        if ($elementPrecision) {
            $element->setPrecision($elementPrecision);
        }
        return $element;
    }

    public function createInfinityElement(): ElementCalculable
    {
        return new BaseElement($this, null);
    }

    abstract public function createPrecision(): ElementPrecision;
}
