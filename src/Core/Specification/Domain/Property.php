<?php

namespace TestBucket\Core\Specification\Domain;

use TestBucket\Core\Specification\Contracts\Group;
use TestBucket\Core\Specification\Contracts\Property as PropertyInterface;
use TestBucket\Core\Specification\Contracts\PropertyValue as PropertyValueInterface;

class Property implements PropertyInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var PropertyValueInterface[]
     */
    private $values;
    /**
     * @var Group
     */
    private $group;

    public function __construct(?string $name, ?string $type, Group $group)
    {
        $this->name = $name;
        $this->type = $type;
        $this->group = $group;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function addValue(bool $isValid, $value): void
    {
        $this->values[] = new PropertyValue($this, $isValid, $value);
    }
}
