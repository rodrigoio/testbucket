<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

interface TestCaseReceiverInterface
{
    public function receiveTestCase($testCaseKeys, $testCaseData, $label);
}