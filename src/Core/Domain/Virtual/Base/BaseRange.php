<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Base;

use TestBucket\Core\Domain\Virtual\Contracts\Range;
use TestBucket\Core\Domain\Virtual\Contracts\RangeList;
use TestBucket\Core\Domain\Virtual\Contracts\AbstractFactory;
use TestBucket\Core\Domain\Virtual\Contracts\ElementCalculable;
use InvalidArgumentException;

class BaseRange implements Range
{
    /**
     * @var ElementCalculable
     */
    protected $startValue;

    /**
     * @var ElementCalculable
     */
    protected $endValue;

    /**
     * @var AbstractFactory
     */
    protected $abstractFactory;

    public function __construct(ElementCalculable $start, ElementCalculable $end, AbstractFactory $abstractFactory)
    {
        if (!$this->isValid($start, $end)) {
            throw new InvalidArgumentException("Invalid range: [{$start->getValue()}, {$end->getValue()}]");
        }

        $this->startValue = $start;
        $this->endValue = $end;
        $this->abstractFactory = $abstractFactory;
    }

    public function has(ElementCalculable $element) : bool
    {
        if ($this->startValue->isInfinity() && $this->endValue->isInfinity()) {
            return true;
        }

        if ($element->isInfinity()) {
            return false;
        }

        if ($this->startValue->equals($element)) {
            return true;
        }

        if ($this->endValue->equals($element)) {
            return true;
        }

        if (
            !$this->startValue->isInfinity() &&
            $this->endValue->isInfinity() &&
            $this->startValue->getValue() < $element->getValue()
        ) {
            return true;
        }

        if (
            $this->startValue->isInfinity() &&
            !$this->endValue->isInfinity() &&
            $element->getValue() < $this->endValue->getValue()
        ) {
            return true;
        }

        if (
            $this->startValue->getValue() < $element->getValue() &&
            $element->getValue() < $this->endValue->getValue()
        ) {
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

    public function union(Range $outerDomain): RangeList
    {
        $list = $this->abstractFactory->createRangeList();

        if ($this->startsWithLocalDomainEndsWithOuterDomain($outerDomain)) {
            $list->add(
                $this->abstractFactory->createRange($this->getStartValue(), $outerDomain->getEndValue())
            );
            return $list;
        }

        if ($this->startsWithOuterDomainEndsWithLocalDomain($outerDomain)) {
            $list->add(
                $this->abstractFactory->createRange($outerDomain->getStartValue(), $this->getEndValue())
            );
            return $list;
        }

        if ($this->outerDomainContainsLocalDomain($outerDomain)) {
            $list->add(
                $this->abstractFactory->createRange($outerDomain->getStartValue(), $outerDomain->getEndValue())
            );
            return $list;
        }

        if ($this->localDomainContainsOuterDomain($outerDomain)) {
            $list->add(
                $this->abstractFactory->createRange($this->getStartValue(), $this->getEndValue())
            );
            return $list;
        }

        if ($this->localDomainTouchesOuterDomainFromTheLeft($outerDomain)) {
            $list->add(
                $this->abstractFactory->createRange($this->getStartValue(), $outerDomain->getEndValue())
            );
            return $list;
        }

        if ($this->localDomainTouchesOuterDomainFromTheRight($outerDomain)) {
            $list->add(
                $this->abstractFactory->createRange($outerDomain->getStartValue(), $this->getEndValue())
            );
            return $list;
        }

        $list->add(
            $this->abstractFactory->createRange($this->getStartValue(), $this->getEndValue())
        );
        $list->add($outerDomain);

        return $list;
    }

    public function difference(Range $domain) : RangeList
    {
        $list = $this->abstractFactory->createRangeList();

        if ($this->startsWithLocalDomainEndsWithOuterDomain($domain)) {
            $list->add(
                $this->abstractFactory->createRange($this->getStartValue(), $domain->getStartValue()->prev())
            );
            return $list;
        }

        if ($this->startsWithOuterDomainEndsWithLocalDomain($domain)) {
            $list->add(
                $this->abstractFactory->createRange($domain->getEndValue()->next(), $this->getEndValue())
            );
            return $list;
        }

        if ($this->outerDomainContainsLocalDomain($domain)) {
            return $list;
        }

        if ($this->localDomainContainsOuterDomain($domain) && !$this->outerDomainContainsLocalDomain($domain)) {
            $rangeA = $this->abstractFactory->createRange($this->getStartValue(), $domain->getStartValue()->prev());
            $rangeB = $this->abstractFactory->createRange($domain->getEndValue()->next(), $this->getEndValue());

            $list->add($rangeA);
            $list->add($rangeB);
            return $list;
        }

        $list->add(
            $this->abstractFactory->createRange($this->getStartValue(), $this->getEndValue())
        );
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

    public function startsWithLocalDomainEndsWithOuterDomain(Range $outerDomain): bool
    {
        return !$outerDomain->has($this->getStartValue()) && $outerDomain->has($this->getEndValue());
    }

    public function startsWithOuterDomainEndsWithLocalDomain(Range $outerDomain): bool
    {
        return $outerDomain->has($this->getStartValue()) && !$outerDomain->has($this->getEndValue());
    }

    public function outerDomainContainsLocalDomain(Range $outerDomain): bool
    {
        return $outerDomain->has($this->getStartValue()) && $outerDomain->has($this->getEndValue());
    }

    public function localDomainContainsOuterDomain(Range $outerDomain): bool
    {
        return $this->has($outerDomain->getStartValue()) && $this->has($outerDomain->getEndValue());
    }

    public function localDomainTouchesOuterDomainFromTheLeft(Range $outerDomain): bool
    {
        return
            !$this->getEndValue()->isInfinity() &&
            $this->getEndValue()->next()->equals($outerDomain->getStartValue());
    }

    public function localDomainTouchesOuterDomainFromTheRight(Range $outerDomain): bool
    {
        return
            !$this->getStartValue()->isInfinity() &&
            $this->getStartValue()->prev()->equals($outerDomain->getEndValue());
    }

    private function isValid(ElementCalculable $start, ElementCalculable $end): bool
    {
        if (is_null($start->getValue()) || is_null($end->getValue())) {
            return true;
        }

        if ($start->getValue() > $end->getValue()) {
            return false;
        }
        return true;
    }

    public function equals(Range $domain) : bool
    {
        return $this->getStartValue()->getValue() === $domain->getStartValue()->getValue() &&
            $this->getEndValue()->getValue() === $domain->getEndValue()->getValue();
    }
}
