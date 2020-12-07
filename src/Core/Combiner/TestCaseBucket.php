<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

use Exception;
use SQLite3;

class TestCaseBucket extends SQLite3
{
    public const TESTBUCKET_DIR = 'TESTBUCKET_DIR';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $bucketPath;

    /**
     * @var TestCaseReceiverInterface
     */
    private $receiver;

    public function __construct(string $name, ?string $bucketPath=null)
    {
        $this->name = $name;
        $this->setBucketPath($bucketPath);

        $this->open($this->bucketPath . DIRECTORY_SEPARATOR . $this->name . ".db");
    }

    public function __destruct()
    {
        $this->close();
    }

    public function setReceiver(TestCaseReceiverInterface $receiver)
    {
        $this->receiver = $receiver;
    }

    public function setBucketPath(?string $bucketPath): void
    {
        if (null !== $bucketPath) {
            $this->bucketPath = $bucketPath;
            return;
        }

        $this->bucketPath = getenv(self::TESTBUCKET_DIR);

        if (!is_writable(dirname($this->bucketPath))) {
            throw new Exception("Can not read this directory: " . dirname($this->bucketPath));
        }
    }

    public function persist(AggregatorList $aggregatorList): void
    {
        if ($aggregatorList->count() == 0) {
            return;
        }

        $this->exec("
            CREATE TABLE IF NOT EXISTS test_case
            (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                keys TEXT NOT NULL UNIQUE,
                json_data TEXT NOT NULL
            );
        ");

        $iterator = $aggregatorList->getIterator();

        while ($iterator->valid()) {

            $oneAggregator = $iterator->current();

            $jsonData = json_encode($oneAggregator);
            $arrayKeys = implode('|', array_keys(json_decode($jsonData, true)));

            $query = sprintf("INSERT INTO test_case (keys, json_data) VALUES ('%s', '%s')", $arrayKeys, $jsonData);

            $this->exec($query);
            $iterator->next();
        }
    }

    public function get(array $conditions, ?string $label=null)
    {
        $sqlConditions = [];
        foreach ($conditions as $predicate=>$value) {
            $sqlConditions[] = sprintf("keys LIKE '%%%s:(%s)%%'", $predicate, base64_encode("$value"));
        }

        if (!empty($sqlConditions)) {
            $whereConditions = " WHERE " .  implode(" AND ", $sqlConditions);
        }
        $sqliteResult = $this->query("SELECT * FROM test_case $whereConditions;");


        $result = [];
        while($testCaseRow = $sqliteResult->fetchArray(SQLITE3_ASSOC) ) {

            $result[] = $testCaseRow;

            if (null !== $this->receiver) {
                $this->receiver->receiveTestCase(
                    $testCaseRow['keys'],
                    json_decode($testCaseRow['json_data'], true),
                    $label
                );
            }
        }

        return $result;
    }
}
