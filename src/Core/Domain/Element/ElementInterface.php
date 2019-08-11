<?php
namespace App\Core\Domain\Element;

interface ElementInterface
{
    public function getValue();
    public function equals(ElementInterface $e);
}
