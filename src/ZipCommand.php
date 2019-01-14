<?php

namespace Viloveul\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Viloveul\Config\Contracts\Configuration as IConfiguration;
use Viloveul\Console\Command;
use ZipArchive;

class ZipCommand extends Command
{
    /**
     * @var mixed
     */
    protected $config;

    /**
     * @param IConfiguration $config
     */
    public function __construct(string $name = 'build-zip', IConfiguration $config = null)
    {
        parent::__construct($name);
        $this->setDescription('Build zip archive for your working directory.');
        $this->config = $config;
    }

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

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $workdir = defined('VILOVEUL_WORKDIR') ? VILOVEUL_WORKDIR : $this->config->get('root');
        $ignores = $input->getOption('ignore');
        $name = $input->getOption('output');

        $zip = new ZipArchive();
        if ($zip->open($workdir . DIRECTORY_SEPARATOR . $name, ZipArchive::CREATE) === true) {
            array_push($ignores, $name);
            $this->deepRecursive($zip, $workdir, $ignores);
            $zip->close();
        }
    }
}
