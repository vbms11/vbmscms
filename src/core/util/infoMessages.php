<?php

class InfoMessages {

    public static $type_info = "info";
    public static $type_warning = "warning";
    public static $type_error = "error";
    public static $type_freetext = "freetext";

    static function printMessageBox ($message,$type = "info") {
        $styleClass = "infoMessage_$type";
        echo "<div class='ui-widget-header infoMessage_background'><div class='$styleClass'>$message</div></div>";
    }

    static function printInfoMessage ($message) {
        InfoMessages::printMessageBox($message,InfoMessages::$type_info);
    }

    static function printWarningMessage ($message) {
        InfoMessages::printMessageBox($message,InfoMessages::$type_warning);
    }

    static function printErrorMessage ($message) {
        InfoMessages::printMessageBox($message,InfoMessages::$type_error);
    }
    
    static function printFreetextbox ($message,$styleClass='') {
        echo "<div class='infoMessage_background'><div class='$styleClass' style='margin:10px;'>$message</div></div>";
    }
}

?>