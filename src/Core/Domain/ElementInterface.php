<?php
declare(strict_types=1);

namespace App\Core\Domain;

interface ElementInterface
{
    public function getValue();

    public function equals(ElementInterface $e) : bool;
}
