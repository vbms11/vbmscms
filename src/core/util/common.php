<?php

include_once 'core/util/database.php';

$baseRand;

class Common {
    
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
        return md5($input.($salt ? $GLOBALS['serverSecret'] : "").sha1($input.($salt ? $GLOBALS['serverSecret'] : "")),$raw);
    }

    static function randHash ($len = 32,$base64 = true) {
        global $baseRand;
        if ($baseRand == null) {
            $baseRand = sha1(microtime().Common::rand().$GLOBALS['serverSecret'], true);
            $baseRand .= $baseRand.hash('whirlpool',$baseRand.$GLOBALS['serverSecret'],true);
        }
        $baseRandPos = 0;
        $hash = "";
        $baseRandLen = strlen($baseRand);
        $lastRand = Common::hash(microtime().Common::rand().$GLOBALS['serverSecret']);
        for ($i=0;$i<=ceil($len/6);$i++) {
            $rand = sha1($baseRand.microtime().Common::rand().$GLOBALS['serverSecret'].$hash.$lastRand,true);
            $rand .= md5($baseRand.Common::rand().$GLOBALS['serverSecret'].$lastRand.$hash,true);
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
        // echo "key:".$keyName;
        // echo " - ";
        // echo "value:".$valueName;
        // echo " - ";
        // var_dump($objArray);
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
}

class InputFeilds {
    
    static function printCheckbox ($name,$checked=null,$class=null) {
        ?><input type="checkbox" value="1" <?php if ($checked) echo "checked=\"true\""; ?> name="<?php echo Common::htmlEscape($name); ?>" <?php if ($class != null) echo "class='$class'"; ?> /><?php
    }
    
    static function printTextFeild ($name,$value="",$class=null) {
        ?><input type="text" value="<?php echo htmlentities($value,ENT_QUOTES); ?>" name="<?php echo Common::htmlEscape($name); ?>" id="<?php echo Common::htmlEscape($name); ?>" <?php if ($class != null) echo "class='$class'"; ?> /><?php
    }
    
    static function printPasswordFeild ($name,$value="",$class=null) {
        ?><input type="password" value="<?php echo htmlentities($value,ENT_QUOTES); ?>" name="<?php echo Common::htmlEscape($name); ?>" id="<?php echo Common::htmlEscape($name); ?>" <?php if ($class != null) echo "class='$class'"; ?> /><?php
    }
    
    static function printTextArea ($name,$value="",$class=null,$rows=null) {
        ?><textarea name="<?php echo Common::htmlEscape($name); ?>" <?php if ($class != null) echo "class='$class' "; if ($rows != null) echo "rows='$rows' ";  ?> ><?php echo Common::htmlEscape($value); ?></textarea><?php
    }
    
    static function printCaptcha ($name) {
        Context::addRequiredStyle("resource/css/captcha.css");
        $captcha = Captcha::getCaptcha($name);
        ?>
        <div class="captchaDiv">
            <div class="captchaImgDiv"><img src="<?php echo NavigationModel::createServiceLink("images",array("action"=>"captcha","name"=>$name,"rand"=>Common::rand())); ?>" alt="" /></div>
            <div class="captchaInputDiv">
		<input type="text" name="<?php echo $captcha->inputName; ?>_answer" value="" />
		<input type="hidden" name="<?php echo $captcha->inputName; ?>_key" value="<?php echo $captcha->key; ?>" />
	    </div>
        </div>
        <?php
    }
    
    static function printHtmlEditor ($name,$value="",$cssFile="",$fileSystem = array("action"=>"www")) {
        Context::addRequiredStyle("resource/js/elfinder/css/elfinder.min.css");
        Context::addRequiredScript("resource/js/elfinder/js/elfinder.min.js");
        Context::addRequiredStyle("resource/js/elrte/css/elrte.min.css");
        Context::addRequiredScript("resource/js/elrte/js/elrte.min.js");
        Context::addRequiredScript("resource/js/elrte/js/i18n/elrte.en.js");
        ?>
        <textarea id="<?php echo $name; ?>" name="<?php echo $name; ?>">
            <?php echo htmlspecialchars($value,ENT_QUOTES); ?>
        </textarea>
        <script>
        $('#<?php echo $name; ?>').elrte({
            doctype : '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">',
            absoluteURLs: false,
            cssClass : 'el-rte',
            lang     : 'en',
            height   : 420,
            allowSource: true,
            toolbar  : 'maxi',
            cssfiles : ['<?php echo $cssFile; ?>'],
            fmOpen : function(callback) {
                $('<div />').dialogelfinder({
                    url : '<?php echo NavigationModel::createServiceLink("fileSystem", $fileSystem); ?>',
                    lang : 'en',
                    commandsOptions: {
                        getfile: {
                            oncomplete: 'destroy' // destroy elFinder after file selection
                        }
                    },
                    getFileCallback : function(file) { callback(file); }
                }).elfinder('instance');
            }
        });
        </script>
        <?php
    }
    
    static function printBBEditor ($name,$value="") {
        
    }
    
    static function printSelect ($name,$selectedValue,$valueNameArray,$style=null,$onChange=null) {
        $selectedValue = Common::htmlEscape($selectedValue);
        echo "<select class='expand' id='".Common::htmlEscape($name)."' name='".Common::htmlEscape($name)."'";
        if ($style != null)
            echo " style='$style'";
        if ($onChange != null)
            echo " onchange='$onChange'";
        echo ">";
        foreach ($valueNameArray as $key => $valueNames) {
            echo "<option value='".Common::htmlEscape($key)."'";
            if ($key == $selectedValue)
                echo " selected=true";
            echo ">".$valueNameArray[Common::htmlEscape($key)]."</option>";
        }
        echo "</select>";
    }
    
    static function printMultiSelect ($name,$options,$selection,$styled=true) {
        
        Context::addRequiredStyle("resource/js/multiselect/css/ui.multiselect.css");
        Context::addRequiredScript("resource/js/multiselect/js/plugins/localisation/jquery.localisation-min.js");
        Context::addRequiredScript("resource/js/multiselect/js/plugins/scrollTo/jquery.scrollTo-min.js");
        Context::addRequiredScript("resource/js/multiselect/js/ui.multiselect.js");
        
        echo "<select class='multiselect' multiple='multiple' id='$name' name='".$name."[]'>";
        foreach ($options as $key => $valueName) {
            echo "<option value='".$key."'";
            if (!Common::isEmpty($selection) && array_key_exists($key, $selection))
                echo " selected=true";
            echo ">".$valueName."</option>";
        }
        echo "</select>";
        
        if ($styled) {
            ?>
            <script type="text/javascript">
            $(function(){
                $("#<?php echo $name; ?>").multiselect();
            });
            </script>
            <?php
        }
    }
    
    static function printMultiFileUpload ($name,$action,$values=array()) {
        Context::addRequiredScript("resource/js/valums-file-uploader/client/fileuploader.js");
        Context::addRequiredStyle("resource/js/valums-file-uploader/client/fileuploader.css");
        ?>
        <div id="file-uploader-<?php echo $name; ?>">       
            <noscript>          
                <p>Please enable JavaScript to use file uploader.</p>
                <!-- or put a simple form for upload here -->
            </noscript>         
        </div>
        <script>
        var uploader = new qq.FileUploader({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            element: document.getElementById('file-uploader-<?php echo $name; ?>'),
            // path to server-side upload script
            action: '<?php echo $action; ?>'
        });
        </script>
        <?php
    }
    
    static function printFileUpload ($name,$value) {
	?>
	<input type="file" id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
	<?php
    }

    static function printDataPicker ($name,$value="") {
        $dateInfo = date_parse_from_format("Y-m-d", $value);
        ?>
	<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" class="jquiDate" type="text" value="<?php echo $value; ?>" />
        <script>
        $("#<?php echo $name; ?>").datepicker( "setDate", new Date(<?php echo $dateInfo["year"]; ?>,<?php echo $dateInfo["month"]; ?>,<?php echo $dateInfo["day"]; ?>) );
        </script>
	<?php
    }
    
    static function printSpinner ($name, $value = null) {
        if ($value == null) {
            $value = 0;
        }
        ?>
	<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>" type="text"/>
        <script>
        $("#<?php echo $name; ?>").spinner();
        </script>
	<?php
    }
}


class UiOutput {
    
    function renderTable () {
        
    }
}


class EmailUtil {

    /*
     * sends a plain text email
     */
    static function sendEmail ($to,$subject,$content,$from) {
        if (!empty($to)) {
            $header  = "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/plain; charset=iso-8859-1\r\n";
            $header .= "From: $from\r\n";
            $header .= "Reply-To: $from\r\n";
            $header .= "X-Mailer: PHP ". phpversion();
            Log::info("sending email: to = '$to' subject = '$subject'");
            mail($to,$subject,$content,$header) or die("error sending mail");
        }
    }

    /*
     * sends a html email
     */
    static function sendHtmlEmail ($to,$subject,$content,$from) {
        // make it a html email
        if (!empty($to)) {
            $header  = "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $header .= "From: $from\r\n";
            $header .= "Reply-To: $from\r\n";
            $header .= "X-Mailer: PHP ". phpversion();
            Log::info("sending email: to = '$to' subject = '$subject'");
            mail($to,$subject,$content,$header) or die("error sending mail");
        }
        
    }
}

class Http {
    
    function doseFileExist ($url) {
        
    }
    
    static function getContent ($url) {
        return file_get_contents($url);
    }
    
}

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
                $lines .= "[".date("d/m/Y h:i:s", mktime())."]\t".$_SERVER['REMOTE_ADDR']."\t".$text.PHP_EOL;
            }
        }
        fwrite($fd, $lines);
        fclose($fd);
        $_SESSION['log.lines'] = array();
    }
    
    
}

?>