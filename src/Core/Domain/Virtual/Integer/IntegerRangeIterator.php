<?php
declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Integer;

use Iterator;
use TestBucket\Core\Domain\Virtual\Range;

class IntegerRangeIterator implements Iterator
{
    private $index;
    private $list;

    public function __construct(IntegerRangeList $list)
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