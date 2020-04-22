<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;
use App\Core\Domain\Virtual\Range;

class IntegerRange implements Range
{
    protected $startValue;
    protected $endValue;
    protected $precision;

    public function __construct(?ElementCalculable $start, ?ElementCalculable $end, ?int $precision=1)
    {
        $this->startValue = $start;
        $this->endValue = $end;
        $this->precision = $precision;

        if (!is_null($precision)) {
            $this->startValue->setPrecision($precision);
            $this->endValue->setPrecision($precision);
        }
    }

    public function has(ElementInterface $element) : bool
    {
        if (is_null($this->startValue->getValue()) && is_null($this->endValue->getValue()) ) {
            return true;
        }

        if ($this->startValue->equals($element)) {
            return true;
        }

        if ($this->endValue->equals($element)) {
            return true;
        }

        if (
            $this->startValue->getValue() < $element->getValue() &&
            $element->getValue() < $this->endValue->getValue()
        ) {
            return true;
        }

        if ($this->startValue->getValue() < $element->getValue() && is_null($this->endValue->getValue())) {
            return true;
        }

        if (is_null($this->startValue->getValue()) && $element->getValue() < $this->endValue->getValue() ) {
            return true;
        }

        return false;
    }

    public function reaches(Range $domain) : bool
    {
        if ($this->startsWithLocalDomainEndsWithOuterDomain($domain)) {
            return true;
        }

        if ($this->startsWithOuterDomainEndsWithLocalDomain($domain)) {
            return true;
        }

        if ($this->outerDomainContainsLocalDomain($domain)) {
            return true;
        }

        if ($this->localDomainContainsOuterDomain($domain)) {
            return true;
        }

        if ($this->localDomainTouchesOuterDomainFromTheLeft($domain)) {
            return true;
        }

        if ($this->localDomainTouchesOuterDomainFromTheRight($domain)) {
            return true;
        }

        return false;
    }

    public function union(Range $outerDomain) : IntegerRangeList
    {
        $list = new IntegerRangeList();

        if ($this->startsWithLocalDomainEndsWithOuterDomain($outerDomain)) {
            $list->add(new IntegerRange($this->getStartValue(), $outerDomain->getEndValue()));
            return $list;
        }

        if ($this->startsWithOuterDomainEndsWithLocalDomain($outerDomain)) {
            $list->add(new IntegerRange($outerDomain->getStartValue(), $this->getEndValue()));
            return $list;
        }

        if ($this->outerDomainContainsLocalDomain($outerDomain)) {
            $list->add(new IntegerRange($outerDomain->getStartValue(), $outerDomain->getEndValue()));
            return $list;
        }

        if ($this->localDomainContainsOuterDomain($outerDomain)) {
            $list->add(new IntegerRange($this->getStartValue(), $this->getEndValue()));
            return $list;
        }

        if ($this->localDomainTouchesOuterDomainFromTheLeft($outerDomain)) {
            $list->add(new IntegerRange($this->getStartValue(), $outerDomain->getEndValue()));
            return $list;
        }

        if ($this->localDomainTouchesOuterDomainFromTheRight($outerDomain)) {
            $list->add(new IntegerRange($outerDomain->getStartValue(), $this->getEndValue()));
            return $list;
        }

        $list->add(new IntegerRange($this->getStartValue(), $this->getEndValue()));
        $list->add($outerDomain);

        return $list;
    }

    public function difference(Range $domain) : IntegerRangeList
    {
        $list = new IntegerRangeList();

        if ($this->startsWithLocalDomainEndsWithOuterDomain($domain)) {
            $list->add(new IntegerRange($this->getStartValue(), $domain->getStartValue()->prev()));
            return $list;
        }

        if ($this->startsWithOuterDomainEndsWithLocalDomain($domain)) {
            $list->add(new IntegerRange($domain->getEndValue()->next(), $this->getEndValue()));
            return $list;
        }

        if ($this->outerDomainContainsLocalDomain($domain)) {
            return $list;
        }

        if ($this->localDomainContainsOuterDomain($domain) && !$this->outerDomainContainsLocalDomain($domain)) {
            $rangeA = new IntegerRange( $this->getStartValue(), $domain->getStartValue()->prev() );
            $rangeB = new IntegerRange( $domain->getEndValue()->next(), $this->getEndValue() );

            $list->add($rangeA);
            $list->add($rangeB);
            return $list;
        }

        $list->add(new IntegerRange($this->getStartValue(), $this->getEndValue()));
        return $list;
    }

    public function getStartValue(): ElementCalculable
    {
        return $this->startValue;
    }

    public function getEndValue(): ElementCalculable
    {
        return $this->endValue;
    }

    private function startsWithLocalDomainEndsWithOuterDomain(Range $domain): bool
    {
        return !$domain->has($this->getStartValue()) && $domain->has($this->getEndValue());
    }

    private function startsWithOuterDomainEndsWithLocalDomain(Range $domain): bool
    {
        return $domain->has($this->getStartValue()) && !$domain->has($this->getEndValue());
    }

    private function outerDomainContainsLocalDomain(Range $domain): bool
    {
        return $domain->has($this->getStartValue()) && $domain->has($this->getEndValue());
    }

    private function localDomainContainsOuterDomain(Range $domain): bool
    {
        return $this->has($domain->getStartValue()) && $this->has($domain->getEndValue());
    }

    private function localDomainTouchesOuterDomainFromTheLeft(Range $domain): bool
    {
        return $this->getEndValue()->next()->equals($domain->getStartValue());
    }

    private function localDomainTouchesOuterDomainFromTheRight(Range $domain): bool
    {
        return $this->getStartValue()->prev()->equals($domain->getEndValue());
    }
}
