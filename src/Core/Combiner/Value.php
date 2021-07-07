<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class Value
{
    private $value;
    private $isValid;

    public function __construct($value, bool $isValid=true)
    {
        $this->value = $value;
        $this->isValid = $isValid;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        $value = null !== $this->value ? (string) $this->value : null;
        return $value;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }
}
