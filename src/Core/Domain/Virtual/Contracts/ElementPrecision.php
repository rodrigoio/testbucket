<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Contracts;

interface ElementPrecision
{
    public function next(ElementCalculable $elementCalculable, AbstractFactory $abstractFactory): ElementCalculable;
    public function prev(ElementCalculable $elementCalculable, AbstractFactory $abstractFactory): ElementCalculable;
}
