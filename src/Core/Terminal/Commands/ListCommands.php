<?php

namespace Core\Terminal\Commands;

use Core\Terminal\Command;
use Core\Terminal\Terminal;

class ListCommands extends Command
{
    public $command = 'list';

    public $description = 'Lists available commands';

    public function run()
    {
        $path = BASE_DIR . "/app/Terminal/Commands/*.php";
        $files = glob($path);
        foreach ($files as $file){
            $className = $this->parser->getClassNameFromFile($file);
            $fullClassName =  '\App\Terminal\Commands\\' . $className;
            $class = new $fullClassName($this->parser);

            Terminal::log('success', $class);
        }

        $path = __DIR__ . "/*.php";
        $files = glob($path);
        foreach ($files as $file){
            $className = $this->parser->getClassNameFromFile($file);
            $fullClassName =  '\Core\Terminal\Commands\\' . $className;
            $class = new $fullClassName($this->parser);

            Terminal::log('success', $class);
        }

        return true;
    }

}
