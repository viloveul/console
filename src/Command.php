<?php

namespace Viloveul\Console;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Viloveul\Console\Contracts\Command as ICommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

abstract class Command extends SymfonyCommand implements ICommand
{
    /**
     * @var mixed
     */
    private $input;

    /**
     * @var mixed
     */
    private $output;

    /**
     * @param  string  $key
     * @return mixed
     */
    public function getArgument(string $key = null)
    {
        if (null === $key) {
            return $this->getArguments();
        }
        return $this->input->getArgument($key);
    }

    /**
     * @return mixed
     */
    public function getArguments(): array
    {
        return $this->input->getArguments();
    }

    /**
     * @return mixed
     */
    public function getInput(): InputInterface
    {
        return $this->input;
    }

    /**
     * @param  string  $key
     * @return mixed
     */
    public function getOption(string $key = null)
    {
        if (null === $key) {
            return $this->getOptions();
        }

        return $this->input->getOption($key);
    }

    /**
     * @return mixed
     */
    public function getOptions(): array
    {
        return $this->input->getOptions();
    }

    /**
     * @return mixed
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    public function hasArgument(string $name): bool
    {
        return $this->input->hasArgument($name);
    }

    /**
     * @param  string  $name
     * @return mixed
     */
    public function hasOption(string $name): bool
    {
        return $this->input->hasOption($name);
    }

    /**
     * @param int $unit
     */
    public function newProgressBar(int $unit = 10): ProgressBar
    {
        return new ProgressBar($this->getOutput(), $unit);
    }

    /**
     * @param InputInterface $input
     */
    public function setInput(InputInterface $input): void
    {
        $this->input = $input;
    }

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
    }

    /**
     * @param $string
     * @param $options
     */
    public function writeComment(string $string, $options = OutputInterface::OUTPUT_NORMAL)
    {
        $this->output->writeLn("<comment>{$string}</comment>", $options);
    }

    /**
     * @param $string
     * @param $options
     */
    public function writeError(string $string, $options = OutputInterface::OUTPUT_NORMAL)
    {
        $this->output->writeLn("<error>{$string}</error>", $options);
    }

    /**
     * @param $string
     * @param $options
     */
    public function writeInfo(string $string, $options = OutputInterface::OUTPUT_NORMAL)
    {
        $this->output->writeLn("<info>{$string}</info>", $options);
    }

    /**
     * @param string     $string
     * @param $options
     */
    public function writeNormal(string $string, $options = OutputInterface::OUTPUT_NORMAL)
    {
        $this->output->writeLn($string, $options);
    }

    /**
     * @param $string
     * @param $options
     */
    public function writeQuestion(string $string, $options = OutputInterface::OUTPUT_NORMAL)
    {
        $this->output->writeLn("<question>{$string}</question>", $options);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setInput($input);
        $this->setOutput($output);

        return $this->handle();
    }
}
