<?php
namespace TestBucket\Core\DataSource;

use TestBucket\Core\DataStructures\Collection;

interface DataSource
{
    public function getAll() : Collection;
}