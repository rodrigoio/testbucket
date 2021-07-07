<?php
declare(strict_types=1);

namespace TestBucket\Core\Specification;

use TestBucket\Core\Common\ParameterBag;
use Symfony\Component\Yaml\Yaml;

//TODO - load config file to database
//TODO - make builder interface to persist expanded values of properties
class SpecLoader
{
    private $filepath;

    public function __construct($filepath)
    {
        $this->filepath = $filepath;
    }

    public function buildSpec() : Spec
    {
        if (!file_exists($this->filepath)) {
            throw new \InvalidArgumentException('Spec file not found in [' . $this->filepath . ']');
        }

        $contents = file_get_contents($this->filepath);
        $structure = Yaml::parse($contents);

        if (!array_key_exists('spec', $structure)) {
            throw new \InvalidArgumentException('Field [spec] not found');
        }
        $specData = $structure['spec'];

        if (!array_key_exists('fields', $specData)) {
            throw new \InvalidArgumentException('Field [fields] not found');
        }
        $fieldsData = $specData['fields'];

        $fields = new FieldList();

        foreach ($fieldsData as $fieldData) {

            $domainData = $fieldData['domain'];

            $parameter = new ParameterBag();

            if (!empty($domainData['args'])) {
                foreach ($domainData['args'] as $key => $value) {
                    $parameter->put($key, $value);
                }
            }

            $domain = new Domain((string) $domainData['type'], $parameter);
            $field = new Field((string) $fieldData['name'], $domain);

            $fields->add($field);
        }

        return new Spec((string) $specData['version'], $specData['name'], $fields);
    }
}
