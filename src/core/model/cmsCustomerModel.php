<?php

class CmsCustomerModel {
    
    static function getCmsCustomer ($userId) {
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsObject("select * from t_cms_customer where userid = '$userId'");
    }
    
    static function createCmsCustomer ($userId) {
        $userId = mysql_real_escape_string($userId);
        Database::query("insert into t_cms_customer (userid) values ('$userId')");
        $result = Database::query("select last_insert_id() as newid from t_cms_customer");
        return $result->newid;
    }
}

?>