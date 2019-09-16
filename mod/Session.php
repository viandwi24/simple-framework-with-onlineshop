<?php
class Session
{
    public static function get($key = null, $default = null)   
    {
        if ($key == null) return $_SESSION;
        if (isset($_SESSION[$key])) return $_SESSION[$key];

        /** null return */
        return $default;
    }

    public static function set()
    {
        $args = func_get_args();

        if (func_num_args() < 1) die("Error : Session::set() must 2 params, key and value.");
        if (func_num_args() == 2)
        {
            $_SESSION[$args[0]] = $args[1];
            return true;
        } elseif ( func_num_args() == 1 && is_array($args[0])) {
            foreach($args[0] as $item)
            {
                $_SESSION[$item[0]] = $item[1];
            }
            return true;
        }

        /** false return */
        return false;
    }
}