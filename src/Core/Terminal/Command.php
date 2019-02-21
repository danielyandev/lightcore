<?php

namespace Core\Terminal;

class Command
{
    public $command;

    public $description;

    public $parser;

    public $arguments;

    public $options;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
        $this->parseArgumentsAndOptions();

    }

    public function __toString()
    {
        return $this->command . " - " . $this->description;
    }

    private function parseArgumentsAndOptions()
    {
        $realCommand = $this->parser->parse();
        $command = $this->parser->parse($this->command);

        $arguments = [];
        for ($i = 0; $i < count($realCommand['arguments']); $i++){
            $key = isset($command['arguments'][$i]) ? $command['arguments'][$i] : null;
            if ($key){
                $key = str_replace(['{', '}', '='], '', $key);
                $arguments[$key] = $realCommand['arguments'][$i];
            }
        }

        $options = [];
        for ($i = 0; $i < count($realCommand['options']); $i++){
            $key = isset($command['options'][$i]) ? $command['options'][$i] : null;
            if ($key){
                $key = str_replace(['{', '}', '='], '', $key);
                $options[$key] = $realCommand['options'][$i];
            }
        }

        $this->arguments = $arguments;
        $this->options = $options;
    }

    public function argument($key)
    {
        return isset($this->arguments[$key]) ? $this->arguments[$key] : null;
    }

    public function option($key)
    {
        return isset($this->options[$key]) ? $this->options[$key] : null;
    }

    /**
     * Creates file by the path with code inside
     *
     * @param $path
     * @param $code
     */
    public function createFile($path, $code)
    {
        $file = fopen($path, 'w');
        fwrite($file, $code);
        fclose($file);
    }

}
