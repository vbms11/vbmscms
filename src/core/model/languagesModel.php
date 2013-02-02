<?php

class LanguagesModel {
    
    static function getLanguages () {
        return Database::queryAsArray("select * from t_language");
    }

    static function getActiveLanguages () {
        return Database::queryAsArray("select * from t_language where active = '1'");
    }

    static function saveLanguage ($id,$flag,$active) {
        $id = mysql_real_escape_string($id);
        $flag = mysql_real_escape_string($flag);
        $active = mysql_real_escape_string($active);
        return Database::query("update t_language set flag = '$flag', active = '$active' where id = '$id'");
    }

}

?>