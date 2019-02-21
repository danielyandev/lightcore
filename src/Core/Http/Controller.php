<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 20/02/19
 * Time: 06:46
 */

namespace Core\Http;


use Core\View\View;

class Controller
{
    public function render($view, $params = [])
    {
        return View::make($view, $params);
    }
}
