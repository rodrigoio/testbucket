<?php
namespace App\Core\DataSource;

use App\Core\DataStructures\Collection;

interface DataSource
{
    public function getAll() : Collection;
}