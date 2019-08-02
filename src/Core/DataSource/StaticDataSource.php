<?php
namespace App\Core\DataSource;

use App\Core\DataStructures\Collection;
use App\Core\DataStructures\ElementCollection;

class StaticDataSource implements DataSource
{
    private $staticData;

    public function __construct(array $data)
    {
        $this->staticData = $data;
    }

    public function getAll() : Collection
    {
        return new ElementCollection();
    }
}