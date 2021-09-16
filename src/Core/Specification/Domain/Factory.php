<?php

namespace TestBucket\Core\Specification\Domain;

use TestBucket\Core\Specification\Contracts\Group;
use TestBucket\Core\Specification\Contracts\TestCase;
use TestBucket\Core\Specification\Contracts\SpecificationFactory;
use TestBucket\Core\Specification\Domain\Group as GroupImp;
use TestBucket\Core\Specification\Domain\TestCase as TestCaseImp;

class Factory implements SpecificationFactory
{
    public function createNewGroup(string $name): Group
    {
        return new GroupImp($name);
    }

    public function createNewTestCase(bool $valid): TestCase
    {
        return new TestCaseImp($valid);
    }
}
