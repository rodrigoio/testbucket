<?php

declare(strict_types=1);

namespace TestBucket\Core\BoundaryValue\Virtual\Contracts;

interface ElementPrecision
{
    public function next(ElementCalculable $elementCalculable, Factory $abstractFactory): ElementCalculable;
    public function prev(ElementCalculable $elementCalculable, Factory $abstractFactory): ElementCalculable;
}
