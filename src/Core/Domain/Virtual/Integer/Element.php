<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;
use App\Core\Domain\CalculableInterface;

class Element implements ElementInterface, CalculableInterface
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

    public function equals(ElementInterface $e)
    {
        return $e->getValue() === $this->getValue();
    }

    public function next()
    {
        $newValue = $this->value;
        return new Element( ++$newValue );
    }

    public function prev()
    {
        $newValue = $this->value;
        return new Element( --$newValue );
    }
}
