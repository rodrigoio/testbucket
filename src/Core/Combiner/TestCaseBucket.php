<?php

declare(strict_types=1);

namespace TestBucket\Core\Combiner;

use Doctrine\DBAL\ParameterType;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Exception;

use TestBucket\Entity\Grouping;
use TestBucket\Entity\Property;

class TestCaseBucket
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

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(string $name, EntityManager $entityManager)
    {
        $this->name = $name;
        $this->entityManager = $entityManager;
        $this->bucketPath = getenv(self::TESTBUCKET_DIR);
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

    public function persist(SpecificationBuilder $specificationBuilder): void
    {
        $aggregatorList = $specificationBuilder->build();

        if ($aggregatorList->count() == 0) {
            return;
        }

        $iterator = $aggregatorList->getIterator();

        while ($iterator->valid()) {

            $oneAggregator = $iterator->current();

            $tuples = array_values($oneAggregator->toArray());

            foreach ($tuples as $tuple) {

                //TODO persist each new test case
                print_r( $tuple );
            }
            $iterator->next();
        }
    }

    //TODO - Implement search interface
}
