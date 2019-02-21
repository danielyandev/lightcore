<?php

namespace Core\Http;

use Core\Router\Router;

class Request
{
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function getCurrentUri()
    {
        return $this->router->uri;
    }

}
