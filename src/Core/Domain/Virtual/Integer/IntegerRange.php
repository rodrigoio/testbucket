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

    public function add(Range $domain) : Range
    {
        if ($this->startsWithLocalDomainEndsWithOuterDomain($domain)) {
            return new CompositeIntegerRange($this->getStartValue(), $domain->getEndValue());
        }

        if ($this->startsWithOuterDomainEndsWithLocalDomain($domain)) {
            return new CompositeIntegerRange($domain->getStartValue(), $this->getEndValue());
        }

        if ($this->outerDomainContainsLocalDomain($domain)) {
            return new CompositeIntegerRange($domain->getStartValue(), $domain->getEndValue());
        }

        if ($this->localDomainContainsOuterDomain($domain)) {
            return new CompositeIntegerRange($this->getStartValue(), $this->getEndValue());
        }

        if ($this->localDomainTouchesOuterDomainFromTheLeft($domain)) {
            return new CompositeIntegerRange($this->getStartValue(), $domain->getEndValue());
        }

        if ($this->localDomainTouchesOuterDomainFromTheRight($domain)) {
            return new CompositeIntegerRange($domain->getStartValue(), $this->getEndValue());
        }

        $resultComposite = new CompositeIntegerRange($this->getStartValue(), $this->getEndValue());
        $resultComposite->add($domain);
        return $resultComposite;
    }

    public function subtract(Range $domain) : Range
    {
        if ($this->startsWithLocalDomainEndsWithOuterDomain($domain)) {
            $start  = $this->getStartValue();
            $end    = $domain->getStartValue();
            return new CompositeIntegerRange($start, $end->prev());
        }

        if ($this->startsWithOuterDomainEndsWithLocalDomain($domain)) {
            $start  = $domain->getEndValue();
            $end    = $this->getEndValue();
            return new CompositeIntegerRange($start->next(), $end);
        }

        if ($this->outerDomainContainsLocalDomain($domain)) {
            return new CompositeIntegerRange(null, null);
        }

        if (
            $this->localDomainContainsOuterDomain($domain) &&
            !$domain->has($this->getStartValue()) && !$domain->has($this->getEndValue())
        ) {
            $rangeA = new IntegerRange( $this->getStartValue(), $domain->getStartValue()->prev() );//TODO review this
            $rangeB = new IntegerRange( $domain->getEndValue()->next(), $this->getEndValue() );

            $resultComposite = new CompositeIntegerRange($rangeA->getStartValue(), $rangeA->getEndValue());
            $resultComposite->add($rangeB);
            return $resultComposite;
        }

        return new CompositeIntegerRange($this->getStartValue(), $this->getEndValue());
    }

    public function getStartValue(): ElementCalculable
    {
        return $this->startValue;
    }

    public function getEndValue(): ElementCalculable
    {
        return $this->endValue;
    }

    public function countPartitions(): int
    {
        return 1;
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
