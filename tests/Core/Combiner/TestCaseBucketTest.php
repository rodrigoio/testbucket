<?php

namespace TestBucket\Test\Core\Common;

use TestBucket\Tests\AbstractTestCase;
use TestBucket\Core\Combiner\TestCaseBucket;
use TestBucket\Core\Combiner\SpecificationBuilder;
use TestBucket\Core\Combiner\StubTestCaseReceiver;
use TestBucket\Core\Combiner\StaticDataExpansion;

/**
 * @group combiner_test_case_bucket
 * @group combiner
 */
class TestCaseBucketTest extends AbstractTestCase
{
    public function tearDown()
    {
        parent::tearDown();
        if (file_exists(getenv('TESTBUCKET_DIR'))) {
            unlink(getenv('TESTBUCKET_DIR'));
        }
    }

    public function testSkipThat()
    {
        $this->markTestSkipped();
    }

    /*
    public function testSetupTestCaseBucket()
    {
        $specBuilder = (new SpecificationBuilder())
                ->setGroup('order')
                ->property('price', new StaticDataExpansion([0.0, 55]))
                ->property('status', new StaticDataExpansion(['pending', 'paid']));

        $bucket = new TestCaseBucket('orders', $this->entityManager);
        $bucket->persist($specBuilder);

        $this->assertFileExists($this->databaseFile);

        $receiver = new StubTestCaseReceiver();
        $bucket->setReceiver($receiver);
    }
    */

    /*
    public function testPersistSameCase()
    {
        $specBuilder = new SpecificationBuilder();

        $testCaseData =
            $specBuilder
                ->setGroup('order')
                ->property('price', [0.0, 0.70, 55])
                ->property('status', ['pending', 'paid', 'canceled'])
                ->build();

        // Persist test cases
        $bucket = new TestCaseBucket('orders');
        $bucket->persist($testCaseData);
        $bucket->persist($testCaseData);
        $this->assertFileExists($this->databaseFile);
    }
    */
}
