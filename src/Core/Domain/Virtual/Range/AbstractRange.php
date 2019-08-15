<?php
namespace App\Core\Domain\Virtual\Range;

use App\Core\Domain\Virtual\VirtualDomain;
use App\Core\Domain\Element\ElementInterface;

class AbstractRange implements Range
{
    protected $startValue;
    protected $endValue;

    public function __construct(ElementInterface $start, ElementInterface $end)
    {
        if ( $start->equals($end) && !is_null($start->getValue()) ) {
            throw new \InvalidArgumentException("Start can not be equals to end value.");
        }

        $this->startValue   = $start;
        $this->endValue     = $end;
    }

    public function getStartValue() : ElementInterface
    {
        return $this->startValue;
    }

    public function getEndValue() : ElementInterface
    {
        return $this->endValue;
    }
}
