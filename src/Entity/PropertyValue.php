<?php

namespace TestBucket\Entity;

use TestBucket\Core\Specification\Property;
use TestBucket\Core\Specification\PropertyValue as PropertyValueInterface;
use DateTime;

class PropertyValue implements PropertyValueInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var boolean
     */
    private $valid;

    /**
     * @var int
     */
    private $integerValue;

    /**
     * @var float
     */
    private $decimalValue;

    /**
     * @var string
     */
    private $textValue;

    /**
     * @var boolean
     */
    private $booleanValue;

    /**
     * @var DateTime
     */
    private $datetimeValue;

    /**
     * @var Property
     */
    private $property;

    /**
     * @var mixed
     */
    private $value;

    public function __construct()
    {
        $this->setValid(true);
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getIntegerValue(): ?int
    {
        return $this->integerValue;
    }

    /**
     * @param int $integerValue
     */
    public function setIntegerValue(int $integerValue): void
    {
        $this->integerValue = $integerValue;
    }

    /**
     * @return float
     */
    public function getDecimalValue(): ?float
    {
        return $this->decimalValue;
    }

    /**
     * @param float $decimalValue
     */
    public function setDecimalValue(float $decimalValue): void
    {
        $this->decimalValue = $decimalValue;
    }

    /**
     * @return string
     */
    public function getTextValue(): ?string
    {
        return $this->textValue;
    }

    /**
     * @param string $textValue
     */
    public function setTextValue(string $textValue): void
    {
        $this->textValue = $textValue;
    }

    /**
     * @return bool
     */
    public function isBooleanValue(): ?bool
    {
        return $this->booleanValue;
    }

    /**
     * @param bool $booleanValue
     */
    public function setBooleanValue(bool $booleanValue): void
    {
        $this->booleanValue = $booleanValue;
    }

    /**
     * @return DateTime
     */
    public function getDatetimeValue(): ?DateTime
    {
        return $this->datetimeValue;
    }

    /**
     * @param DateTime $datetimeValue
     */
    public function setDatetimeValue(DateTime $datetimeValue): void
    {
        $this->datetimeValue = $datetimeValue;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        if (is_integer($value)) {
            $this->setIntegerValue($value);
            $this->value = $value;
        }

        if (is_float($value)) {
            $this->setDecimalValue($value);
            $this->value = $value;
        }

        if (is_bool($value)) {
            $this->setBooleanValue($value);
            $this->value = $value;
        }

        if (is_string($value)) {
            $this->setTextValue($value);
            $this->value = $value;
        }

        if ($value instanceof DateTime) {
            $this->setDatetimeValue($value);
            $this->value = $value;
        }
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function setValid($valid): void
    {
        $this->valid = $valid;
    }

    /**
     * @return Property
     */
    public function getProperty(): Property
    {
        return $this->property;
    }

    /**
     * @param Property $property
     */
    public function setProperty(Property $property): void
    {
        $this->property = $property;
    }
}
