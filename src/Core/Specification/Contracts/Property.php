<?php

namespace TestBucket\Core\Specification\Contracts;

interface Property
{
    public function __construct(?string $name, ?string $type, Group $group);

    public function getName();

    public function getType();

    public function getGroup(): Group;

    public function addValue(bool $isValid, $value): void;

    public function getValues(): array;
}
