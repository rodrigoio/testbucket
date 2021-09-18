<?php

declare(strict_types=1);

namespace TestBucket\Core\BoundaryValue\Virtual\Contracts;

interface ElementCalculable
{
    public function __construct(Factory $abstractFactory, $value);

    public function setPrecision(ElementPrecision $precision): void;

    public function next(): ElementCalculable;

    public function prev(): ElementCalculable;

    public function equals(ElementCalculable $e): bool;

    public function getValue();

    public function isInfinity(): bool;

    public function isNull(): bool;
}
