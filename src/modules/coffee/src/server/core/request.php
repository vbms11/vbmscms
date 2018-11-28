<?php

class Request {
    
    static $key_res = "res";
    static $key_view = "view";
    
    static function get ($name) {
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }
    
    static function post ($name) {
        return isset($_POST[$name]) ? $_POST[$name] : null;
    }
    
    static function postMap () {
        return $_POST;
    }
    
    static function getResource () {
        return self::get(self::key_res);
    }
    
    static function getView () {
        $view = self::get(self::key_view);
        switch ($view) {
            case UI::view_login:
            default:
                return UI::view_login;
        }
    }
    
    static function start () {
        Device::init();
    }
    
}

?>