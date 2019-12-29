<?php

class Log {
    
    static function query ($query) {
        if (Config::getQueryLog()) {
            self::logLine("[query] ".$query);
        }
    }
    
    static function info ($text) {
        self::logLine("[info]  ".$text);
    }
    
    static function warn ($text) {
        self::logLine("[warn]  ".$text);
    }
    
    static function error ($text) {
        self::logLine("[error] ".$text);
    }
    
    static function logLine ($text) {
        if (!isset($_SESSION['log.lines'])) {
            $_SESSION['log.lines'] = array();
        }
        $_SESSION['log.lines'][] = $text;
    }
    
    static function writeLogFile () {
        $path = ResourcesModel::getBasePath()."logs/";
        if (!is_dir($path)) {
            mkdir($path);
        }
        $today = date("d.m.Y");
        $filename = "$today.txt";
        $fd = fopen($path.$filename, "a");
        $lines = "";
        if (isset($_SESSION['log.lines'])) {
            foreach ($_SESSION['log.lines'] as $text) {
                $lines .= "[".date("d/m/Y h:i:s")."]\t".$_SERVER['REMOTE_ADDR']."\t".$text.PHP_EOL;
            }
        }
        fwrite($fd, $lines);
        fclose($fd);
        $_SESSION['log.lines'] = array();
    }
    
}