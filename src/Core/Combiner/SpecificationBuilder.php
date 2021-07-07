<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class SpecificationBuilder
{
    private $groupName;
    private $combinedAggregators;
    private $propertyCount;

    public function __construct()
    {
        $this->propertyCount = 0;
    }

    public function setGroup(string $groupName): SpecificationBuilder
    {
        $this->groupName = $groupName;
        return $this;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }


    public function property(string $property, DataExpansionInterface $data): SpecificationBuilder
    {
        $this->propertyCount++;

        $values = $data->expand();
        $tuples = [];
        foreach ($values as $oneValue) {
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
