<?php
namespace TestBucket\Generator;

use TestBucket\Specification\Specification;
use TestBucket\Generator\Output\Output;

interface Generator
{
    public function __construct(Specification $spec, Output $output);
    public function output();
}
