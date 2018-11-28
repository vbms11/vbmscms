<?php

class Log {
    
    static $logFileName = "log.txt";
    static $seperateFiles = false;
    
    function log () {
    }
    function error ($message) {
        echo $message;
    }
    function info ($message) {
        echo $message;
    }
    function warn ($message) {
        echo $message;
    }
    function query ($query) {
        if (Config::getQueryLog()) {
            self::logLine("[query] ".$query);
        }
    }
    static function logLine ($text) {
        $logLines = Session::get("Log.lines");
        if (!$logLines) {
            $logLines = array();
        }
        $logLines []= $text;
        Session::get("Log.lines", $logLines);
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
        $logLines = Session::get("Log.lines");
        if ($logLines) {
            foreach ($logLines as $text) {
                $lines .= "[".date("d_m_Y")."]\t".$_SERVER['REMOTE_ADDR']."\t".$text.PHP_EOL;
            }
        }
        fwrite($fd, $lines);
        fclose($fd);
        Session::set("Log.lines", array());
    }
}

?>