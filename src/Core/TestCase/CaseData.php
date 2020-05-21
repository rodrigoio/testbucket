<?php
declare(strict_types=1);

namespace App\Core\TestCase;

use App\Core\Common\ParameterBag;

class CaseData
{
    private $valid;
    private $parameters;

    public function __construct(bool $valid, ParameterBag $parameters)
    {
        $this->valid = $valid;
        $this->parameters = $parameters;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getParameters(): ParameterBag
    {
        return $this->parameters;
    }
}
