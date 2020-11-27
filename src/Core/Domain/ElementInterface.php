<?php
declare(strict_types=1);

namespace TestBucket\Core\Domain;

interface ElementInterface
{
    public function getValue();

    public function isInfinity() : bool;

    public function equals(ElementInterface $e) : bool;
}
