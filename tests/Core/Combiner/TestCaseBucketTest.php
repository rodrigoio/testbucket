<?php

namespace TestBucket\Test\Core\Common;

use TestBucket\Core\Combiner\TestCaseBucket;
use TestBucket\Core\Combiner\SpecificationBuilder;
use TestBucket\Core\Combiner\StubTestCaseReceiver;
use PHPUnit\Framework\TestCase;

/**
 * @group combiner_test_case_bucket
 * @group combiner
 */
class TestCaseBucketTest extends TestCase
{
    private $databaseFile;

    public function setUp()
    {
        parent::setUp();
        $this->databaseFile = getenv('TESTBUCKET_DIR') . DIRECTORY_SEPARATOR . 'orders.db';

        if (file_exists($this->databaseFile)) {
            unlink($this->databaseFile);
        }
    }

    public function testSetupTestCaseBucket()
    {
        $specBuilder = new SpecificationBuilder('foobar');

        $testCaseData =
            $specBuilder
                ->setGroup('order')
                ->property('price', [0.0, 0.70, 55])
                ->property('status', ['pending', 'paid', 'canceled'])
                ->build();

        // Persist test cases
        $bucket = new TestCaseBucket('orders');
        $bucket->persist($testCaseData);

        $this->assertFileExists( $this->databaseFile);

        // query test cases
        $returnedResult = $bucket->get([
            'order:status' => 'pending',
            'order:price' => 0.0
        ]);
        $this->assertEquals(1, $returnedResult[0]['id']);
        $this->assertEquals('order:price:(MA==)|order:status:(cGVuZGluZw==)', $returnedResult[0]['keys']);

        // test query with receiver
        $receiver = new StubTestCaseReceiver();
        $bucket->get([
            'order:status' => 'pending'
        ], $receiver);
    }
}
