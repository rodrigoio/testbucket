<?php

namespace TestBucket\Core\Specification\Contracts;

interface SpecificationFactory
{
    public function createNewGroup(string $name): Group;
}
