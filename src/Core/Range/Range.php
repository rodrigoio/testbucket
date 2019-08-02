<?php
namespace App\Core\Range;

interface Range
{
    public function __construct($startValue, $endValue);
    public function has($value) : bool;
    public function getStartValue();
    public function getEndValue();
    public function isStartIncluse() : bool;
    public function isEndIncluse() : bool;
}
