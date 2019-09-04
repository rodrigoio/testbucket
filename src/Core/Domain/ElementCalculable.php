<?php
namespace App\Core\Domain;

interface ElementCalculable extends ElementInterface
{
    public function setPrecision($precision) : void;

    public function next() : ElementCalculable;

    public function prev() : ElementCalculable;
}
