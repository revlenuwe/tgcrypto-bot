<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class BotCommandMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:bot-command {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new telegram bot command';

    protected $type = 'Bot command';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function getStub()
    {
        return $this->resolveStubPath('/../stubs/bot.command.stub');
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        $replace = [
            '{{ class }}' => $class,
            '{{ commandName }}' => Str::camel(Str::remove('Command', $class))
        ];

        return str_replace(
            array_keys($replace), array_values($replace), $stub
        );
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }


    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers\BotCommands';
    }
}
