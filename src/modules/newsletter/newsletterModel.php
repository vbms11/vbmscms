<?php

class NewsletterModel {

    static function getNewsletters () {
        return Database::queryAsArray("select id, name, text from t_newsletter");
    }

    static function getNewsletter ($id) {
        $id = mysql_real_escape_string($id);
        return Database::queryAsObject("select id, name, text from t_newsletter where id = '$id'");
    }

    static function createNewsletter ($name,$text) {
        $name = mysql_real_escape_string($name);
        $text = mysql_real_escape_string($text);
        Database::query("insert into t_newsletter(name,text) values('$name','$text')");
        $obj = Database::queryAsObject("select last_insert_id() as newid from t_newsletter");
        return $obj->newid;
    }

    static function updateNewsletter ($id, $name, $text) {
        $id = mysql_real_escape_string($id);
        $name = mysql_real_escape_string($name);
        $text = mysql_real_escape_string($text);
        Database::query("update t_newsletter set name = '$name', text = '$text' where id = '$id'");
    }

    static function deleteNewsletter ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_newsletter where id = '$id'");
    }
}


?>