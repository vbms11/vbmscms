<?php

class InputFeilds {
    
    static function printCheckbox ($name,$checked=null,$class=null) {
        ?><input type="checkbox" value="1" <?php if ($checked) echo "checked=\"true\""; ?> name="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" <?php if ($class != null) echo "class='$class'"; ?> /><?php
    }
    
    static function printTextFeild ($name,$value="",$class=null, $placeholder=null) {
    ?><input type="text" value="<?php echo htmlspecialchars($value,ENT_QUOTES); ?>" name="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" id="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>"<?php if ($class != null) { echo " class='$class'"; } if ($placeholder != null) { echo " placeholder='". htmlspecialchars($placeholder,ENT_QUOTES)."'"; } ?>  /><?php
    }
    
    static function printPasswordFeild ($name,$value="",$class=null) {
        ?><input type="password" value="<?php echo htmlspecialchars($value,ENT_QUOTES); ?>" name="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" id="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" <?php if ($class != null) echo "class='$class'"; ?> /><?php
    }
    
    static function printTextArea ($name,$value="",$class=null,$rows=null) {
        ?><textarea name="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" <?php if ($class != null) echo "class='$class' "; if ($rows != null) echo "rows='$rows' ";  ?> ><?php echo htmlspecialchars($value,ENT_QUOTES); ?></textarea><?php
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
        echo "<select id='".htmlspecialchars($name,ENT_QUOTES)."' name='".htmlspecialchars($name,ENT_QUOTES)."'";
        if ($style != null)
            echo " style='$style'";
        if ($onChange != null)
            echo " onchange='$onChange'";
        echo ">";
        foreach ($valueNameArray as $key => $valueNames) {
            echo "<option value='".htmlspecialchars($key,ENT_QUOTES)."'";
            if ($key == $selectedValue)
                echo " selected='selected'";
            echo ">".htmlspecialchars($valueNameArray[$key])."</option>";
        }
        echo "</select>";
    }
    
    static function printMultiSelect ($name,$options,$selection,$styled=true) {
        
        echo "<select class='multiselect' multiple='multiple' id='".htmlspecialchars($name,ENT_QUOTES)."' name='".htmlspecialchars($name,ENT_QUOTES)."[]'>";
        if (!empty($selection)) {
            foreach ($selection as $value) {
                if (isset($options[$value])) {
                    echo "<option value='".htmlspecialchars($value,ENT_QUOTES)."' selected='true'>".htmlspecialchars($options[$value])."</option>";
                }
            }
        }
        foreach ($options as $key => $valueName) {
            if (empty($selection) || !in_array($key, $selection)) {
                echo "<option value='".htmlspecialchars($key,ENT_QUOTES)."'>".htmlspecialchars($valueName)."</option>";
            }
        }
        echo "</select>";
        
        if ($styled) {
            Context::addRequiredStyle("resource/js/multiselect/css/ui.multiselect.css");
            Context::addRequiredScript("resource/js/multiselect/js/plugins/localisation/jquery.localisation-min.js");
            Context::addRequiredScript("resource/js/multiselect/js/plugins/scrollTo/jquery.scrollTo-min.js");
            Context::addRequiredScript("resource/js/multiselect/js/ui.multiselect.js");
            ?>
            <script type="text/javascript">
            $(function(){
                $("#<?php echo htmlspecialchars($name,ENT_QUOTES); ?>").multiselect();
            });
            </script>
            <?php
        }
    }
    
    static function printMultiFileUpload ($name,$action,$values=array()) {
        Context::addRequiredScript("resource/js/valums-file-uploader/client/fileuploader.js");
        Context::addRequiredStyle("resource/js/valums-file-uploader/client/fileuploader.css");
        ?>
            <div id="file-uploader-<?php echo htmlspecialchars($name,ENT_QUOTES); ?>">
            <noscript>          
                <p>Please enable JavaScript to use file uploader.</p>
                <!-- or put a simple form for upload here -->
            </noscript>         
        </div>
        <script>
        var uploader = new qq.FileUploader({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            element: document.getElementById('file-uploader-<?php echo htmlspecialchars($name,ENT_QUOTES); ?>'),
            // path to server-side upload script
            action: '<?php echo $action; ?>'
        });
        </script>
        <?php
    }
    
    static function printFileUpload ($name,$value) {
	?>
        <input type="file" id="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" name="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value,ENT_QUOTES); ?>" />
	<?php
    }

    static function printDataPicker ($name,$value="") {
        if (empty($value)) {
            $value = date("Y-m-d");
        }
        $dateInfo = date_parse_from_format("Y-m-d", $value);
        ?>
        <input id="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" name="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" value="<?php echo $dateInfo["day"].'/'.$dateInfo["month"].'/'.$dateInfo["year"]; ?>" class="jquiDate" type="text" />
        <?php
    }
    
    static function printSpinner ($name, $value = null) {
        if ($value == null) {
            $value = 0;
        }
        ?>
        <input id="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" name="<?php echo htmlspecialchars($name,ENT_QUOTES); ?>" value="<?php echo htmlspecialchars($value,ENT_QUOTES); ?>" type="text"/>
        <script>
        $("#<?php echo $name; ?>").spinner();
        </script>
	<?php
    }
}
