<?php

namespace Core\Router;

class Router
{
    public $uri;

    public function __construct()
    {
        $this->uri = urldecode(preg_replace('/\?.*/iu', '', $_SERVER['REQUEST_URI']));
    }
}
