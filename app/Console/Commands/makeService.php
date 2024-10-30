<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class makeService extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new services class';
    protected $type = 'Service';

    protected function getStub()
    {
        return app_path('Console/Commands/stub/service.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $repository = str_replace('Service', '', $class) . 'Repository';
        
        return str_replace(
            'DummyRepository', // 要被替換的文字
            $repository,           // 替換成的新文字
            $stub                 // 要處理的文字內容
        );
    }
}
