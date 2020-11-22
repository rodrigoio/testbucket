<?php

declare(strict_types=1);

namespace App\Core\Combiner;

use Iterator;

class AggregatorIterator implements Iterator
{
    private $index;
    private $list;

    public function __construct(AggregatorList $list)
    {
        $this->list = $list;
        $this->rewind();
    }

    public function current(): Aggregator
    {
        return $this->list->get($this->index);
    }

    public function next(): void
    {
        $this->index++;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return $this->list->get($this->index) != null;
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}
