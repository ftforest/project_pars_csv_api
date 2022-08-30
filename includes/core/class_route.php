<?php

class Route {

    // VARS

    public static $path = '';
    public static $query = [];

    // GENERAL

    public static function init() {
        self::info();
        self::route_common();
    }

    private static function info() {
        // vars
        $url = $_SERVER['REQUEST_URI'];
        // formatting
        if (substr($url, 0, 1) == '/') $url = substr($url, 1);
        $url = explode('?', $url);
        self::$path = $url[0] ?? '';
        self::$path = self::$path ? flt_input(self::$path) : 'parser-csv';
        if (isset($url[1])) parse_str($url[1], $tmp);
        // escape data
        if (isset($tmp)) {
            foreach ($tmp as $key => $value) {
                $key = flt_input($key);
                $value = flt_input($value);
                self::$query[$key] = $value;
            }
        }
    }

    // ROUTES

    private static function route_common() {
        if (self::$path == 'home') include "./partials/home.php";
        if (self::$path == 'parser-csv') include "./partials/parser_csv.php";
        return '';
    }

}
