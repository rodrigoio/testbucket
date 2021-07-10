<?php
declare(strict_types=1);

namespace TestBucket\Core\Specification;

use Symfony\Component\Yaml\Yaml;

class FileLoader
{
    private $filepath;

    public function __construct($filepath)
    {
        $this->filepath = $filepath;
    }

    public function load(): void
    {
        if (!file_exists($this->filepath)) {
            throw new \InvalidArgumentException('Spec file not found in [' . $this->filepath . ']');
        }

        $contents = file_get_contents($this->filepath);
        $structure = Yaml::parse($contents);
        //TODO - load config file to database
        //TODO - make builder interface to persist expanded values of properties
    }
}
