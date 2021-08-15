<?php

declare(strict_types=1);

namespace TestBucket\Core\BoundaryValue\Virtual\Integer;

use TestBucket\Core\BoundaryValue\Virtual\Base\AbstractFactory;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\ElementPrecision;

class IntegerFactory extends AbstractFactory
{
    public function createPrecision(?int $value=null): ElementPrecision
    {
        return new UnitPrecision($value);
    }
}
