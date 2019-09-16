<?php
function load_mod($mod, $path = MOD_PATH)
{
    foreach($mod as $item)
    {
        $file = $path . '/' . $item . '.php';
        if(!file_exists($file)) die('Error : Mod "' . $item . '" not found.');
        if(!is_file($file)) die('Error : Mod "' . $item . '" is not file.');

        require_once $file;
    }
}
function load_config($name, $path = CONFIG_PATH)
{
    $file = $path . $name . '.php';
    if(!file_exists($file)) die('Error : Mod "' . $file . '" not found.');
    if(!is_file($file)) die('Error : Mod "' . $file . '" is not file.');

    return require $file;
}