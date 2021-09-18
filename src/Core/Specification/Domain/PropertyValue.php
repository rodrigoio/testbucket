<?php

namespace TestBucket\Core\Specification\Domain;

use TestBucket\Core\Specification\Contracts\Property;
use TestBucket\Core\Specification\Contracts\PropertyValue as PropertyValueInterface;

class PropertyValue implements PropertyValueInterface
{
    /**
     * @var boolean
     */
    private $valid;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var Property
     */
    private $property;

    public function __construct(Property $property, bool $isValid, $value)
    {
        $this->property = $property;
        $this->valid = $isValid;
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Property
     */
    public function getProperty(): Property
    {
        return $this->property;
    }
}
