<?php

declare(strict_types=1);

namespace App\Core\Combiner;

use ArrayObject;
use JsonSerializable;

class Aggregator implements JsonSerializable
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
            return $aggregator;
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

    public function add(Tuple $tuple): void
    {
        $this->tuples->offsetSet($tuple->getUniqueKey(), $tuple);
    }

    public function toArray(): array
    {
        return (array) $this->tuples;
    }

    public function makeClone()
    {
        return Aggregator::createFromArray((array) $this->tuples);
    }

    public function __toString()
    {
        return (string) $this->tuples[0];
    }

    public function jsonSerialize()
    {
        return $this->tuples;
    }
}
