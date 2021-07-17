<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Integer;

use TestBucket\Core\Domain\Virtual\Contracts\ElementPrecision;
use TestBucket\Core\Domain\Virtual\Contracts\ElementCalculable;
use TestBucket\Core\Domain\Virtual\Contracts\Factory;

class UnitPrecision implements ElementPrecision
{
    public const UNIT = 1;
    protected $unit;

    public function __construct(?int $value=null)
    {
        $this->unit = self::UNIT;

        if ($value) {
            $this->unit = $value;
        }
    }

    public function next(ElementCalculable $elementCalculable, Factory $abstractFactory): ElementCalculable
    {
        if ($elementCalculable->isInfinity()) {
            return $abstractFactory->createInfinityElement();
        }

        $newValue = $elementCalculable->getValue() + $this->unit;
        return $abstractFactory->createElement($newValue);
    }

    public function prev(ElementCalculable $elementCalculable, Factory $abstractFactory): ElementCalculable
    {
        if ($elementCalculable->isInfinity()) {
            return $abstractFactory->createInfinityElement();
        }

        $newValue = $elementCalculable->getValue() - $this->unit;
        return $abstractFactory->createElement($newValue);
    }
}
