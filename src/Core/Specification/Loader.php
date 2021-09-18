<?php

declare(strict_types=1);

namespace TestBucket\Core\Specification;

use Symfony\Component\Yaml\Yaml;
use TestBucket\Core\Specification\Contracts\Group;
use TestBucket\Core\Specification\Contracts\SpecificationFactory;
use TestBucket\Core\Specification\Contracts\Validator;
use TestBucket\Core\Specification\Contracts\DataQualifierFactory;
use TestBucket\Core\Specification\Contracts\File;

class Loader
{
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
        Validator $validator,
        DataQualifierFactory $dataQualifierFactory,
        SpecificationFactory $specificationFactory
    ) {
        $this->validator = $validator;
        $this->dataQualifierFactory = $dataQualifierFactory;
        $this->specificationFactory = $specificationFactory;
    }

    public function loadData(File $file): Group
    {
        $structure = Yaml::parse($file->getContents());

        $this->validator->validate($structure);

        $group = $this->specificationFactory->createNewGroup($structure['group']);

        foreach ($structure['properties'] as $propertyArray) {
            $this->appendQualifiedData($group, $propertyArray);
        }

        return $group;
    }

    private function appendQualifiedData(Group $group, $propertyArray): void
    {
        $qualifiedData = $this->getQualifiedData($propertyArray['type'], $propertyArray['value']);

        $group->setProperty($propertyArray['name'], $propertyArray['type']);

        foreach ($qualifiedData as $currentData) {
            $group->addPropertyValue(
                $propertyArray['name'],
                $currentData->isValid(),
                $currentData->getValue()
            );
        }
    }

    private function getQualifiedData($type, $value): array
    {
        $qualifier = $this->dataQualifierFactory->createDataQualifier($type, $value);
        return $qualifier->getOutputData();
    }
}
