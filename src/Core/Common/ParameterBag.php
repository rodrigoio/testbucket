<?php
declare(strict_types=1);

namespace TestBucket\Core\Common;

use ArrayObject;

class ParameterBag
{
    private $map;

    public function __construct()
    {
        $this->map = new ArrayObject();
    }

    public function put(string $key, $value)
    {
        $this->map->offsetSet($key, $value);
    }

    public function get(string $key)
    {
        return $this->map->offsetGet($key);
    }

    public function count() : int
    {
        return $this->map->count();
    }
}
