<?php

namespace TestBucket\Core\Specification\Domain;

use ArrayObject;
use TestBucket\Core\Specification\Contracts\TestCase as TestCaseInterface;

class TestCase implements TestCaseInterface
{
    /**
     * @var string
     */
    private $groupName;

    /**
     * @var array
     */
    private $properties;

    /**
     * @var bool
     */
    private $valid;

    public function __construct(bool $valid)
    {
        $this->valid = $valid;
    }

    public function setGroupName(string $groupName)
    {
        $this->groupName = $groupName;
    }

    public function getGroupName()
    {
        return $this->groupName;
    }

    public function setProperty(string $propertyName, string $value)
    {
        $this->properties[$propertyName] = $value;
    }

    public function getPropertyValue(string $propertyName)
    {
        return $this->properties[$propertyName];
    }

    public function getProperties(): array
    {
        return (array) new ArrayObject($this->properties);
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function __toString()
    {
        $properties = [];
        foreach ($this->properties as $key=>$value)
            $properties[$key] = base64_encode($value);

        return json_encode([
            'group_name' => $this->groupName,
            'properties' => $properties,
            'is_valid' => $this->valid
        ]);
    }
}
