<?php

namespace Core\View;

use Core\View\Twig\LightTwigEnvironment;
use Jenssegers\Blade\Blade;

class View
{
    /**
     * @param $view
     * @param array $params
     * @return bool
     */
    public static function make($view, $params = [])
    {
        $template = config('view.template');
        if ($template === 'twig'){
            self::renderTwig($view, $params);
        }
        else if ($template === 'blade'){
            self::renderBlade($view, $params);
        }

        return true;
    }

    public static function renderTwig($view, $params = [])
    {
        $view = str_replace('.', '/', $view);
        $view .= '.html';
        $view_path = config('view.view_path');
        $cache_path = config('view.cache_path') . '/twig';

        $loader = new \Twig_Loader_Filesystem($view_path);

        $twig = new LightTwigEnvironment($loader, [
            'cache' => $cache_path
        ]);

        echo $twig->render($view, $params);
    }

    public static function renderBlade($view, $params = [])
    {
        $view_path = config('view.view_path');
        $cache_path = config('view.cache_path') . '/blade';


        $blade = new Blade($view_path, $cache_path);

        echo $blade->make($view, $params);
    }

}
