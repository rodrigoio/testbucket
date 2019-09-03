<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;

class Element implements ElementInterface, ElementCalculable
{
    protected $value;

    public function __construct($value=null)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function equals(ElementInterface $e) : bool
    {
        return $e->getValue() === $this->getValue();
    }

    public function next() : ElementCalculable
    {
        $newValue = $this->value;
        return new Element( ++$newValue );
    }

    public function prev() : ElementCalculable
    {
        $newValue = $this->value;
        return new Element( --$newValue );
    }
}
