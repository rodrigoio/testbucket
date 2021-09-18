<?php

namespace TestBucket\Core\Combiner;

class Factory
{
    public function createSpecificationBuilder(string $groupName)
    {
        return new Builder($groupName);
    }
}
