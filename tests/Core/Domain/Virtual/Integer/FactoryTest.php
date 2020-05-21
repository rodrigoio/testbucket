<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Factory;
use App\Core\Specification\Domain;
use App\Core\Common\ParameterBag;
use App\Core\Domain\DomainGenerator;

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
