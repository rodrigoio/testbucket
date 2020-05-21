<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual\Integer;

use App\Core\Specification\Domain;
use App\Core\Domain\DomainFactory;
use App\Core\Domain\DomainGenerator;

class Factory implements DomainFactory
{
    public function createFromDomainSpec(Domain $domainSpec) : DomainGenerator
    {
        return new Generator($domainSpec);
    }
}
