<?php
namespace App\Core\Domain\Element;

interface Element
{
    public function getKey();
    public function getValue();
    public function equals(Element $e);
}
