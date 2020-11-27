<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class StubTestCaseReceiver implements TestCaseReceiverInterface
{
    private $testCaseKeys = [];

    public function receiveTestCase($testCaseKeys, $testCaseData)
    {
        $this->testCaseKeys[] = $testCaseKeys;
    }

    public function getHydratedResult()
    {
        return $this->testCaseKeys;
    }
}
