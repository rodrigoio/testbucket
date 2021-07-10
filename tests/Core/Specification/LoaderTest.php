<?php
namespace TestBucket\Test\Core\Specification;

use TestBucket\Tests\AbstractTestCase;
use TestBucket\Core\Specification\SpecificationRepository;
use TestBucket\Core\Specification\Loader;
use TestBucket\Core\Specification\File;
use TestBucket\Core\Specification\V1Validator;
use TestBucket\Core\DataQualifier\Factory;
use TestBucket\Repository\EntityFactory;
use TestBucket\Entity\Grouping;

/**
 * @group specification
 */
class LoaderTest extends AbstractTestCase
{
    public function tearDown()
    {
        parent::tearDown();
        if (file_exists(getenv('TESTBUCKET_DIR'))) {
            unlink(getenv('TESTBUCKET_DIR'));
        }
    }

    private function getLoader($fileName): Loader
    {
        $fullPath =
            getcwd() . DIRECTORY_SEPARATOR .
            'tests' . DIRECTORY_SEPARATOR .
            'TestSpecFiles' . DIRECTORY_SEPARATOR .
            $fileName;

        $file = new File($fullPath);
        return new Loader(
            $file,
            new V1Validator(),
            new Factory(),
            new EntityFactory(),
            $this->getGroupingRepository()
        );
    }

    public function testLoadSpecFileWithStaticValue()
    {
        $grouping = $this->getGroupingRepository();
        $loader = $this->getLoader('v1/001_spec.yaml');
        $loader->import();

        $foundGrouping = $grouping->findOneByName('User');
        $this->assertNotNull($foundGrouping->getId());
        $this->assertEquals('User', $foundGrouping->getName());

        $firstProperty = $foundGrouping->getProperties()->first();
        $this->assertEquals('static', $firstProperty->getType());

        $expectedValues = ['User1', 'User2'];
        $values = [];
        foreach ($firstProperty->getValues() as $oneValue) {
            $values[] = $oneValue->getValue();
        }

        sort($expectedValues);
        sort($values);
        $this->assertEquals($expectedValues, $values);
    }

    //TODO - reference existing grouping as property type

    //TODO - reference integerRange type

    /**
     * @return SpecificationRepository
     */
    private function getGroupingRepository(): SpecificationRepository
    {
        return $this->entityManager->getRepository(Grouping::class);
    }
}
