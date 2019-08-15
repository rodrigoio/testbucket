<?php
namespace App\Core\Domain\Virtual\Range\Number;

use App\Core\Domain\Domain;
use App\Core\DataStructures\Collection;
use App\Core\Domain\Element\Element;
use App\Core\Domain\Element\ElementInterface;
use App\Core\Domain\Virtual\Range\AbstractRange;

class IntegerRange extends AbstractRange implements Domain
{
    public function __construct(ElementInterface $start, ElementInterface $end)
    {
        if (!$this->isValid($start) || !$this->isValid($end)) {
            throw new \InvalidArgumentException("The arguments must be integers.");
        }

        parent::__construct($start, $end);
    }

    public function has(ElementInterface $element) : bool
    {
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
        if (!$domain->has($this->getStartValue()) && $domain->has($this->getEndValue())) {
            return new IntegerRange($this->getStartValue(), $domain->getEndValue());
        }

        if ($domain->has($this->getStartValue()) && !$domain->has($this->getEndValue())) {
            return new IntegerRange($domain->getStartValue(), $this->getEndValue());
        }

        if ($this->has($domain->getStartValue()) && $this->has($domain->getEndValue())) {
            return new IntegerRange($this->getStartValue(), $this->getEndValue());
        }

        if ($domain->has($this->getStartValue()) && $domain->has($this->getEndValue())) {
            return new IntegerRange($domain->getStartValue(), $domain->getEndValue());
        }

        if (!$domain->has($this->getStartValue()) && !$domain->has($this->getEndValue())) {
            return new CompositeIntegerRange(new \ArrayObject([$this, $domain]));
        }
    }

    public function subtract(Domain $domain) : Domain
    {
        // TODO: Implement subtract() method.
        return null;
    }

    public function intersect(Domain $domain) : Domain
    {
        // TODO: Implement intersect() method.
        return null;
    }

    public function excludeIntersect(Domain $domain) : Domain
    {
        // TODO: Implement excludeIntersect() method.
        return null;
    }

    private function isValid(ElementInterface $element)
    {
        return is_null($element->getValue()) || is_int($element->getValue());
    }
}
