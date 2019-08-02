<?php
namespace App\Core\Range;

class AbstractRange implements Range
{
    protected $startValue;
    protected $endValue;
    protected $startIncluse;
    protected $endIncluse;

    public function __construct($startValue, $endValue, bool $startIncluse=true, bool $endIncluse=true)
    {
        $this->startValue   = $startValue;
        $this->endValue     = $endValue;
        $this->startIncluse = $startIncluse;
        $this->endIncluse   = $endIncluse;
    }

    public function has($value) : bool
    {
        return false;
    }

    public function getStartValue()
    {
        return $this->startValue;
    }

    public function getEndValue()
    {
        return $this->endValue;
    }

    public function isStartIncluse() : bool
    {
        return $this->startIncluse;
    }

    public function isEndIncluse() : bool
    {
        return $this->endIncluse;
    }
}
