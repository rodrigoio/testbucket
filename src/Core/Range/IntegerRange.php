<?php
namespace App\Core\Range;

class IntegerRange extends AbstractRange
{
    public function __construct($startValue, $endValue, bool $startIncluse=true, bool $endIncluse=true)
    {
        if (!is_int($startValue) || !is_int($endValue)) {
            throw new \InvalidArgumentException("start or end value are not integer.");
        }
        if ($startValue > $endValue) {
            throw new \InvalidArgumentException("start value can not be major than end value.");
        }

        parent::__construct($startValue, $endValue, $startIncluse, $endIncluse);
    }

    public function has($value) : bool
    {
        if ($this->startIncluse === true && $this->endIncluse === true) {
            if ($this->startValue == $value || $value == $this->endValue) {
                return true;
            }
        }

        if ($this->startIncluse === false && $this->endIncluse === true) {
            if ($value == $this->endValue) {
                return true;
            }
        }

        if ($this->startIncluse === true && $this->endIncluse === false) {
            if ($value == $this->startValue) {
                return true;
            }
        }

        if ($this->startValue < $value && $value < $this->endValue) {
            return true;
        }

        return false;
    }
}
