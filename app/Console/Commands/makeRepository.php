<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class makeRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';
    protected $type = 'Repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    protected function getStub()
    {
        return app_path('Console/Commands/stub/repository.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Repositories';
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        $repository = str_replace('Repository', '', $class);
        
        return str_replace(
            'DummyModel', // 要被替換的文字
            $repository,           // 替換成的新文字
            $stub                 // 要處理的文字內容
        );
    }
}
