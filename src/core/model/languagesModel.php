<?php

class LanguagesModel {
    
    static function selectLanguage () {
        // set the language
        $lang = "en";
        if (isset($_GET['changelang'])) {
            $lang = $_GET['changelang'];
        } else if (isset($_SESSION["req.lang"])) {
            $lang = $_SESSION["req.lang"];
        } else {
            if (isset($_REQUEST['local'])) {
                switch ($_REQUEST['local']) {
                    case "en_us":
                        $lang = $_SESSION["req.lang"] = "en";
                    case "es_sp":
                        $lang = $_SESSION["req.lang"] = "sp";
                }
            }
        }
        $_SESSION["req.lang"] = $lang;
    }
    
    static function getLanguages () {
        return Database::queryAsArray("select * from t_language order by isdefault desc, id asc");
    }

    static function getActiveLanguages () {
        return Database::queryAsArray("select * from t_language where active = '1' order by isdefault desc, id asc");
    }

    static function saveLanguage ($id,$flag,$active) {
        $id = mysql_real_escape_string($id);
        $flag = mysql_real_escape_string($flag);
        $active = mysql_real_escape_string($active);
        return Database::query("update t_language set flag = '$flag', active = '$active' where id = '$id'");
    }

}

?>