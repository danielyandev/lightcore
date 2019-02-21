<?php

/**
 * @param $url
 * @return string
 */
function convertUrl($url)
{
    $arr[] = '#^';
    $arr[] = preg_replace_callback('#\{[A-z0-9]+\}#', function ($match){
        return '(.+?)';
    }, $url);
    $arr[] = '/*$#i';
    if ($url[0] == '/'){
        return join('', $arr);
    }
    return '/'.join('', $arr);
}

/**
 * @return string
 */
function configPath()
{
    return BASE_DIR . '/config';
}

/**
 * @return string
 */
function viewsPath()
{
    return BASE_DIR . '/views';
}

/**
 * @param $name
 * @param string $default
 * @return mixed
 */
function config($name, $default = '')
{
    $name = explode('.', $name);

    $file = require configPath() . '/' . $name[0] . '.php';
    if (!isset($name[1])){
        return $file;
    }

    $param = $file[$name[1]];
    for ($i = 2; $i < count($name); $i++) {
        $param = $param[$name[$i]];
    }

    return $param;
}
