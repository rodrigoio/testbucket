<?php

declare(strict_types=1);

namespace TestBucket\Core\Specification;

use Symfony\Component\Yaml\Yaml;
use TestBucket\Core\Specification\Contracts\Group;
use TestBucket\Core\Specification\Contracts\SpecificationFactory;
use TestBucket\Core\Specification\Contracts\Validator;
use TestBucket\Core\Specification\Contracts\DataQualifierFactory;

class Loader
{
    /**
     * @var File
     */
    private $file;
    /**
     * @var Validator
     */
    private $validator;
    /**
     * @var DataQualifierFactory
     */
    private $dataQualifierFactory;
    /**
     * @var SpecificationFactory
     */
    private $specificationFactory;

    public function __construct(
        File $file,
        Validator $validator,
        DataQualifierFactory $dataQualifierFactory,
        SpecificationFactory $specificationFactory
    ) {
        $this->file = $file;
        $this->validator = $validator;
        $this->dataQualifierFactory = $dataQualifierFactory;
        $this->specificationFactory = $specificationFactory;
    }

    public function loadData(): Group
    {
        $structure = Yaml::parse($this->file->getContents());

        $this->validator->validate($structure);

        $group = $this->specificationFactory->createNewGroup($structure['group']);

        foreach ($structure['properties'] as $propertyArray) {

            if (empty($propertyArray['value'])) {
                continue;
            }
            $this->appendQualifiedData($propertyArray, $group);
        }
        return $group;
    }

    private function appendQualifiedData($propertyArray, Group $group): void
    {
        $group->setProperty($propertyArray['name'], $propertyArray['type']);

        $qualifier = $this->dataQualifierFactory->createDataQualifier(
            $propertyArray['type'],
            $propertyArray['value']
        );
        $qualifiedData = $qualifier->getOutputData();

        foreach ($qualifiedData as $currentData) {

            $group->addPropertyValue(
                $propertyArray['name'],
                $currentData->isValid(),
                $currentData->getValue()
            );
        }
    }
}
