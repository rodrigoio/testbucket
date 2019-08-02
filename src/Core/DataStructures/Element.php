<?php
namespace App\Domain;

interface Element
{
    public function __construct(string $value);
    public function getValue();
    public function equals(Element $e);
}
