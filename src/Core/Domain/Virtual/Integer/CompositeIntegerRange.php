<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;
use App\Core\Domain\Virtual\Range;
use App\Core\Domain\Virtual\Integer\IntegerRangeList;

class CompositeIntegerRange implements Range
{
    protected $domains;

    public function __construct(?ElementCalculable $start, ?ElementCalculable $end, ?int $precision=1)
    {
        $this->domains = new IntegerRangeList();

        if ($this->isEmptyDomain($start, $end)) {
            $this->add( new EmptyDomain(new Element(), new Element()) );
        } else {
            $this->add( new IntegerRange($start, $end, $precision) );
        }
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

    public function add(Range $outerDomain) : Range
    {
        $this->domains->add($outerDomain);

        /*
        // TODO implement flat logic, after add the outer domain
        */

        return $this;
    }

    public function subtract(Range $outerDomain) : Range
    {
        $iterator = $this->domains->getIterator();

        $subtractedDomainList = new IntegerRangeList();

        foreach ($iterator as $domain) {
            if ($outerDomain->reaches($domain)) {
                $subtractedDomain = $domain->subtract($outerDomain);
                $subtractedDomainList->add($subtractedDomain);
            }
        }

        $this->domains = $subtractedDomainList;
        return $this;
    }

    public function getStartValue() : ?ElementCalculable
    {
        $startValue = null;
        $iterator = $this->domains->getIterator();

        foreach ($iterator as $domain) {
            $currentValue = $domain->getStartValue();

            if (is_null($startValue)) {
                $startValue = $currentValue;
                continue;
            }

            if ($currentValue->getValue() < $startValue->getValue()) {
                $startValue = $currentValue;
            }
        }
        return $startValue;
    }

    public function getEndValue() : ?ElementCalculable
    {
        $endValue = null;
        $iterator = $this->domains->getIterator();

        foreach ($iterator as $domain) {
            $currentValue = $domain->getEndValue();

            if (is_null($endValue)) {
                $endValue = $currentValue;
                continue;
            }

            if ($currentValue->getValue() > $endValue->getValue()) {
                $endValue = $currentValue;
            }
        }

        return $endValue;
    }

    private function isEmptyDomain(?ElementCalculable $start, ?ElementCalculable $end) : bool
    {
        return is_null($start) && is_null($end);
    }

    public function countPartitions(): int
    {
        return $this->domains->count();
    }

    public function reaches(Range $domain) : bool
    {
        $iterator = $this->domains->getIterator();
        foreach ($iterator as $oneDomain) {
            if ($oneDomain->reaches($domain)) {
                return true;
            }
        }
        return false;
    }
}
