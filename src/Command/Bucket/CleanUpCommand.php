<?php

namespace TestBucket\Command\Bucket;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CleanUpCommand extends Command
{
    protected static $defaultName = 'testbucket:bucket:clean';

    protected function configure()
    {
        $this->setDescription('Clean up the specified bucket');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Lets clean up');
    }
}