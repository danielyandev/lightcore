<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 20/02/19
 * Time: 03:23
 */

namespace Core\Http;


class Response
{
    public function make($method, $args)
    {
        if(is_string($method))
        {
            $this->runController($method, $args);
        }
        else if (is_callable($method)){
            $this->runFunction($method, $args);
        }
    }

    public function runController($method, $args)
    {
        $method = explode('@', $method);
        $controller = $method[0];
        $method = $method[1];
        $controller = '\App\Controllers\\'.$controller;

        $controller = new $controller();
        return $controller->$method($args);
    }

    public function runFunction($method, $args)
    {
        return $method($args);
    }
}
