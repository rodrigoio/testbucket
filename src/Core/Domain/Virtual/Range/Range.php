<?php
namespace App\Core\Domain\Virtual\Range;

use App\Core\Domain\Element\ElementInterface;

interface Range
{
    public function getStartValue() : ElementInterface;

    public function getEndValue() : ElementInterface;
}
