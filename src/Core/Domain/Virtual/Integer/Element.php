<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;

class Element implements ElementCalculable
{
    protected $value;
    protected $precision;

    public function __construct(?int $value=null)
    {
        $this->value = $value;
        $this->setPrecision(1);
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setPrecision(int $precision) : void
    {
        $this->precision = (int) $precision;
    }

    public function equals(ElementInterface $e) : bool
    {
        return $e->getValue() === $this->getValue();
    }

    public function next() : ElementCalculable
    {
        if ($this->isInfinity()) {
            return new Element(null);
        }

        $newValue = $this->value + $this->precision;
        return new Element( $newValue );
    }

    public function prev() : ElementCalculable
    {
        if ($this->isInfinity()) {
            return new Element(null);
        }

        $newValue = $this->value - $this->precision;
        return new Element( $newValue );
    }

    public function isInfinity() : bool
    {
        return is_null($this->getValue());
    }
}
