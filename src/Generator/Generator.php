<?php
namespace App\Generator;

use App\Specification\Specification;
use App\Generator\Output\Output;

interface Generator
{
    public function __construct(Specification $spec, Output $output);
    public function output();
}
