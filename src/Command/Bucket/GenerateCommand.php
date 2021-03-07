<?php

namespace TestBucket\Command\Bucket;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected static $defaultName = 'testbucket:bucket:generate';

    protected function configure()
    {
        $this->setDescription('Generate specified bucket');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Lets generate');
    }
}
