<?php
namespace TestBucket\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Domain\Virtual\Integer\Factory;
use TestBucket\Core\Specification\Domain;
use TestBucket\Core\Common\ParameterBag;
use TestBucket\Core\Domain\DomainGenerator;

/**
 * @group integer_range
 */
class FactoryTest extends TestCase
{
    public function testFactoryWithDomainSpec()
    {
        $parameter = new ParameterBag();
        $parameter->put('start', '10');
        $parameter->put('end', '20');
        $parameter->put('precision', null);

        $domain = new Domain('IntegerRange', $parameter);

        $factory = new Factory();
        $generator = $factory->createFromDomainSpec($domain);

        $this->assertInstanceOf(DomainGenerator::class, $generator);
    }
}
