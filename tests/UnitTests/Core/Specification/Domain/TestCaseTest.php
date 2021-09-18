<?php

namespace TestBucket\Tests\UnitTests\Core\Specification\Domain;

use TestBucket\Core\Specification\Domain\TestCase;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group specification_domain_test_case
 * @group specification_domain
 * @group specification
 */
class TestCaseTest extends BaseUnitTestCase
{
    public function testCreateTestCase()
    {
        $testCase = new TestCase(true);

        $testCase->setGroupName("form");
        $testCase->setProperty("name", "Mart");
        $testCase->setProperty("phone", "9999-1111");

        $this->assertEquals("form", $testCase->getGroupName());
        $this->assertEquals("Mart", $testCase->getPropertyValue("name"));
        $this->assertEquals("9999-1111", $testCase->getPropertyValue("phone"));

        $this->assertEquals(
            '{"group_name":"form","properties":{"name":"TWFydA==","phone":"OTk5OS0xMTEx"},"is_valid":true}',
            $testCase
        );
    }
}
