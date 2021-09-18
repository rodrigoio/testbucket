<?php

namespace TestBucket\Command\Bucket;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TestBucket\Core\Combiner\Factory as CombinerFactory;
use TestBucket\Core\Controller\CombinationService;
use TestBucket\Core\Controller\CombinerController;
use TestBucket\Core\DataQualifier\Factory as DataQualifierFactory;
use TestBucket\Core\IO\FileReader;
use TestBucket\Core\IO\FileWriter;
use TestBucket\Core\Repository\CSVRepository;
use TestBucket\Core\Specification\Domain\Factory as SpecificationFactory;
use TestBucket\Core\Specification\Loader;
use TestBucket\Core\Specification\V1Validator;

class GenerateCommand extends Command
{
    protected static $defaultName = 'testbucket:process';

    protected function configure()
    {
        $this
            ->setDescription('Generate specified bucket')
            ->setDefinition(
                new InputDefinition([
                    new InputOption("spec", "s", InputOption::VALUE_REQUIRED, "spec directory"),
                    new InputOption("output", "o", InputOption::VALUE_REQUIRED, "output directory"),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('--- Starting...');

        $specOption = $input->getOption("spec");
        $outputDirectoryOption = $input->getOption("output");

        $output->writeln(' Read Spec from: [' . $specOption . ']');
        $specFileReader = new FileReader($specOption);

        $output->writeln(' Save result to directory: [' . $outputDirectoryOption . ']');
        $resultName = $outputDirectoryOption . DIRECTORY_SEPARATOR . $this->getSpecName($specOption) . '.txt';
        $resultFileWriter = new FileWriter($resultName);

        $this->getCombinerController($resultFileWriter)->generateTestCasesFrom($specFileReader);

        $output->writeln(' Output: [' . $resultName. ']');
        $output->writeln("--- Finish!\n\n");
    }

    private function getSpecName(string $specFileName): string
    {
        return explode('.', basename($specFileName))[0];
    }

    protected function getSpecificationLoader(): Loader
    {
         return new Loader(
            new V1Validator(),
            new DataQualifierFactory(),
            new SpecificationFactory()
        );
    }

    private function getCombinerController(FileWriter $resultFileWriter): CombinerController
    {
        return new CombinerController(
            $this->getSpecificationLoader(),
            new SpecificationFactory(),
            new CSVRepository($resultFileWriter),
            new CombinationService(new CombinerFactory(), new SpecificationFactory())
        );
    }
}
