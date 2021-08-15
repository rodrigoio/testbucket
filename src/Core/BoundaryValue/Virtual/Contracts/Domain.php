<?php

declare(strict_types=1);

namespace TestBucket\Core\BoundaryValue\Virtual\Contracts;

interface Domain
{
    public function has(ElementCalculable $element) : bool;
}
