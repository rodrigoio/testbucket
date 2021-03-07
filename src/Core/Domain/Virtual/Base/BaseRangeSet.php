<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Base;

use TestBucket\Core\Domain\Virtual\Contracts\Range;
use TestBucket\Core\Domain\Virtual\Contracts\RangeSet;
use TestBucket\Core\Domain\Virtual\Contracts\AbstractFactory;
use TestBucket\Core\Domain\Virtual\Contracts\ElementCalculable;

class BaseRangeSet implements RangeSet
{
    protected $factory;
    protected $domains;

    public function __construct(AbstractFactory $factory)
    {
        $this->factory = $factory;
        $this->domains = $this->factory->createRangeList();
    }

    public function has(ElementCalculable $element) : bool
    {
        $iterator = $this->domains->getIterator();
        foreach ($iterator as $domain) {
            if ($domain->has($element)) {
                return true;
            }
        }
        return false;
    }

    public function applyUnion(Range $outerDomain) : void
    {
        if ($this->domains->count() == 0) {
            $this->domains->add($outerDomain);
            return;
        }

        $addedAtLeastOne = false;
        foreach ($this->domains->getIterator() as $index=>$domain) {

            if ($domain->reaches($outerDomain)) {
                $addedAtLeastOne = true;
                $listResult = $domain->union($outerDomain);
                $this->domains->set($listResult->get(0), $index);
                continue;
            }
        }

        if (!$addedAtLeastOne) {
            $this->domains->add($outerDomain);
            return;
        }

        $accumulator = $this->domains->get(0);
        foreach ($this->domains->getIterator() as $index=>$domain) {

            if ($accumulator->reaches($domain)) {
                $listResult = $accumulator->union($domain);
                $this->domains->set($listResult->get(0), $index);
            }
        }
    }

    public function applyDifference(Range $outerDomain) : void
    {
        $newList = $this->factory->createRangeList();

        $iterator = $this->domains->getIterator();

        while($iterator->valid()) {
            $domain = $iterator->current();

            if ($outerDomain->reaches($domain)) {
                $result = $domain->difference($outerDomain);

                foreach ($result->getIterator() as $resultDomain) {
                    $newList->add($resultDomain);
                }
            }
            $iterator->next();
        }

        $this->domains = $newList;
    }

    public function oppositeSet() : RangeSet
    {
        $oppositeSet = $this->factory->createRangeSet();

        $oppositeList = $this->factory->createRangeList();

        foreach ($this->domains->getIterator() as $currentRange) {
            $lastRange = $oppositeList->last();

            if (!$currentRange->getStartValue()->isInfinity() && !is_null($lastRange)) {

                $updatedRange = $this->factory->createRange(
                    $lastRange->getStartValue(),
                    $currentRange->getStartValue()->prev()
                );
                $oppositeList->set($updatedRange, $oppositeList->count() - 1);
            }

            if (!$currentRange->getStartValue()->isInfinity() && is_null($lastRange)) {

                $leftRange = $this->factory->createRange(
                    $this->factory->createInfinityElement(),
                    $currentRange->getStartValue()->prev()
                );
                $oppositeList->add($leftRange);
            }

            if (!$currentRange->getEndValue()->isInfinity()) {

                $rightRange = $this->factory->createRange(
                    $currentRange->getEndValue()->next(),
                    $this->factory->createInfinityElement()
                );
                $oppositeList->add($rightRange);
            }
        }

        foreach ($oppositeList->getIterator() as $range) {
            $oppositeSet->applyUnion($range);
        }

        return $oppositeSet;
    }
}
