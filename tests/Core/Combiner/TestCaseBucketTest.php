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
        $this->assertFileExists($this->databaseFile);

        // Define a receiver
        $receiver = new StubTestCaseReceiver();
        $bucket->setReceiver($receiver);

        // query test cases
        $bucket->get(
            [
                'order:status' => 'pending',
                'order:price' => 0.7
            ],
            'PendingAndCheap'
        );
        $this->assertEquals('order:price:(MC43)|order:status:(cGVuZGluZw==)', $receiver->getCase('PendingAndCheap'));


        // test query with receiver
        $bucket->get(
            [
                'order:status' => 'pending',
                'order:price' => 55
            ],
            'PendingAndExpensive'
        );
        $this->assertEquals('order:price:(NTU=)|order:status:(cGVuZGluZw==)', $receiver->getCase('PendingAndExpensive'));
    }
}
