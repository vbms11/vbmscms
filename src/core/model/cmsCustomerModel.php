<?php

class CmsCustomerModel {
    
    static function getCmsCustomer ($userId) {
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsObject("select * from t_cmscustomer where userid = '$userId'");
    }
    
    static function createCmsCustomer ($userId) {
        $userId = mysql_real_escape_string($userId);
        Database::query("insert into t_cmscustomer (userid) values ('$userId')");
        $result = Database::query("select last_insert_id() as newid from t_cmscustomer");
        return $result->newid;
    }
}

?>