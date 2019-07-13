<?php
namespace App\Specification;

interface InputSpecification
{
    public function __construct(Domain $domain, Domain $outerDomain);
    public function getDomain();
    public function getOuterDomain();
}