<?php
declare(strict_types=1);

namespace App\Core\Domain;

interface ElementCalculable extends ElementInterface
{
    public function setPrecision(int $precision) : void;

    public function next() : ElementCalculable;

    public function prev() : ElementCalculable;
}
