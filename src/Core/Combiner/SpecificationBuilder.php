<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class SpecificationBuilder
{
    private $groupName;
    private $combinedAggregators;
    private $propertyCount;

    public function __construct($groupName)
    {
        $this->groupName = $groupName;
        $this->propertyCount = 0;
    }

    public function property(string $property, array $values)
    {
        $this->propertyCount++;

        $tuples = [];
        foreach ($values as $oneValue) {

            $oneValue = null !== $oneValue ? (string) $oneValue : null;

            $tuples[] = new Tuple($this->groupName, $property, $oneValue);
        }

        $aggregator = Aggregator::createFromArray($tuples);

        if (1 === $this->propertyCount) {
            $this->combinedAggregators = AggregatorList::createFromArray([
                $aggregator
            ]);
            return $this;
        }

        $combiner = new Combiner();
        if (2 === $this->propertyCount) {
            $this->combinedAggregators = $combiner->distribution($this->combinedAggregators, $aggregator);
        }

        if (2 < $this->propertyCount) {
            $this->combinedAggregators = $combiner->unitaryDistribution($this->combinedAggregators, $aggregator);
        }

        return $this;
    }

    public function build(): AggregatorList
    {
        $this->propertyCount = 0;
        $result = $this->combinedAggregators;
        $this->combinedAggregators = new AggregatorList();
        return $result;
    }
}
