<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Contracts;

interface RangeIterator
{
    public function __construct(RangeList $list);

    public function current() : Range;

    public function next() : void;

    public function key() : int;

    public function valid() : bool;

    public function rewind() : void;
}
