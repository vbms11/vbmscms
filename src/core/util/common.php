<?php

include_once 'core/util/database.php';

$baseRand;

class Common {
    
    static function isEmpty ($var) {
        if (is_array($var)) {
            return (count($var) < 1) ? true : false;
        }
        if ($var == null || (is_string($var) && trim($var) == "")) {
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
        $baseRand;
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

    static function htmlEntities ($input) {
        $search = array("ö","ü","ä","Ö","Ü","Ä");
        $replace = array("&ouml;","&uuml;","&auml;","&Ouml;","&Uuml;","&Auml;");
        return str_replace($search, $replace, $input);
    }
    
    static function urlEscape ($input) {
        return urlencode($input);
    }
    
    static function toSqlDate ($uiDate) {
        
    }
    
    static function toUiDate () {
        
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
}

class InputFeilds {
    
    static function printCheckbox ($name,$checked,$class=null) {
        ?><input type="checkbox" value="1" <?php if ($checked) echo "checked=\"true\""; ?> name="<?php echo Common::htmlEscape($name); ?>" <?php if ($class != null) echo "class='$class'"; ?> /><?php
    }
    
    static function printTextFeild ($name,$value="",$class=null) {
        ?><input type="text" value="<?php echo Common::htmlEscape($value); ?>" name="<?php echo Common::htmlEscape($name); ?>" id="<?php echo Common::htmlEscape($name); ?>" <?php if ($class != null) echo "class='$class'"; ?> /><?php
    }
    
    static function printTextArea ($name,$value="",$class=null,$rows=null) {
        ?><textarea name="<?php echo Common::htmlEscape($name); ?>" <?php if ($class != null) echo "class='$class' "; if ($rows != null) echo "rows='$rows' ";  ?> ><?php echo Common::htmlEscape($value); ?></textarea><?php
    }
    
    static function printCaptcha ($name) {
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
                $('<div id="myelfinder" />').elfinder({
                    url : '<?php echo NavigationModel::createServiceLink("fileSystem", $fileSystem); ?>',
                    lang : 'en',
                    dialog : { width : 900, modal : true, title : 'elFinder - file manager for web' },
                    closeOnEditorCallback : true,
                    editorCallback : callback
                })
            }
        });
        </script>
        <?php
        /*
        require_once('resource/js/fckeditor/fckeditor.php');
        $oFCKeditor = new FCKeditor("$name") ;
        $oFCKeditor->BasePath = 'resource/js/fckeditor/' ;
        $oFCKeditor->Value = "$value";
        $oFCKeditor->Height = "500px";
        $oFCKeditor->ToolbarSet = 'MyToolbar' ;
        $oFCKeditor->Create();
        */
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
    
    static function printMultiFileUpload ($name,$action,$values) {
        ?>
        <div id="file-uploader">       
            <noscript>          
                <p>Please enable JavaScript to use file uploader.</p>
                <!-- or put a simple form for upload here -->
            </noscript>         
        </div>
        <script>
        var uploader = new qq.FileUploader({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            element: document.getElementById('file-uploader'),
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

    static function printDataPicker ($name,$value) {
	?>
	<input id="<?php echo $name; ?>" name="<?php echo $name; ?>" class="textbox" type="text" value="" />
	<script>
	$("#<?php echo $name; ?>").datepicker();
        $("#<?php echo $name; ?>").datepicker("option", "showAnim", "blind");
        $("#<?php echo $name; ?>").datepicker({changeMonth: true, changeYear: true});
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
        if (!Common::isEmpty($to)) {
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
        if (!Common::isEmpty($to)) {
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
    
    function getContent ($url) {
        $urlHandel = fopen("r",$url);
        // fread($handle, $length)
    }
    
}

class Log {
    
    static function info ($text) {
        Log::write("[info]  ".$text);
    }
    
    static function warn ($text) {
        Log::write("[warn]  ".$text);
    }
    
    static function error ($text) {
        Log::write("[error] ".$text);
    }
    
    static function write ($text) {
        $path = ResourcesModel::getBasePath()."logs/";
        if (!is_dir($path)) {
            mkdir($path);
        }
        $today = date("d.m.Y");
        $filename = "$today.txt";
        $fd = fopen($path.$filename, "a");
        $str = "[" . date("d/m/Y h:i:s", mktime()) . "] \t" . $text;
        fwrite($fd, $str . PHP_EOL);
        fclose($fd);
    }
    
    
}

?>