<?php
class Template 
{
    private static $path = BASE_PATH . 'tpl/';
    private static $ext_file = 'php';

    public static function get($file, $v = [])
    {
        foreach($v as $item_k => $item)
        {
            ${$item_k} = $item;
        }
        unset($v);

        return require self::$path . $file . '.' . self::$ext_file;
    }
}