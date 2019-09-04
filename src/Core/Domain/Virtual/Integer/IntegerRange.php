<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Domain;
use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;
use App\Core\Domain\Virtual\Range;
use App\Core\Domain\Virtual\Integer\EmptyDomain;
use App\Core\Domain\Virtual\Integer\CompositeIntegerRange;
use App\Repository\Domains\Numbers\Integer;

class IntegerRange implements Domain,Range
{
    protected $startValue;
    protected $endValue;
    protected $precision;

    public function __construct(ElementCalculable $start, ElementCalculable $end, $precision=null)
    {
        if (!$this->isValid($start) || !$this->isValid($end)) {
            throw new \InvalidArgumentException("The arguments must be integers.");
        }

        $this->startValue   = $start;
        $this->endValue     = $end;
        $this->precision    = $precision;

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

    public function add(Domain $domain) : Domain
    {
        //TODO - implement precision of unity in both operations: add and subtract
        if (!$domain->has($this->getStartValue()) && $domain->has($this->getEndValue())) {

            return new CompositeIntegerRange(
                new \ArrayObject([
                    new IntegerRange($this->getStartValue(), $domain->getEndValue())
                ])
            );
        }

        if ($domain->has($this->getStartValue()) && !$domain->has($this->getEndValue())) {

            return new CompositeIntegerRange(
                new \ArrayObject([
                    new IntegerRange($domain->getStartValue(), $this->getEndValue())
                ])
            );
        }

        if ($domain->has($this->getStartValue()) && $domain->has($this->getEndValue())) {

            return new CompositeIntegerRange(
                new \ArrayObject([
                    new IntegerRange($domain->getStartValue(), $domain->getEndValue())
                ])
            );
        }

        if ($this->has($domain->getStartValue()) && $this->has($domain->getEndValue())) {
            return new CompositeIntegerRange(
                new \ArrayObject([$this])
            );
        }

        if ( $this->getEndValue()->next()->equals($domain->getStartValue()) ) {
            return new CompositeIntegerRange(
                new \ArrayObject([
                    new IntegerRange( $this->getStartValue(), $domain->getEndValue() )
                ])
            );
        }

        if ( $this->getStartValue()->prev()->equals($domain->getEndValue()) ) {
            return new CompositeIntegerRange(
                new \ArrayObject([
                    new IntegerRange( $domain->getStartValue(), $this->getEndValue() )
                ])
            );
        }

        return new CompositeIntegerRange(
            new \ArrayObject([$this, $domain])
        );
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

    private function isValid(ElementCalculable $element)
    {
        return is_null($element->getValue()) || is_int($element->getValue());
    }

    public function getStartValue(): ElementCalculable
    {
        return $this->startValue;
    }

    public function getEndValue(): ElementCalculable
    {
        return $this->endValue;
    }
}
