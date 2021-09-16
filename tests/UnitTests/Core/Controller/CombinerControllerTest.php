<?php

namespace TestBucket\Tests\UnitTests\Core\Controller;

use TestBucket\Core\Combiner\Factory as CombinerFactory;
use TestBucket\Core\Controller\CombinationService;
use TestBucket\Core\Controller\CombinerController;
use TestBucket\Core\DataQualifier\Factory as DataQualifierFactory;
use TestBucket\Core\IO\FileWriter;
use TestBucket\Core\Repository\CSVRepository;
use TestBucket\Core\Repository\TestCaseRepository;
use TestBucket\Core\Specification\Domain\Factory as SpecificationFactory;
use TestBucket\Core\Specification\File;
use TestBucket\Core\Specification\Loader;
use TestBucket\Core\Specification\V1Validator;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group controller
 */
class CombinerControllerTest extends BaseUnitTestCase
{
    /**
     * @var Loader
     */
    private $loader;
    /**
     * @var CombinerController
     */
    private $controller;
    /**
     * @var TestStubRepository
     */
    private $stubRepository;
    /**
     * @var array
     */
    private $testCaseResults;

    public function setUp()
    {
        parent::setUp();

        $this->loader = new Loader(
            new V1Validator(),
            new DataQualifierFactory(),
            new SpecificationFactory()
        );

        $this->stubRepository = new TestStubRepository();
        $this->testCaseResults = [];
    }

    private function setUpControllerAssertingRepositorySave(): void
    {
        $this->controller = new CombinerController(
            $this->loader,
            new SpecificationFactory(),
            $this->stubRepository,
            new CombinationService(new CombinerFactory(), new SpecificationFactory())
        );
    }

    public function testGenerateTestCasesWithTwoStaticFields()
    {
        $this->setUpControllerAssertingRepositorySave();

        $this->controller->generateTestCasesFrom($this->getFile('v1/003_spec_two_static_field.yaml'));

        $this->assertTestCases([
            ['name' => 'bob', 'surname' => 'red'],
            ['name' => 'bob', 'surname' => 'green'],
            ['name' => 'alice', 'surname' => 'red'],
            ['name' => 'alice', 'surname' => 'green'],
        ]);
    }

    public function testGenerateTestCasesWithValidAndInvalidDataUsingOneField()
    {
        $this->setUpControllerAssertingRepositorySave();

        $this->controller->generateTestCasesFrom($this->getFile('v1/002_spec_with_integer_range.yaml'));

        $this->assertTestCases([
            ['age' => '18'],
            ['age' => '80'],
        ], true);

        $this->assertTestCases([
            ['age' => '17'],
            ['age' => '81'],
        ], false);
    }

    public function testGenerateTestCasesWithTwoStaticFieldsAndSaveCSVFile()
    {
        $path = getcwd() . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . 'file.txt';

        $this->stubRepository = new CSVRepository(new FileWriter($path));
        $this->setUpControllerAssertingRepositorySave();

        $this->controller->generateTestCasesFrom($this->getFile('v1/002_spec_with_integer_range.yaml'));

        $contents = (new File($path))->getContents();
        $contents = explode("\n", $contents);
        $this->assertEquals(
            [
                '{"group_name":"Form02","properties":{"age":"MTg="},"is_valid":true}',
                '{"group_name":"Form02","properties":{"age":"ODA="},"is_valid":true}',
                '{"group_name":"Form02","properties":{"age":"MTc="},"is_valid":false}',
                '{"group_name":"Form02","properties":{"age":"ODE="},"is_valid":false}',
                ''
            ],
            $contents
        );
    }

    public function assertTestCases($expected, $isValid = true)
    {
        $this->testCaseResults = $this->stubRepository->testCases;

        $output = [];
        $allCasesAreValid = true;
        foreach ($this->testCaseResults as $testCase) {

            if ($isValid && $testCase->isValid())
                $output[] = $testCase->getProperties();

            if (!$isValid && !$testCase->isValid())
                $output[] = $testCase->getProperties();
        }

        if ($isValid)
            $this->assertEquals(true, $allCasesAreValid, 'All test_cases must be valid');

        $this->assertEquals($expected, $output);
    }

    private function getFile($fileName): File
    {
        return new File(
            getcwd() . DIRECTORY_SEPARATOR .
            'tests' . DIRECTORY_SEPARATOR .
            'TestSpecFiles' . DIRECTORY_SEPARATOR .
            $fileName
        );
    }
}


class TestStubRepository implements TestCaseRepository {

    public $testCases;

    public function saveTestCases(array $testCases)
    {
        $this->testCases = $testCases;
    }
}
