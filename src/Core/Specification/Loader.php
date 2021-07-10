<?php

declare(strict_types=1);

namespace TestBucket\Core\Specification;

use Symfony\Component\Yaml\Yaml;

class Loader
{
    /**
     * @var File
     */
    private $file;
    /**
     * @var V1Validator
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
    /**
     * @var SpecificationRepository
     */
    private $specificationRepository;

    public function __construct(
        File $file,
        Validator $validator,
        DataQualifierFactory $dataQualifierFactory,
        SpecificationFactory $specificationFactory,
        SpecificationRepository $specificationRepository
    ) {
        $this->file = $file;
        $this->validator = $validator;
        $this->dataQualifierFactory = $dataQualifierFactory;
        $this->specificationFactory = $specificationFactory;
        $this->specificationRepository = $specificationRepository;
    }

    public function import(): void
    {
        $structure = Yaml::parse($this->file->getContents());

        $this->validator->validate($structure);

        $group = $this->specificationFactory->createNewGroup();
        $group->setName($structure['group']);

        array_map(function($propertyArray) use ($group) {

            $qualifier = $this->dataQualifierFactory->createDataQualifier(
                $propertyArray['type'],
                $propertyArray['value'],
                $this->specificationFactory
            );

            $property = $this->specificationFactory->createNewProperty();
            $property->setName($propertyArray['name']);
            $property->setType($propertyArray['type']);

            array_map(function($onePropertyValue) use ($property) {
                $property->addValue($onePropertyValue);
            }, $qualifier->getOutputData());

            $group->addProperty($property);

        }, $structure['properties']);

        $this->specificationRepository->save($group);
    }
}
