<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Contracts;

interface RangeList
{
    public function add(Range $range) : void;

    public function get(int $index) : ?Range;

    public function set(Range $range, int $index) : void;

    public function count() : int;

    public function last() : ?Range;

    public function getIterator() : RangeIterator;
}
