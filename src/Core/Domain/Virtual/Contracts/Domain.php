<?php

declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Contracts;

interface Domain
{
    public function has(ElementCalculable $element) : bool;
}
