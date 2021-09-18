<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class Tuple
{
    private $group;
    private $property;
    private $value;
    private $valid;

    public function __construct(string $group, string $property, Value $value)
    {
        $this->group = $group;
        $this->property = $property;
        $this->value = (string) $value->getValue();
        $this->valid = $value->isValid();
    }

    public function getUniqueKey()
    {
        $encodedValue = null !== $this->value ? md5($this->value) : $this->value;
        return $this->group . ':' . $this->property . ':' . $encodedValue . ':' . (int) $this->valid;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }
}
