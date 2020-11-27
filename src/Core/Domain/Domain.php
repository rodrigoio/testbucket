<?php
declare(strict_types=1);

namespace TestBucket\Core\Domain;

interface Domain
{
    public function has(ElementInterface $element) : bool;
}
