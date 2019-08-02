<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SpecCommand extends Command
{
    protected static $defaultName = '99tests:spec';

    protected function configure()
    {
        $this->setDescription('Good morning!');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello!');
    }
}
