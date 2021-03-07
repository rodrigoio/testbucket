<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Base;

use TestBucket\Core\Domain\Virtual\Contracts\Range;
use TestBucket\Core\Domain\Virtual\Contracts\RangeList;
use TestBucket\Core\Domain\Virtual\Contracts\RangeIterator;
use ArrayObject;

class BaseRangeList implements RangeList
{
    protected $list;

    public function __construct()
    {
        $this->list = new ArrayObject();
    }

    public function add(Range $range) : void
    {
        $this->list->append($range);
    }

    public function get(int $index) : ?Range
    {
        if ($this->list->offsetExists($index)) {
            return $this->list->offsetGet($index);
        }
        return null;
    }

    public function set(Range $range, int $index) : void
    {
        if ($this->list->offsetExists($index)) {
            $this->list->offsetSet($index, $range);
        }
    }

    public function count() : int
    {
        return $this->list->count();
    }

    public function last() : ?Range
    {
        if ($this->list->count() > 0) {
            return $this->list->offsetGet($this->list->count() - 1);
        }
        return null;
    }

    public function getIterator() : RangeIterator
    {
        return new BaseRangeIterator( $this );
    }
}
