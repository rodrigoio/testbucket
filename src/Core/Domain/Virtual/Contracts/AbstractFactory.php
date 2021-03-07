<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Contracts;

interface AbstractFactory
{
    public function createRangeList(): RangeList;

    public function createRangeSet(): RangeSet;

    public function createRange(ElementCalculable $start, ElementCalculable $end): Range;

    public function createElement($value): ElementCalculable;

    public function createInfinityElement(): ElementCalculable;

    public function createPrecision(): ElementPrecision;
}
