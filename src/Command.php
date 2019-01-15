<?php

namespace Viloveul\Console;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Viloveul\Console\Contracts\Command as ICommand;

abstract class Command extends SymfonyCommand implements ICommand
{
    /**
     * @var mixed
     */
    protected $input;

    /**
     * @var mixed
     */
    protected $output;

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        return $this->handle();
    }
}
