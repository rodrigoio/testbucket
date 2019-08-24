<?php
namespace App\Core\Domain\Virtual;

use App\Core\Domain\ElementInterface;

interface Range
{
    public function getStartValue() : ElementInterface;

    public function getEndValue() : ElementInterface;
}
