<?php
namespace App\Core\Domain\Virtual\Range;

interface Range
{
    public function getStartValue();

    public function getEndValue();
}
