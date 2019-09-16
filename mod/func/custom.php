<?php
if (!function_exists('auth')) {
    function auth() {
        global $app;
        if(isset($app['auth'])) return $app['auth'];

        $app['auth'] = new Auth();
        return $app['auth'];
    }
}
if (!function_exists('files')) {
    function files() {
        global $app;
        if(isset($app['files'])) return $app['files'];

        $app['files'] = new File();
        return $app['files'];
    }
}
if (!function_exists('keranjang')) {
    function keranjang() {
        global $app;
        if(isset($app['keranjang'])) return $app['keranjang'];

        $app['keranjang'] = new Keranjang();
        return $app['keranjang'];
    }
}