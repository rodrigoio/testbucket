<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;
use App\Core\Domain\Virtual\Range;

class CompositeIntegerRange implements Range
{
    protected $domains;

    public function __construct(?ElementCalculable $start, ?ElementCalculable $end, ?int $precision=1)
    {
        $this->domains = new \ArrayObject();

        if ($this->isEmptyDomain($start, $end)) {
            $this->add( new EmptyDomain(new Element(), new Element()) );
        } else {
            $this->add( new IntegerRange($start, $end, $precision) );
        }
    }

    public function has(ElementInterface $element) : bool
    {
        foreach ($this->domains as $domain) {
            if ($domain->has($element)) {
                return true;
            }
        }
        return false;
    }

    public function add(Range $domain) : Range
    {
        if ($this->domains->count() == 0) {
            $this->domains->append($domain);
            return $this;
        }

        $notMergedDomain = new \ArrayObject();
        $mergedDomains = $domain;

        foreach ($this->domains as $current) {
            if ($mergedDomains->reaches($current)) {
                $mergedDomains = $mergedDomains->add($current);
            }

            if (!$mergedDomains->reaches($current)) {
                $notMergedDomain->append($current);
            }
        }

        if ($notMergedDomain->count() > 0) {
            $notMergedDomain->append($mergedDomains);
            $this->domains = $notMergedDomain;
            return $this;
        }

        return $mergedDomains;
    }

    public function subtract(Range $domain) : Range
    {
        // TODO: Implement subtract() method.
        //        $this->endValue = $end; (update)
        //        $this->startValue = $start;
    }

    public function getStartValue() : ?ElementCalculable
    {
        $startValue = null;

        foreach ($this->domains as $domain) {
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

        foreach ($this->domains as $domain) {
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
        foreach ($this->domains as $oneDomain) {
            if ($oneDomain->reaches($domain)) {
                return true;
            }
        }
        return false;
    }
}
