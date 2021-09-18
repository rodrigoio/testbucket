<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

use ArrayObject;

class AggregatorList
{
    private $list;

    public function __construct()
    {
        $this->list = new ArrayObject();
    }

    public static function createFromArray(array $aggregatorArray)
    {
        $aggregatorList = new AggregatorList();

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

    public function count(): int
    {
        return $this->list->count();
    }

    public function getIterator(): AggregatorIterator
    {
        return new AggregatorIterator($this);
    }
}
