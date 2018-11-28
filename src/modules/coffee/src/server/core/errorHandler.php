<?php

function printStacktrace ($trace) {
    echo '<p class="error_backtrace">';
    //echo "Backtrace from '$type' '$errstr' at '$errfile' '$errline':";
    echo "<ol>\n";
    foreach ($trace as $item) {
        echo '<li>' . (isset($item['file']) ? $item['file'] : '<unknown file>') . ' ' . (isset($item['line']) ? $item['line'] : '<unknown line>') . ' calling ' . $item['function'] . '()</li>' . "\n";
    }
    echo "</ol>\n";
    echo "</p>\n";
    
    /*
    if(ini_get('log_errors')) {
        $items = array();
        foreach($trace as $item) {
            $items[] = (isset($item['file']) ? $item['file'] : '<unknown file>') . ' ' . (isset($item['line']) ? $item['line'] : '<unknown line>') . ' calling ' . $item['function'] . '()';
        }
        $message = 'Backtrace from ' . $type . ' \'' . $errstr . '\' at ' . $errfile . ' ' . $errline . ': ' . join(' | ', $items);
        error_log($message);
    }
    */
}

function printShortException (Exception $e) {
    
    echo "Type: ".get_class($e)."; Message: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()};";
    //file_put_contents($config["app_dir"]."/tmp/logs/exceptions.log", $message.PHP_EOL, FILE_APPEND);
    header("Location: {}");
}

function printVerboseException (Exception $e) {
    
        print "<div style='text-align: center;'>";
        print "<h2 style='color: rgb(190, 50, 50);'>Exception Occured:</h2>";
        print "<table style='width: 800px; display: inline-block;'>";
        print "<tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Type</th><td>".get_class($e)."</td></tr>";
        print "<tr style='background-color:rgb(240,240,240);'><th>Message</th><td>{$e->getMessage()}</td></tr>";
        print "<tr style='background-color:rgb(230,230,230);'><th>File</th><td>{$e->getFile()}</td></tr>";
        print "<tr style='background-color:rgb(240,240,240);'><th>Line</th><td>{$e->getLine()}</td></tr>";
        print "</table></div>";
}

function printDevice () {
    echo nl2br(print_r(Device));
}

/**
* Uncaught exception handler.
*/
function log_exception(Exception $e)
{
    global $config;
    
    if (!class_exists("Config") || !Config::isLoaded()) {
        printVerboseException($e);
        printDevice();
        exit();
    }
    
    if (Config::getDebug() == true) {
        printVerboseException($e);
    } else {
        printShortException();
    }
    
    exit();
}

/**
* Error handler, passes flow over the exception logger with new ErrorException.
*/
function log_error($num, $str, $file, $line, $context = null) {
    log_exception(new ErrorException($str, 0, $num, $file, $line));
}

/**
* Checks for a fatal error, work around for set_error_handler not working on fatal errors.
*/
function check_for_fatal() {
    
    $error = error_get_last();
    if ($error["type"] == E_ERROR) {
        log_error($error["type"], $error["message"], $error["file"], $error["line"]);
    }
}

register_shutdown_function("check_for_fatal");
set_error_handler("log_error");
set_exception_handler("log_exception");
ini_set("display_errors", "off");
error_reporting(E_ALL);

?>