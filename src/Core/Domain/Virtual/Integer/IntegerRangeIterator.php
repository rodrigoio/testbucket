<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Virtual\Range;
use App\Core\Domain\Virtual\Integer\IntegerRangeList;

class IntegerRangeIterator implements \Iterator
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

    public function valid()
    {
        return $this->list->get($this->index) != null;
    }

    public function rewind()
    {
        $this->index = 0;
    }
}