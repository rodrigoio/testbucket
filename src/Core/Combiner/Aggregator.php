<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

use ArrayObject;
use InvalidArgumentException;

class Aggregator
{
    private $id;
    private $tuples;

    public function __construct()
    {
        $this->id = rand(0, 199);
        $this->tuples = new ArrayObject();
    }

    public static function createFromArray(array $tuples): Aggregator
    {
        $aggregator = new Aggregator();

        if (empty($tuples)) {
            throw new InvalidArgumentException("Invalid empty field");
        }

        foreach ($tuples as $oneTuple) {
            $aggregator->add($oneTuple);
        }
        return $aggregator;
    }

    public static function createFromTuple(Tuple $tuple): Aggregator
    {
        $aggregator = new Aggregator();
        $aggregator->add($tuple);
        return $aggregator;
    }

    public function split(): AggregatorList
    {
        $list = new AggregatorList();

        foreach ($this->tuples as $tuple) {
            $list->add(Aggregator::createFromTuple($tuple));
        }

        return $list;
    }

    public function add(Tuple $tuple): void
    {
        $this->tuples->offsetSet($tuple->getUniqueKey(), $tuple);
    }

    public function count(): int
    {
        return $this->tuples->count();
    }

    public function toArray(): array
    {
        return (array) $this->tuples;
    }

    public function makeClone()
    {
        return Aggregator::createFromArray((array) $this->tuples);
    }
}
