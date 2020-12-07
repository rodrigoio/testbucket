<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

class StubTestCaseReceiver implements TestCaseReceiverInterface
{
    private $testCaseKeys = [];

    public function receiveTestCase($testCaseKeys, $testCaseData, $label)
    {
        $this->testCaseKeys[$label] = $testCaseKeys;
    }

    public function getCase($label)
    {
        return $this->testCaseKeys[$label];
    }
}
