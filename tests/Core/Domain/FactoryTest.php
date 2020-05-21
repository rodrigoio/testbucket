<?php
namespace App\Test\Core\Domain;

use App\Core\Common\ParameterBag;
use App\Core\Domain\DomainGenerator;
use App\Core\Specification\Domain;
use PHPUnit\Framework\TestCase;
use App\Core\Domain\Factory;

/**
 * @group domain
 */
class FactoryTest extends TestCase
{
    public function testDomainFactoryWithDomainSpec()
    {
        $parameter = new ParameterBag();
        $parameter->put('start', '10');
        $parameter->put('end', '20');
        $parameter->put('precision', null);

        $domainSpec = new Domain('IntegerRange', $parameter);

        $factory = new Factory();

        $generator = $factory->createFromDomainSpec($domainSpec);

        $this->assertInstanceOf(DomainGenerator::class, $generator);
    }

    public function testDomainFactoryWithInvalidDomainType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Domain type [no_no_no_type] not found');

        $domainSpec = new Domain('no_no_no_type', new ParameterBag());
        $factory = new Factory();
        $generator = $factory->createFromDomainSpec($domainSpec);

        $this->assertInstanceOf(DomainGenerator::class, $generator);
    }
}
