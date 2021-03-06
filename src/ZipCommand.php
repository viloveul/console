<?php

namespace Viloveul\Console;

use ZipArchive;
use Viloveul\Console\Command;
use Viloveul\Container\ContainerAwareTrait;
use Symfony\Component\Console\Input\InputOption;
use Viloveul\Config\Contracts\Configuration as IConfiguration;
use Viloveul\Container\Contracts\ContainerAware as IContainerAware;

class ZipCommand extends Command implements IContainerAware
{
    use ContainerAwareTrait;

    public function configure()
    {
        // $this->addArgument('ignore', InputArgument::OPTIONAL, 'Ignoring file to zip');
        $this->addOption(
            'ignore',
            'ig',
            InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
            'Ignoring file to zip',
            ['.git', '.svn', 'bin']
        );
        $this->addOption(
            'output',
            'o',
            InputOption::VALUE_OPTIONAL,
            'zip filename',
            'bundle.zip'
        );
    }

    public function handle()
    {
        if (defined('VILOVEUL_WORKDIR')) {
            $workdir = VILOVEUL_WORKDIR;
        } else {
            $workdir = $this->getContainer()->get(IConfiguration::class)->get('root');
        }
        $ignores = $this->getOption('ignore');
        $name = $this->getOption('output');

        $zip = new ZipArchive();
        if ($zip->open($workdir . DIRECTORY_SEPARATOR . $name, ZipArchive::CREATE) === true) {
            array_push($ignores, $name);
            $this->deepRecursive($zip, $workdir, $ignores);
            $zip->close();
        }
    }

    /**
     * @param $zip
     * @param $workdir
     * @param array      $ignores
     * @param $cur
     */
    protected function deepRecursive(&$zip, $workdir, array $ignores, $cur = '')
    {
        $scaned = glob($workdir . $cur . DIRECTORY_SEPARATOR . '{,.}[!.,!..]*', GLOB_BRACE);
        $results = array_filter($scaned, function ($value) use ($ignores) {
            return !in_array(basename($value), $ignores);
        });
        foreach ($results as $result) {
            if (is_file($result)) {
                $zip->addFile($result, str_replace($workdir, '', $result));
            } elseif (is_dir($result)) {
                $zip->addEmptyDir(str_replace($workdir, '', $result));
                $this->deepRecursive($zip, $workdir, $ignores, str_replace($workdir, '', $result));
            }
        }
    }
}
