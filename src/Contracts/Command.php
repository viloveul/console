<?php

namespace Viloveul\Console\Contracts;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface Command
{
    /**
     * @param string $key
     */
    public function getArgument(string $key = null);

    public function getArguments(): array;

    public function getInput(): InputInterface;

    /**
     * @param string $key
     */
    public function getOption(string $key = null);

    public function getOptions(): array;

    public function getOutput(): OutputInterface;

    public function handle();

    /**
     * @param string $name
     */
    public function hasArgument(string $name): bool;

    /**
     * @param string $name
     */
    public function hasOption(string $name): bool;

    /**
     * @param InputInterface $input
     */
    public function setInput(InputInterface $input): void;

    /**
     * @param OutputInterface $output
     */
    public function setOutput(OutputInterface $output): void;

    /**
     * @param string     $string
     * @param $options
     */
    public function writeComment(string $string, $options = OutputInterface::OUTPUT_NORMAL);

    /**
     * @param string     $string
     * @param $options
     */
    public function writeError(string $string, $options = OutputInterface::OUTPUT_NORMAL);

    /**
     * @param string     $string
     * @param $options
     */
    public function writeInfo(string $string, $options = OutputInterface::OUTPUT_NORMAL);

    /**
     * @param string     $string
     * @param $options
     */
    public function writeNormal(string $string, $options = OutputInterface::OUTPUT_NORMAL);

    /**
     * @param string     $string
     * @param $options
     */
    public function writeQuestion(string $string, $options = OutputInterface::OUTPUT_NORMAL);
}
