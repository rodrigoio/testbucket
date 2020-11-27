<?php
namespace TestBucket\Core\DataSource;

use TestBucket\Core\DataStructures\Collection;
use TestBucket\Core\DataSource\ElementCollection;

class ConcreteDataSource implements DataSource
{
    private $data;

    public function __construct(array $data=[])
    {
        $this->data = $data;
    }

    public function getAll() : Collection
    {
        return new ElementCollection($this->data);
    }
}
