<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;
use App\Core\Domain\Virtual\Range;

class IntegerRangeSet
{
    protected $domains;

    public function __construct()
    {
        $this->domains = new IntegerRangeList();
    }

    public function has(ElementInterface $element) : bool
    {
        $iterator = $this->domains->getIterator();
        foreach ($iterator as $domain) {
            if ($domain->has($element)) {
                return true;
            }
        }
        return false;
    }

    public function applyUnion(IntegerRange $outerDomain) : void
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

    public function applyDifference(IntegerRange $outerDomain) : void
    {
        $newList = new IntegerRangeList();

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

    public function oppositeSet() : IntegerRangeSet
    {
        $oppositeSet = new IntegerRangeSet();

        $oppositeList = new IntegerRangeList();
        foreach ($this->domains->getIterator() as $currentRange) {
            $lastRange = $oppositeList->last();

            if (!$currentRange->getStartValue()->isInfinity() && !is_null($lastRange)) {
                $updatedRange = new IntegerRange(
                    $lastRange->getStartValue(),
                    $currentRange->getStartValue()->prev()
                );
                $oppositeList->set($updatedRange, $oppositeList->count() - 1);
            }

            if (!$currentRange->getStartValue()->isInfinity() && is_null($lastRange)) {
                $leftRange = new IntegerRange(new Element(null), $currentRange->getStartValue()->prev());
                $oppositeList->add($leftRange);
            }

            if (!$currentRange->getEndValue()->isInfinity()) {
                $rightRange = new IntegerRange($currentRange->getEndValue()->next(), new Element(null));
                $oppositeList->add($rightRange);
            }
        }

        foreach ($oppositeList->getIterator() as $range) {
            $oppositeSet->applyUnion($range);
        }

        return $oppositeSet;
    }
}
