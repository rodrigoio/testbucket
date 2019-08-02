<?php
namespace App\Core\Range;

class IntegerRangeGenerator
{
    private $range;

    public function __construct(Range $range)
    {
        $this->range = $range;
    }

    public function generate()
    {
        $startValue= $this->range->isStartIncluse() ? $this->range->getStartValue() : $this->range->getStartValue() + 1;
        $endValue  = $this->range->isEndIncluse() ? $this->range->getEndValue() : $this->range->getEndValue() - 1;


        return [
            [$startValue-1, $endValue+1],
            [$startValue-1, $endValue],
            [$startValue+1, $endValue-1],
        ];


    }
}