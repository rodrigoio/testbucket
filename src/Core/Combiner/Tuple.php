<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

use JsonSerializable;

class Tuple implements JsonSerializable
{
    private $group;
    private $key;
    private $value;

    public function __construct(string $group, string $key, ?string $value)
    {
        $this->group = $group;
        $this->key = $key;
        $this->value = $value;
    }

    public function getUniqueKey()
    {
        $encodedValue = null !== $this->value ? base64_encode($this->value) : $this->value;

        return $this->group . ':' . $this->key . ':(' . $encodedValue . ')';
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): ?string
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
