<?php
namespace App\Core\DataSource;

use App\Core\DataStructures\Collection;
use App\Core\DataSource\ElementCollection;

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
