<?php
declare(strict_types=1);

namespace App\Core\Specification;

use App\Core\Common\ParameterBag;

class Domain
{
    private $type;
    private $parameters;

    public function __construct(string $type, ParameterBag $parameters)
    {
        if (strlen($type) == 0) {
            throw new \InvalidArgumentException('Invalid type');
        }

        $this->type = $type;
        $this->parameters = $parameters;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getParameters(): ParameterBag
    {
        return $this->parameters;
    }

    public function countParameters() : int
    {
        return $this->parameters->count();
    }
}
