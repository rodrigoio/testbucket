<?php
declare(strict_types=1);

namespace TestBucket\Core\Specification;

class Field
{
    private $name;
    private $domain;

    public function __construct(string $name, Domain $domain)
    {
        if (strlen($name) == 0) {
            throw new \InvalidArgumentException('Invalid field name');
        }

        $this->name = $name;
        $this->domain = $domain;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDomain(): Domain
    {
        return $this->domain;
    }
}
