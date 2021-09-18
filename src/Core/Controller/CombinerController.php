<?php

namespace TestBucket\Core\Controller;

use TestBucket\Core\Repository\TestCaseRepository;
use TestBucket\Core\Specification\Contracts\File;
use TestBucket\Core\Specification\Domain\Factory as SpecificationFactory;
use TestBucket\Core\Specification\Loader;

class CombinerController
{
    /**
     * @var Loader
     */
    private $loader;
    /**
     * @var TestCaseRepository
     */
    private $testCaseRepository;
    /**
     * @var SpecificationFactory
     */
    private $specificationFactory;
    /**
     * @var CombinationService
     */
    private $combinationService;

    public function __construct(
        Loader $loader,
        SpecificationFactory $specificationFactory,
        TestCaseRepository $testCaseRepository,
        CombinationService $combinationService
    ) {
        $this->loader = $loader;
        $this->testCaseRepository = $testCaseRepository;
        $this->specificationFactory = $specificationFactory;
        $this->combinationService = $combinationService;
    }

    public function generateTestCasesFrom(File $file)
    {
        $group = $this->loader->loadData($file);

        $testCases = $this->combinationService->buildTestCasesFromGroup($group);

        $this->testCaseRepository->saveTestCases($testCases);
    }
}
