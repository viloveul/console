<?php

namespace Viloveul\Console;

use Symfony\Component\Console\Application as SymfonyConsole;
use Viloveul\Config\Contracts\Configuration as IConfiguration;
use Viloveul\Console\Contracts\Console as IConsole;
use Viloveul\Console\ZipCommand;
use Viloveul\Container\Contracts\Container as IContainer;

class Console extends SymfonyConsole implements IConsole
{
    /**
     * @var mixed
     */
    protected $container;

    /**
     * @param IConfiguration $config
     * @param IContainer     $container
     */
    public function __construct(IConfiguration $config, IContainer $container)
    {
        parent::__construct('Viloveul', $config->get('version', '1.x'));
        $this->container = $container;
        $this->config = $config;
    }

    public function boot(): void
    {
        $this->add($this->container->factory(ZipCommand::class));
        if ($commands = $this->config->get('commands')) {
            foreach ($commands as $class) {
                $this->add($this->container->factory($class));
            }
        }
    }
}
