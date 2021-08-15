<?php

namespace TestBucket\Core\Specification\Contracts;

interface SpecificationRepository
{
    public function save(Group $group);

    public function findOneByName(string $name): Group;
}
