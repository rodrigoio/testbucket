<?php
declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Integer;

use TestBucket\Core\Specification\Domain;
use TestBucket\Core\Domain\DomainFactory;
use TestBucket\Core\Domain\DomainGenerator;

class Factory implements DomainFactory
{
    public function createFromDomainSpec(Domain $domainSpec) : DomainGenerator
    {
        return new Generator($domainSpec);
    }
}
