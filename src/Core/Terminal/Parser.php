<?php

namespace Core\Terminal;

class Parser
{
    public $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function parse($rawCommand = null)
    {
        if (!$rawCommand) $rawCommand = $this->command;

        if (is_string($rawCommand)){
            $rawCommand = explode( ' ', $rawCommand);
            array_unshift($rawCommand, 'light');
            return $this->parse($rawCommand);
        }
        else if (is_array($rawCommand)){
            unset($rawCommand[0]);
            $command = isset($rawCommand[1]) ? $rawCommand[1] : null;
            $arguments = [];
            $options = [];

            for ($i = 2; $i <= count($rawCommand); $i++)
            {
                $prop = $rawCommand[$i];
                if ($prop[0] === '-' || ($prop[0] === '{' && $prop[1] === '-') ){
                    $options[] = $prop;
                }else{
                    $arguments[] = $prop;
                }
            }

            return compact('command', 'arguments', 'options');
        }
    }

    public function getClassNameFromFile($file)
    {
        $arr = explode('/', $file);
        $lastKey = count($arr) - 1;
        $fileName = $arr[$lastKey];
        $className = explode('.php', $fileName)[0];

        return $className;

    }
}
