<?php
declare(strict_types=1);

namespace App\Core\Common;

use Ds\Map;

class ParameterBag
{
    private $map;

    public function __construct()
    {
        $this->map = new Map();
    }

    public function put(string $key, $value)
    {
        $this->map->put($key, $value);
    }

    public function get(string $key)
    {
        return $this->map->get($key);
    }

    public function count() : int
    {
        return count($this->map->toArray());
    }
}
