<?php

namespace TestBucket\Core\Specification\Contracts;

interface QualifiedValue
{
    public function __construct(bool $valid, $value);

    public function isValid(): bool;

    public function getValue();
}
