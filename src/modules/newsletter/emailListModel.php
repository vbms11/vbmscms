<?php

class EmailListModel {

    static function getEmails () {
        return Database::queryAsArray("select id, email from t_email");
    }

    static function getEmail ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select id, email from t_email where id = '$id'");
    }

    static function deleteEmail ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_email where id = '$id'");
    }
    
    static function getCountEmails () {
        $obj = Database::queryAsObject("select count(id) as amount from t_email");
        return $obj->amount;
    }
    
    static function insertEmails ($emails) {
        $count = 0;
        foreach ($emails as $email) {
            $exists = self::isEmailExists($email);
            if ($exists == false) {
                self::insertEmail($email);
                $count++;
            }
        }
        return $count;
    }
    
    static function insertEmail ($email) {
        $email = Database::escape($email);
        Database::query("insert into t_email (email) values('$email')");
        $obj = Database::queryAsObject("select last_insert_id() as newid from t_email");
        return $obj->newid;
    }
    
    static function isEmailExists ($email) {
        $result = false;
        $email = Database::escape($email);
        $obj = Database::queryAsObject("select 1 as email from t_email where email = '$email'");
        if ($obj !== null && $obj->email == "1") {
            $result = true;
        }
        return $result;
    }
}


?>