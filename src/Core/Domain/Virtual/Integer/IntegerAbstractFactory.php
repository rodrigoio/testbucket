<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Integer;

use TestBucket\Core\Domain\Virtual\Base\AbstractFactory;
use TestBucket\Core\Domain\Virtual\Contracts\ElementPrecision;

class IntegerAbstractFactory extends AbstractFactory
{
    public function createPrecision(?int $value=null): ElementPrecision
    {
        return new UnitPrecision($value);
    }
}
