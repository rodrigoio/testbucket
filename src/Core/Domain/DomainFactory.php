<?php
declare(strict_types=1);

namespace App\Core\Domain;

use App\Core\Specification\Domain;

interface DomainFactory
{
    public function createFromDomainSpec(Domain $domainSpec) : DomainGenerator;
}
