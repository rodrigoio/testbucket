<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class Builder
{
    private $groupName;
    private $combinedAggregatorList;
    private $propertyCount;

    public function __construct(string $groupName)
    {
        $this->groupName = $groupName;
        $this->propertyCount = 0;
    }

    public function combinePropertyValues(string $property, array $values): Builder
    {
        $this->propertyCount++;

        $tuples = [];
        foreach ($values as $oneValue) {
            $tuples[] = new Tuple($this->groupName, $property, $oneValue);
        }

        $aggregator = Aggregator::createFromArray($tuples);

        if (1 === $this->propertyCount) {
            $this->combinedAggregatorList = AggregatorList::createFromArray([
                $aggregator
            ]);
            return $this;
        }

        $combiner = new Combiner();
        if (2 === $this->propertyCount) {
            $this->combinedAggregatorList = $combiner->distribution($this->combinedAggregatorList, $aggregator);
        }

        if (2 < $this->propertyCount) {
            $this->combinedAggregatorList = $combiner->unitaryDistribution($this->combinedAggregatorList, $aggregator);
        }

        return $this;
    }

    public function getResult(): AggregatorList
    {
        $this->propertyCount = 0;
        $result = $this->combinedAggregatorList;
        $this->combinedAggregatorList = new AggregatorList();
        return $result;
    }
}
