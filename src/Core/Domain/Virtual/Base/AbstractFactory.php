<?php

namespace TestBucket\Core\Domain\Virtual\Base;

use TestBucket\Core\Domain\Virtual\Contracts\Factory;
use TestBucket\Core\Domain\Virtual\Contracts\ElementCalculable;
use TestBucket\Core\Domain\Virtual\Contracts\ElementPrecision;
use TestBucket\Core\Domain\Virtual\Contracts\Range;
use TestBucket\Core\Domain\Virtual\Contracts\RangeList;
use TestBucket\Core\Domain\Virtual\Contracts\RangeSet;

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
