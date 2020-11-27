<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class Combiner
{
    public function distribution(AggregatorList $aggregatorList, Aggregator $rightValues): AggregatorList
    {
        $newList = new AggregatorList();

        $iterator = $aggregatorList->getIterator();
        while($iterator->valid()) {
            $oneAggregator = $iterator->current();

            if ($oneAggregator->count() > 1) {
                $newList->appendList($oneAggregator->split());
                $iterator->next();
                continue;
            }

            $newList->add($oneAggregator);
            $iterator->next();
        }

        return $this->unitaryDistribution($newList, $rightValues);
    }

    public function unitaryDistribution(AggregatorList $aggregatorList, Aggregator $rightValues): AggregatorList
    {
        $combined = new AggregatorList();

        $rightValues = $rightValues->toArray();

        $iterator = $aggregatorList->getIterator();

        while($iterator->valid()) {

            $oneAggregator = $iterator->current();

            foreach ($rightValues as $oneTupleValue) {

                $currentAggregator = $oneAggregator->makeClone();
                $currentAggregator->add($oneTupleValue);

                $combined->add($currentAggregator);
            }
            $iterator->next();
        }

        return $combined;
    }
}
