<?php
namespace App\Core\Domain\Virtual\Range;

use App\Core\DataSource\DataSource;
use App\Core\Domain\Virtual\VirtualDomain;
use App\Core\Domain\Element\Element;

class AbstractRange extends VirtualDomain implements Range
{
    protected $startValue;
    protected $endValue;

    public function __construct(DataSource $dt)
    {
        $elements = $dt->getAll()->getIterator();
        if ($elements->count() != 2) {
            throw new \InvalidArgumentException("2 elements required, but receive: ".$elements->count());
        }

        $this->startValue   = $elements->offsetGet(0);
        $this->endValue     = $elements->offsetGet(1);
    }

    public function has($element) : bool
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
