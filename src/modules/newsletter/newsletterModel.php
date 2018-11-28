<?php

class NewsletterModel {

    static function getNewsletters () {
        return Database::queryAsArray("select id, name, text from t_newsletter");
    }

    static function getNewsletter ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select id, name, text from t_newsletter where id = '$id'");
    }

    static function createNewsletter ($name,$text) {
        $name = Database::escape($name);
        $text = Database::escape($text);
        Database::query("insert into t_newsletter(name,text) values('$name','$text')");
        $obj = Database::queryAsObject("select last_insert_id() as newid from t_newsletter");
        return $obj->newid;
    }

    static function updateNewsletter ($id, $name, $text) {
        $id = Database::escape($id);
        $name = Database::escape($name);
        $text = Database::escape($text);
        Database::query("update t_newsletter set name = '$name', text = '$text' where id = '$id'");
    }

    static function deleteNewsletter ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_newsletter where id = '$id'");
    }
}


?>