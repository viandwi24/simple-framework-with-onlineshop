<?php
class Cookie
{
    public static function get($key = null, $default = null)   
    {
        if ($key == null) return $_COOKIE;
        if (isset($_COOKIE[$key])) return $_COOKIE[$key];

        /** null return */
        return $default;
    }

    /**
     * set(key, value, time, path)
     */
    public static function set()
    {
        $args = func_get_args();

        if (func_num_args() < 1) die("Error : Session::set() must 2 params, key and value.");
        if (func_num_args() == 2)
        {
            /** var */
            $time = (isset($args[2])) ? $args[2] : strtotime('+1 year');
            $path = (isset($args[3])) ? $args[3] : '/';

            /** set */
            setcookie($args[0], $args[1], $time, $path);
            return true;
        } elseif ( func_num_args() == 1 && is_array($args[0])) {
            /** var */
            $time = (isset($args[2])) ? $args[2] : strtotime('+1 year');
            $path = (isset($args[3])) ? $args[3] : '/';

            /** set */
            foreach($args[0] as $item)
            {
                setcookie($args[0], $args[1], $time, $path);
            }
            return true;
        }

        /** false return */
        return false;
    }
}