<?php
namespace TestBucket\Test\Core\Domain\Concrete;

use TestBucket\Core\Domain\Concrete\ConcreteDomain;
use TestBucket\Core\DataSource\ConcreteDataSource;
use PHPUnit\Framework\TestCase;

/**
 * @group Concrete
 */
class ConcreteDomainTest extends TestCase
{
    public function testNewConcreteDomain()
    {
        $concrete = new ConcreteDomain(new ConcreteDataSource(['test']));//TODO review this type of domain

        $this->assertFalse($concrete->isEmpty());
    }
}
