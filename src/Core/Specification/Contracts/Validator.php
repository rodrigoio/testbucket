<?php

namespace TestBucket\Core\Specification\Contracts;

interface Validator
{
    public function validate($structure): void;
}
