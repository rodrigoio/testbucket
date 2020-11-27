<?php
declare(strict_types=1);

namespace TestBucket\Core\Specification;

class Spec
{
    private $version;
    private $name;
    private $fields;

    public function __construct(string $version, string $name, FieldList $fields)
    {
        if (strlen($version) == 0) {
            throw new \InvalidArgumentException('No version defined');
        }

        if (strlen($name) == 0) {
            throw new \InvalidArgumentException('No name defined');
        }

        if ($fields->count() == 0) {
            throw new \InvalidArgumentException('No fields defined');
        }

        $this->version = $version;
        $this->name = $name;
        $this->fields = $fields;
    }

    public function getVersion() : string
    {
        return $this->version;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getFields(): FieldList
    {
        return $this->fields;
    }
}
