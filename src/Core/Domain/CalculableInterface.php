<?php
namespace App\Core\Domain;

use App\Core\Domain\ElementInterface;

interface CalculableInterface
{
    public function next() : ElementInterface;

    public function prev() : ElementInterface;
}
