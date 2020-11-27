<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

use ArrayObject;
use JsonSerializable;

class AggregatorList implements JsonSerializable
{
    private $list;

    public function __construct()
    {
        $this->list = new ArrayObject();
    }

    public static function createFromArray(array $aggregatorArray)
    {
        $aggregatorList = new AggregatorList();

        if (empty($aggregatorArray)) {
            return $aggregatorList;
        }

        foreach ($aggregatorArray as $oneAggregator) {
            $aggregatorList->add($oneAggregator);
        }

        return $aggregatorList;
    }

    public function add(Aggregator $aggregator): void
    {
        $this->list->append($aggregator);
    }

    public function appendList(AggregatorList $list): void
    {
        $iterator = $list->getIterator();

        while($iterator->valid()) {
            $this->add($iterator->current());
            $iterator->next();
        }
    }

    public function get(int $index): ?Aggregator
    {
        if ($this->list->offsetExists($index)) {
            return $this->list->offsetGet($index);
        }
        return null;
    }

    public function set(Aggregator $aggregator, int $index): void
    {
        if ($this->list->offsetExists($index)) {
            $this->list->offsetSet($index, $aggregator);
        }
    }

    public function count() : int
    {
        return $this->list->count();
    }

    public function last() : ?Aggregator
    {
        if ($this->list->count() > 0) {
            return $this->list->offsetGet($this->list->count() - 1);
        }
        return null;
    }

    public function getIterator() : AggregatorIterator
    {
        return new AggregatorIterator($this);
    }

    public function jsonSerialize()
    {
        return $this->list;
    }
}
