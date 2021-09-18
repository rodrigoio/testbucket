<?php

declare(strict_types=1);

namespace TestBucket\Core\BoundaryValue\Virtual\Base;

use TestBucket\Core\BoundaryValue\Virtual\Contracts\ElementCalculable;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\ElementPrecision;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\Factory;

class BaseElement implements ElementCalculable
{
    protected $value;

    /**
     * @var ElementPrecision
     */
    protected $precision;

    /**
     * @var Factory
     */
    private $abstractFactory;

    public function __construct(Factory $abstractFactory, $value=null)
    {
        $this->value = $value;
        $this->setPrecision($abstractFactory->createPrecision());
        $this->abstractFactory = $abstractFactory;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setPrecision(ElementPrecision $precision): void
    {
        $this->precision = $precision;
    }

    public function equals(ElementCalculable $e): bool
    {
        return $e->getValue() === $this->getValue();
    }

    public function next(): ElementCalculable
    {
        return $this->precision->next($this, $this->abstractFactory);
    }

    public function prev(): ElementCalculable
    {
        return $this->precision->prev($this, $this->abstractFactory);
    }

    public function isInfinity(): bool
    {
        return is_null($this->getValue());
    }

    public function isNull(): bool
    {
        return is_null($this->getValue());
    }
}
