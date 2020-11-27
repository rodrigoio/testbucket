<?php
declare(strict_types=1);

namespace TestBucket\Core\Specification;

use Iterator;

class FieldIterator implements Iterator
{
    private $index;
    private $list;

    public function __construct(FieldList $list)
    {
        $this->list = $list;
        $this->rewind();
    }

    public function current() : Field
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
