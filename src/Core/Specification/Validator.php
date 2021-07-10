<?php

namespace TestBucket\Core\Specification;

interface Validator
{
    public function validate($structure): void;
}
