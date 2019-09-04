<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;

class Element implements ElementInterface, ElementCalculable
{
    protected $value;
    protected $precision;

    public function __construct($value=null)
    {
        $this->value = $value;
        $this->precision = 1;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setPrecision($precision) : void
    {
        if (!is_int($precision)) {
            throw new \InvalidArgumentException("Precision must be int");
        }
        $this->precision = (int) $precision;
    }

    public function equals(ElementInterface $e) : bool
    {
        return $e->getValue() === $this->getValue();
    }

    public function next() : ElementCalculable
    {
        $newValue = $this->value + $this->precision;
        return new Element( $newValue );
    }

    public function prev() : ElementCalculable
    {
        $newValue = $this->value - $this->precision;
        return new Element( $newValue );
    }
}
