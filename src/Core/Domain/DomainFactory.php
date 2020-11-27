<?php
declare(strict_types=1);

namespace TestBucket\Core\Domain;

use TestBucket\Core\Specification\Domain;

interface DomainFactory
{
    public function createFromDomainSpec(Domain $domainSpec) : DomainGenerator;
}
