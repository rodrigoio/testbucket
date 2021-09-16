<?php

namespace TestBucket\Core\Repository;

use TestBucket\Core\IO\FileWriter;

class CSVRepository implements TestCaseRepository
{
    /**
     * @var FileWriter
     */
    private $fileWriter;

    public function __construct(FileWriter $fileWriter)
    {
        $this->fileWriter = $fileWriter;
    }

    public function saveTestCases(array $testCases)
    {
        if ($testCases)
        foreach ($testCases as $testCase) {
            $this->fileWriter->write($testCase);
        }
    }
}
