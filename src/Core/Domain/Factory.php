<?php
declare(strict_types=1);

namespace App\Core\Domain;

use App\Core\Specification\Domain;

class Factory implements DomainFactory
{
    public function createFromDomainSpec(Domain $domain) : DomainGenerator
    {
        $domainFactory = $this->getMappedFactory($domain->getType());

        return $domainFactory->createFromDomainSpec($domain);
    }

    private function getMappedFactory($type) : DomainFactory
    {
        $map = [
            'IntegerRange' => \App\Core\Domain\Virtual\Integer\Factory::class,
        ];

        if (!isset($map[$type])) {
            throw new \InvalidArgumentException("Domain type [$type] not found");
        }

        return new $map[$type]();
    }
}
