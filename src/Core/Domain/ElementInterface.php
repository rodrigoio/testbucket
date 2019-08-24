<?php
namespace App\Core\Domain;

interface ElementInterface
{
    public function getValue();
    public function equals(ElementInterface $e);
}
