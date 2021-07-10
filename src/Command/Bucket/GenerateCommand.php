<?php

namespace TestBucket\Command\Bucket;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class GenerateCommand extends Command
{
    protected static $defaultName = 'testbucket:bucket:generate';

    protected function configure()
    {
        $this
            ->setDescription('Generate specified bucket')
            ->setDefinition(
                new InputDefinition([
                    new InputOption("repository", "r", InputOption::VALUE_REQUIRED, "test repository name"),
                    new InputOption("unpacking", "u", InputOption::VALUE_REQUIRED, "load custom extensions to unpack data"),
                    new InputOption("directory", "d", InputOption::VALUE_REQUIRED, "overwrite the default repository directory"),
                ])
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Generate to repository: ' . $input->getOption("repository"));
    }
}
