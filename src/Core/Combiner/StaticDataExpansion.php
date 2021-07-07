<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class StaticDataExpansion implements DataExpansionInterface
{
    private $staticValues;

    public function __construct(array $staticValues)
    {
        $this->staticValues = $staticValues;
    }

    public function expand(): array
    {
        $output = [];
        foreach ($this->staticValues as $value) {
            $output[] = new Value($value, true);
        }
        return $output;
    }
}
