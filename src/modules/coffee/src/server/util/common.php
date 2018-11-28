<?php

class Common {

    static function hash ($input, $raw=false, $salt=true) {
        
        return md5($input.($salt ? Config::getServerSecret() : "").sha1($input.($salt ? Config::getServerSecret() : "")), $raw);
    }

    static function randHash ($len = 32, $base64 = true) {
        global $baseRand;
        $hash = "";
        while (strlen($hash) < $len) {
            $startRand = hash('whirlpool', microtime().Common::rand().Config::getServerSecret(), true);
            $baseRand = hash('whirlpool', microtime().Common::rand().$startRand.$baseRand, true);
            $hash .= $startRand;
        }
        $hash = substr($hash, 0, $len);
        return $hash;
    }
    
    static function rand ($min = 1000, $max = 1000000000) {
        $result = rand($min, $max);
        return $result;
    }

    static function replaceUmls ($input) {
        $search = array("ö","ü","ä","Ö","Ü","Ä");
        $replace = array("&ouml;","&uuml;","&auml;","&Ouml;","&Uuml;","&Auml;");
        return str_replace($search, $replace, $input);
    }
    
    static function urlEscape ($input) {
        return urlencode($input);
    }
    
    static function toSqlDate ($uiDate) {
        $dateInfo = date_parse_from_format("d/m/Y", $uiDate);
        $sqlDate = $dateInfo['year']."-".$dateInfo['month'].'-'.$dateInfo['day'];
        return $sqlDate;
    }
    
    static function toUiDate ($dbDate) {
        $dateInfo = date_parse_from_format("Y-m-d", $dbDate);
        $uiDate = $dateInfo['day']."/".$dateInfo['month'].'/'.$dateInfo['year'];
        return $uiDate;
    }
    
    static function getMonthNames () {
        return array(1=>"Januar",2=>"Februar",3=>"M&auml;rz",4=>"April",5=>"Mai",6=>"Juni",7=>"Juli",8=>"August",9=>"September",10=>"Oktober",11=>"November",12=>"Dezember");
    }
    
    static function getBacktrace($ignore = 2) {
        $trace = '';
        foreach (debug_backtrace() as $k => $v) {
            if ($k < $ignore) {
                continue;
            }
            //$trace .= '#' . ($k - $ignore) . ' ' . $v['file'] . '(' . $v['line'] . '): ' . (isset($v['class']) ? get_class($v['class']) . '->' : '') . $v['function'] . '(' . implode(', ', $v['args']) . ')' . PHP_EOL;
        }
        return $trace;
    }
    
    static function getAllowedImageFormats() {
        return array("jpg","jpeg","png","gif");
    }
    
    static function getAllowedDocumentFormats () {
        return array("doc","dot","docx","docm","dotx","dotm","docb","xls","xlt","xlm","xlsx","xlsm","xltx","xltm","xlsb","xla","xlam","xll","xlw","ppt","pot","pps","pptx","pptm","potx","potm","ppam","ppsx","ppsm","sldx","sldm","accdb","accde","accdt","accdr","pub");
    }
    
    static function getMaximumUploadSize () {
        $default = 5 * 1024 * 1024;
        $result = -1;
        $max_size = parseSizeToBytes(ini_get('post_max_size'));
        $upload_max = parseSizeToBytes(ini_get('upload_max_filesize'));
        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }
        if ($max_size > 0) {
            $result = $max_size;
        } else {
            $result = $default;
        }
        return $max_size;
    }
    
    static function parseSizeToBytes ($size) {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
        $size = preg_replace('/[^0-9\.]/', '', $size);
        if ($unit) {
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        } else {
            return round($size);
        }
    }
    
}

?>