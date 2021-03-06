<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Contracts;

interface Range extends Domain
{
    public function __construct(ElementCalculable $start, ElementCalculable $end, AbstractFactory $abstractFactory);

    public function union(Range $domain) : RangeList;

    public function difference(Range $domain) : RangeList;

    public function reaches(Range $domain) : bool;

    public function equals(Range $domain) : bool;

    public function getStartValue() : ?ElementCalculable;

    public function getEndValue() : ?ElementCalculable;
}
