<?php

declare(strict_types=1);

namespace App\Core\Combiner;

class Combiner
{
    public function distribute(AggregatorList $aggregators, Aggregator $rightValues): AggregatorList
    {
        $combined = new AggregatorList();

        $rightValues = $rightValues->toArray();

        $iterator = $aggregators->getIterator();

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
