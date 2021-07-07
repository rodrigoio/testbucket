<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

//TODO - expand data to persist values before combine
//TODO - persist combined values after process
class CombinerBuilder
{
    private $groupName;
    private $combinedAggregators;
    private $propertyCount;

    public function setGroup(string $groupName): CombinerBuilder
    {
        $this->groupName = $groupName;
        return $this;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function property(string $property, DataExpansionInterface $data): CombinerBuilder
    {

    }

    public function build(): AggregatorList
    {

    }
}
