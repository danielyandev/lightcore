<?php

namespace Core\Terminal\Commands;

use Core\Terminal\Command;
use Core\Terminal\Terminal;

class CreateController extends Command
{
    public $command = 'create:controller {name}';

    public $description = 'Create new controller';

    public function run()
    {
        $name = $this->argument('name');

        if (!$name){
            Terminal::log("error", "Controller name is missing");
            Terminal::log("warning", "Type make:controller <ControllerName>");
            return false;
        }

        $controller_path = BASE_DIR . '/app/Controllers/'. $name . '.php';
        $controller_namespace = 'App\Controllers';

        if (!is_file($controller_path)){
            $code =
                "<?php\n".
                "\n".
                "namespace $controller_namespace;\n".
                "\n".
                "class $name extends Controller\n".
                "{\n".
                "\t//\n" .
                "}";

            $this->createFile($controller_path, $code);

            Terminal::log('success', 'Controller '. $name. ' created successfully');
            return true;
        }

        Terminal::log('error', 'Controller with name ' . $name . ' already exists');
        return false;
    }

}
