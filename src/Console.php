<?php

namespace Viloveul\Console;

use Symfony\Component\Console\Application as SymfonyConsole;
use Viloveul\Config\Configuration;
use Viloveul\Config\Contracts\Configuration as IConfiguration;
use Viloveul\Console\Contracts\Console as IConsole;
use Viloveul\Console\ZipCommand;
use Viloveul\Container\ContainerInjectorTrait;

class Console extends SymfonyConsole implements IConsole
{
    use ContainerInjectorTrait;

    public function boot(): void
    {
        $container = $this->getContainer();
        if ($container->has(IConfiguration::class) === false) {
            $container->set(IConfiguration::class, function () {
                return new Configuration([
                    'name' => 'Viloveul',
                    'version' => '1.0',
                    'root' => getcwd(),
                ]);
            });
        }
        $this->setName($container->get(IConfiguration::class)->get('name', 'Viloveul'));
        $this->setVersion($container->get(IConfiguration::class)->get('version', '1.0'));
        $this->add($container->factory(ZipCommand::class));
        if ($commands = $container->get(IConfiguration::class)->get('commands')) {
            foreach ($commands as $class) {
                if (is_callable($class)) {
                    $this->add($container->invoke($class));
                } elseif (is_object($class)) {
                    $this->add($class);
                } else {
                    $this->add($container->factory($class));
                }
            }
        }
    }
}
