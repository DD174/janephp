<?php

namespace Jane\JsonSchema;

use PhpCsFixer\Console\Command\FixCommand;
use PhpCsFixer\ToolInfo;
use PhpParser\PrettyPrinterAbstract;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class Printer
{
    private $prettyPrinter;

    private $fixerConfig;

    private $useFixer;

    public function __construct(PrettyPrinterAbstract $prettyPrinter, string $fixerConfig = '', bool $useFixer = false)
    {
        $this->prettyPrinter = $prettyPrinter;
        $this->fixerConfig = $fixerConfig;
        $this->useFixer = $useFixer;
    }

    public function setUseFixer(bool $useFixer): void
    {
        $this->useFixer = $useFixer;
    }

    public function output(Registry $registry): void
    {
        foreach ($registry->getSchemas() as $schema) {
            foreach ($schema->getFiles() as $file) {
                if (!file_exists(\dirname($file->getFilename()))) {
                    mkdir(\dirname($file->getFilename()), 0755, true);
                }

                file_put_contents($file->getFilename(), $this->prettyPrinter->prettyPrintFile([$file->getNode()]));
            }
        }

        if ($this->useFixer) {
            foreach ($registry->getOutputDirectories() as $directory) {
                $this->fix($directory);
            }
        }
    }

    protected function getDefaultRules()
    {
        $rules = [
            '@Symfony' => true,
            'self_accessor' => true,
            'array_syntax' => ['syntax' => 'short'],
            'concat_space' => ['spacing' => 'one'],
            'declare_strict_types' => true,
            'header_comment' => [
                'header' => <<<EOH
This file has been auto generated by Jane,

Do no edit it directly.
EOH
                ,
            ],
        ];

        if (version_compare(\PhpCsFixer\Console\Application::VERSION, '2.6.0', '>=')) {
            $rules['yoda_style'] = null;
        }

        return json_encode($rules);
    }

    protected function fix(string $path): void
    {
        if (!class_exists(FixCommand::class)) {
            return;
        }

        $command = new FixCommand(new ToolInfo());
        $config = [
            'path' => [$path],
            '--allow-risky' => true,
        ];

        if (!empty($this->fixerConfig)) {
            $config['--config'] = $this->fixerConfig;
        } else {
            $config['--rules'] = $this->getDefaultRules();
        }

        $command->run(new ArrayInput($config, $command->getDefinition()), new NullOutput());
    }
}
