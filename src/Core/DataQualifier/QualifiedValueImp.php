<?php


namespace TestBucket\Core\DataQualifier;


use TestBucket\Core\Specification\Contracts\QualifiedValue;

class QualifiedValueImp implements QualifiedValue
{
    /**
     * @var bool
     */
    private $valid;

    private $value;

    public function __construct(bool $valid, $value)
    {
        $this->valid = $valid;
        $this->value = $value;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getValue()
    {
        return $this->value;
    }
}
