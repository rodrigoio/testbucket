<?php

namespace TestBucket\Core\DataQualifier;

use InvalidArgumentException;
use TestBucket\Core\BoundaryValue\Virtual\Base\AbstractFactory;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\RangeIterator;
use TestBucket\Core\Specification\Contracts\DataQualifier;

class IntegerLimitValueQualifier implements DataQualifier
{
    /**
     * @var AbstractFactory
     */
    private $factory;
    /**
     * @var mixed
     */
    private $propertyValues;

    public function __construct(AbstractFactory $factory)
    {
        $this->factory = $factory;
    }

    public function setInputData(array $propertyValues)
    {
        $this->propertyValues = $propertyValues;
    }

    public function getOutputData(): array
    {
        $outputData = [];
        $precision = $this->factory->createPrecision($this->getPrecisionValue());
        $inputRangeSet = $this->factory->createRangeSet();

        $range = $this->propertyValues['between'];
        $start = $this->factory->createElement($range['start'], $precision);
        $end = $this->factory->createElement($range['end'], $precision);
        $inputRangeSet->applyUnion($this->factory->createRange($start, $end));

        $inputIterator = $inputRangeSet->getRangeList()->getIterator();
        $outputData = $this->collectValues($inputIterator, $outputData, true);

        $oppositeRangeSet = $inputRangeSet->oppositeSet();
        $oppositeRangeSetIterator = $oppositeRangeSet->getRangeList()->getIterator();
        $outputData = $this->collectValues($oppositeRangeSetIterator, $outputData, false);

        return $outputData;
    }

    private function getPrecisionValue(): int
    {
        $precisionValue = (int) $this->propertyValues['precision'];
        if ($precisionValue <= 0) {
            throw new InvalidArgumentException("Invalid precision value: $precisionValue");
        }
        return $precisionValue;
    }

    private function collectValues(RangeIterator $inputIterator, array $outputData, bool $valid): array
    {
        while ($inputIterator->valid()) {
            $element = $inputIterator->current();
            $start = $element->getStartValue();
            $end = $element->getEndValue();

            if (!$start->isNull()) {
                $outputData[] = new QualifiedValueImp($valid, $start->getValue());
            }
            if (!$end->isNull()) {
                $outputData[] = new QualifiedValueImp($valid, $end->getValue());
            }
            $inputIterator->next();
        }
        return $outputData;
    }
}
