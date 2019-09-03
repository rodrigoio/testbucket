<?php
namespace App\Core\Domain\Virtual;

use App\Core\Domain\ElementCalculable;

interface Range
{
    public function getStartValue() : ElementCalculable;

    public function getEndValue() : ElementCalculable;
}
