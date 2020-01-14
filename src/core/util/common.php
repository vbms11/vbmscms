<?php

include_once 'core/util/database.php';

$baseRand;

class Common {
    
    static function endsWith ($string, $test) {
        $strlen = strlen($string);
        $testlen = strlen($test);
        if ($testlen > $strlen) {
            return false;
        }
        if ($testlen == 0) {
            return true;
        }
        return (substr($string, -$testlen) === $test);
    }
    
    static function isEmpty ($var) {
        if (empty($var)) {
            return true;
        }
        if (is_string($var) && trim($var) == "") {
            return true;
        }
        return false;
    }

    static function hash ($input,$raw=false,$salt=true) {
        return md5($input.($salt ? Config::getServerSecret() : "").sha1($input.($salt ? Config::getServerSecret() : "")),$raw);
    }

    static function randHash ($len = 32,$base64 = true) {
        global $baseRand;
        $secret = isset($CONFIG['serverSecret']) ? $CONFIG['serverSecret'] : Common::rand();
        if ($baseRand == null) {
            $baseRand = sha1(microtime().Common::rand().$secret, true);
            $baseRand .= $baseRand.hash('whirlpool',$baseRand.$secret,true);
        }
        $baseRandPos = 0;
        $hash = "";
        $baseRandLen = strlen($baseRand);
        $lastRand = Common::hash(microtime().Common::rand().$secret,false,false);
        for ($i=0;$i<=ceil($len/6);$i++) {
            $rand = sha1($baseRand.microtime().Common::rand().$secret.$hash.$lastRand,true);
            $rand .= md5($baseRand.Common::rand().$secret.$lastRand.$hash,true);
            if ($base64 == false) {
                $hash.= substr(bin2hex($rand),0,10);
            } else {
                $hash.= substr(base64_encode($rand),0,10);
            }
            
            $baseRandPos++;
            if ($baseRandPos == $baseRandLen) {
                $baseRandPos = 0;
            }
        }
        
        return substr($hash,0,$len);
    }
    
    static function rand ($min = 1000, $max = 1000000000) {
        $result = rand($min, $max);
        return $result;
    }
    
    static function toMap ($objArray, $keyName = null, $valueName = null) {
        $result = array();
        if (!is_array($objArray) || count($objArray) < 1) {
            return $result;
        }
        if ($keyName == null) {
            foreach ($objArray as $obj) {
                $result[$obj] = $obj;
            }
        } else {
            if ($valueName == null) {
                foreach ($objArray as $obj) {
                    if (!Common::isEmpty($obj)) {
                        $result[$obj->$keyName] = $obj;
                    }
                }
            } else {
                foreach ($objArray as $obj) {
                    if (!Common::isEmpty($obj)) {
                        $result[$obj->$keyName] = $obj->$valueName;
                    }
                }
            }
        }
        return $result;
    }
    
    static function htmlEscape ($input,$quotes=true) {
        $mode = $quotes === true ? ENT_QUOTES : ENT_NOQUOTES;
        return htmlspecialchars($input,$mode);
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
    
    static function removeFormatChars ($string) {
        $string = str_replace("\\r\\n|\\n", " ", $string);
        return $string;
    }
    
    static function getSequence($start,$end,$steps) {
        $result = array();
        for ($i=$start; $i<=$end; $i+=$steps) {
            $result[$i] = $i;
        }
        return $result;
    }
    
    static function getMonthNames () {
        return array(1=>"Januar",2=>"Februar",3=>"M&auml;rz",4=>"April",5=>"Mai",6=>"Juni",7=>"Juli",8=>"August",9=>"September",10=>"Oktober",11=>"November",12=>"Dezember");
    }
    
    static function getBacktrace($ignore = 1) {
        $trace = '';
        foreach (debug_backtrace() as $k => $v) {
            if ($k < $ignore) {
                continue;
            }
            $trace .= '#' . ($k - $ignore) . ' ' . $v['file'] . '(' . $v['line'] . '): ' . (isset($v['class']) ? $v['class'] . '->' : '') . $v['function'] . '<br/>';
        }
        return $trace;
    }
    
    static function getAllowedVideoFormats  () {
        return array();
    }
    
    static function getAllowedImageFormats () {
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
