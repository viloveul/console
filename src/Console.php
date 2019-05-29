<?php

namespace Viloveul\Console;

use Viloveul\Console\ZipCommand;
use Viloveul\Config\Configuration;
use Viloveul\Container\ContainerAwareTrait;
use Viloveul\Console\Contracts\Console as IConsole;
use Symfony\Component\Console\Application as SymfonyConsole;
use Viloveul\Config\Contracts\Configuration as IConfiguration;

class Console extends SymfonyConsole implements IConsole
{
    use ContainerAwareTrait;

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

        $zip = $container->make(ZipCommand::class, [
            'name' => 'v:zip',
        ]);
        $zip->setDescription('Build zip archive for your working directory.');

        $this->setName($container->get(IConfiguration::class)->get('name', 'Viloveul'));
        $this->setVersion($container->get(IConfiguration::class)->get('version', '1.0'));
        $this->add($zip);

        if ($commands = $container->get(IConfiguration::class)->get('commands')) {
            foreach ($commands as $name => $class) {
                $cmd = $container->make($class, [
                    'name' => $name,
                ]);
                $this->add($cmd);
            }
        }
    }
}
