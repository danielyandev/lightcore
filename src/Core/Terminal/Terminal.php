<?php

namespace Core\Terminal;

use Core\Terminal\Commands\ListCommands;

class Terminal
{
    protected $parser;

    protected $userCommandsDirectory = BASE_DIR . "/app/Terminal/Commands";

    protected $userCommandsNamespace = "\App\Terminal\Commands";

    protected $coreCommandsDirectory = __DIR__ . "/Commands";

    protected $coreCommandsNamespace = "\Core\Terminal\Commands";

    /**
     * Colors for console output
     *
     * @var array $outputTypes
     */
    protected static $outputTypes = [
        'error'     => '0;31m',
        'success'   => '0;32m',
        'warning'   => '1;33m',
        'info'      => '1;34m',
    ];

    /**
     * @var string $outputTypeStart
     */
    protected static $outputTypeStart = "\e[";

    /**
     * @var string $outputTypeEnd
     */
    protected static $outputTypeEnd = "\e[0m\n";


    public function handle(array $command)
    {
        $this->parser = new Parser($command);

        $parsed = $this->parser->parse($command);

        $this->runCommand($parsed);
    }

    public function runCommand(array $parsedCommand)
    {
        if (!$parsedCommand['command']){
            $class = new ListCommands($this->parser);
            return $class->run();
        }

        $class = $this->getCommandClass($parsedCommand, $this->userCommandsDirectory, $this->userCommandsNamespace);

        if ($class){
            return $class->run();
        }

        $class = $this->getCommandClass($parsedCommand, $this->coreCommandsDirectory, $this->coreCommandsNamespace);

        if ($class){
            return $class->run();
        }

        Terminal::log('error', 'Command not found');
        Terminal::log('warning', 'Type "php light list" to view all available commands');

    }

    public function getCommandClass(array $parsedCommand, $directory, $namespace)
    {
        $path = $directory . '/*.php';
        $files = glob($path);
        foreach ($files as $file){
            $className = $this->parser->getClassNameFromFile($file);
            $fullClassName =  $namespace . '\\' . $className;
            $class = new $fullClassName($this->parser);
            $command = $class->command;
            $parsed = $this->parser->parse($command);
            if ($parsed['command'] === $parsedCommand['command']){

                return $class;
            }
        }

        return null;
    }

    /**
     * Logs into terminal
     *
     * @param $type
     * @param $string
     */
    public static function log($type, $string)
    {
        $color = self::$outputTypes[$type];
        echo self::$outputTypeStart. $color . $string . self::$outputTypeEnd;
    }
}
