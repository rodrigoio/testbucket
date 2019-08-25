<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Domain;
use App\Core\Domain\ElementInterface;
use App\Core\Domain\Virtual\Integer\EmptyDomain;
use App\Core\Domain\Virtual\Integer\CompositeIntegerRange;

class IntegerRange implements Domain
{
    protected $startValue;
    protected $endValue;

    public function __construct(ElementInterface $start, ElementInterface $end)
    {
        if (!$this->isValid($start) || !$this->isValid($end)) {
            throw new \InvalidArgumentException("The arguments must be integers.");
        }

        $this->startValue = $start;
        $this->endValue = $end;
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

    public function add(Domain $domain) : Domain
    {
        //TODO - refactory to return composite in all cases.
        //TODO - implement precision of unity in both operations: add and subtract
        if (!$domain->has($this->getStartValue()) && $domain->has($this->getEndValue())) {
            return new IntegerRange($this->getStartValue(), $domain->getEndValue());
        }

        if ($domain->has($this->getStartValue()) && !$domain->has($this->getEndValue())) {
            return new IntegerRange($domain->getStartValue(), $this->getEndValue());
        }

        if ($domain->has($this->getStartValue()) && $domain->has($this->getEndValue())) {
            return new IntegerRange($domain->getStartValue(), $domain->getEndValue());
        }

        if ($this->has($domain->getStartValue()) && $this->has($domain->getEndValue())) {
            return $this;
        }

        return new CompositeIntegerRange(new \ArrayObject([$this, $domain]));
    }

    public function subtract(Domain $domain) : Domain
    {
        if (!$domain->has($this->getStartValue()) && $domain->has($this->getEndValue())) {
            $start  = $this->getStartValue();
            $end    = $domain->getStartValue();

            return new CompositeIntegerRange(
                new \ArrayObject([
                    new IntegerRange($start, $end->prev())
                ])
            );
        }

        if ($domain->has($this->getStartValue()) && !$domain->has($this->getEndValue())) {
            $start  = $domain->getEndValue();
            $end    = $this->getEndValue();

            return new CompositeIntegerRange(
                new \ArrayObject([
                    new IntegerRange($start->next(), $end)
                ])
            );
        }

        if ($domain->has($this->getStartValue()) && $domain->has($this->getEndValue())) {
            return new CompositeIntegerRange(
                new \ArrayObject([
                    new EmptyDomain()
                ])
            );
        }

        if (
            $this->has($domain->getStartValue()) && $this->has($domain->getEndValue())
            &&
            !$domain->has($this->getStartValue()) && !$domain->has($this->getEndValue())
        ) {
            $rangeA = new IntegerRange( $this->getStartValue(), $domain->getStartValue()->prev() );
            $rangeB = new IntegerRange( $domain->getEndValue()->next(), $this->getEndValue() );

            return new CompositeIntegerRange(
                new \ArrayObject([
                    $rangeA, $rangeB
                ])
            );
        }

        return new CompositeIntegerRange(new \ArrayObject([$this]));
    }

    private function isValid(ElementInterface $element)
    {
        return is_null($element->getValue()) || is_int($element->getValue());
    }

    public function getStartValue(): ElementInterface
    {
        return $this->startValue;
    }

    public function getEndValue(): ElementInterface
    {
        return $this->endValue;
    }
}
