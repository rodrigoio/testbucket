<?php
namespace App\Core\Domain\Element;

class BaseElement implements Element
{
    protected $key;
    protected $value;

    public function __construct(string $key, string $value)
    {
        $this->key  = $key;
        $this->value= $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function equals(Element $e)
    {
        return  $e->getKey() === $this->getKey() &&
                $e->getValue() === $this->getValue();
    }
}