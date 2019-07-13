<?php
namespace App\Domain;

interface Element
{
    public function __construct(string $key, string $value);
    public function getKey();
    public function getValue();
    public function equals(Element $e);
}
