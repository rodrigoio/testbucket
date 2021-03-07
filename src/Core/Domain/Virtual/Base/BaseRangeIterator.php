<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Base;

use TestBucket\Core\Domain\Virtual\Contracts\Range;
use TestBucket\Core\Domain\Virtual\Contracts\RangeList;
use TestBucket\Core\Domain\Virtual\Contracts\RangeIterator;
use Iterator;

class BaseRangeIterator implements Iterator, RangeIterator
{
    /**
     * @var RangeList
     */
    protected $list;

    /**
     * @var int
     */
    protected $index;

    public function __construct(RangeList $list)
    {
        $this->list = $list;
        $this->rewind();
    }

    public function current() : Range
    {
        return $this->list->get($this->index);
    }

    public function next() : void
    {
        $this->index++;
    }

    public function key() : int
    {
        return $this->index;
    }

    public function valid() : bool
    {
        return $this->list->get($this->index) != null;
    }

    public function rewind() : void
    {
        $this->index = 0;
    }
}
