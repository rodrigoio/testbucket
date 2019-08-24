<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\ElementInterface;

class Element implements ElementInterface
{
    protected $value;

    public function __construct($value=null)
    {
        $this->value= $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function equals(ElementInterface $e)
    {
        return $e->getValue() === $this->getValue();
    }
}
