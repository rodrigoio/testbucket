<?php
namespace TestBucket\Generator\Output;

interface Output
{
    public function __construct(string $path, string $name);
    public function write();
}
