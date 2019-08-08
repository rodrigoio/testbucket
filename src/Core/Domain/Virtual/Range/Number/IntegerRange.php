<?php
namespace App\Core\Domain\Virtual\Range\Number;

use App\Core\DataSource\DataSource;
use App\Core\Domain\Virtual\Range\AbstractRange;

class IntegerRange extends AbstractRange
{
    public function __construct(DataSource $dt)
    {
        parent::__construct($dt);

        if (!is_int($this->startValue) || !is_int($this->endValue)) {
            throw new \InvalidArgumentException('Use only integer values');
        }
    }

    public function has($element) : bool
    {
        if ($element == $this->startValue) {
            return true;
        }

        if ($element == $this->endValue) {
            return true;
        }

        if ($this->startValue < $element && $element < $this->endValue) {
            return true;
        }

        return false;
    }
}
