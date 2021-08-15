<?php

namespace TestBucket\Core\Specification\Domain;

use TestBucket\Core\Specification\Contracts\Group;
use TestBucket\Core\Specification\Contracts\SpecificationFactory;
use TestBucket\Core\Specification\Domain\Group as GroupImp;

class Factory implements SpecificationFactory
{
    public function createNewGroup(string $name): Group
    {
        return new GroupImp($name);
    }
}
