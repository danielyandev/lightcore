<?php

namespace Core;

use Core\Http\Request;
use Core\Http\Response;
use Illuminate\Database\Capsule\Manager as Capsule;
class App
{

    /**
     * Request instance
     *
     * @var string $request
     */
    public $request;

    /**
     *
     * @var string $response
     */
    public $response;

    /**
     * Session instance
     *
     * @var Session $session
     */
//    public $session;

    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {

    }

    public function handle(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
//        $this->session = new Session();
        $this->loadORM();
        $this->run();

    }

    /**
     * Creates database connection to use models
     */
    public function loadORM()
    {
        $capsule = new Capsule;
        $config = config('db');
        $capsule->addConnection($config);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    /**
     * Runs method caught by router
     * @throws \Exception
     */
    public function run()
    {
        $routes = require BASE_DIR.'/routes/routes.php';
        foreach ($routes as $mainroute) {
            foreach ($mainroute as $route => $method) {
                $args = [];
                if(preg_match(convertUrl($route), $this->request->getCurrentUri(), $args))
                {
                    unset($args[0]);
                    $args = implode(',', $args);

                    return $this->response->make($method, $args);
                }
            }
        }

        throw new \Exception("Route not found");
    }
}
