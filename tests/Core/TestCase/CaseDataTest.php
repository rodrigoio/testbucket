<?php
namespace TestBucket\Test\Core\TestCase;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\TestCase\CaseData;
use TestBucket\Core\Common\ParameterBag;

/**
 * @group test_case
 */
class CaseDataTest extends TestCase
{
    public function testCreateCaseData()
    {
        $parameter = new ParameterBag();
        $parameter->put('test_case', true);

        $caseA = new CaseData(true, $parameter);
        $this->assertEquals(true, $caseA->isValid());

        $caseB = new CaseData(false, $parameter);
        $this->assertEquals(false, $caseB->isValid());

        $this->assertInstanceOf(ParameterBag::class, $caseB->getParameters());
        $this->assertEquals(true, $caseB->getParameters()->get('test_case'));
    }
}
