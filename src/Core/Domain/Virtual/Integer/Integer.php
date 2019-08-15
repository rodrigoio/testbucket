<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Element\ElementInterface;

class Integer
{
    private $element;

    public function __construct(ElementInterface $element)
    {
        $this->element = $element;
    }
}