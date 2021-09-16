<?php

namespace TestBucket\Core\Specification\Contracts;

interface TestCase
{
    public function __construct(bool $valid);
    public function isValid(): bool;

    public function setGroupName(string $groupName);
    public function getGroupName();

    public function setProperty(string $propertyName, string $value);
    public function getPropertyValue(string $propertyName);
}
