<?php

declare(strict_types=1);

namespace App\Core\Combiner;

use JsonSerializable;

class Tuple implements JsonSerializable
{
    private $key;
    private $value;

    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getUniqueKey()
    {
        return $this->key . ':' . md5($this->value);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
