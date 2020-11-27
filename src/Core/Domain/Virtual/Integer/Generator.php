<?php
declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual\Integer;

use TestBucket\Core\Specification\Domain;
use TestBucket\Core\Domain\DomainGenerator;

class Generator implements DomainGenerator
{
    private $domainSpec;
    private $validRange;

    public function __construct(Domain $domainSpec)
    {
        $this->domainSpec = $domainSpec;

        $parameter = $domainSpec->getParameters();
        $this->validRange = new IntegerRange(
            new Element((int) $parameter->get('start')),
            new Element((int) $parameter->get('end')),
            $parameter->get('precision')
        );
    }
}
