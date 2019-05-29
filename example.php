#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

class MyCommand extends Viloveul\Console\Command
{
    public function handle()
    {
        $this->writeNormal('Hello World');
        $this->writeInfo('Hello World');
        $this->writeError('Hello World');
        $this->writeQuestion('Hello World');
        $this->writeComment('Hello World');
    }
}

$console = new Viloveul\Console\Console();
$console->boot();

$cmd = new MyCommand('hello');
$console->add($cmd);

$console->run();
