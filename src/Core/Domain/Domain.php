<?php
declare(strict_types=1);

namespace App\Core\Domain;

interface Domain
{
    public function has(ElementInterface $element) : bool;
}
