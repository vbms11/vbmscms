<?php

class CmsCustomerModel {
    
    static function getCurrentCmsCustomer () {
        $site = DomainsModel::getCurrentSite();
        return self::getCmsCustomer($site->cmscustomerid);
    }
    
    static function getCmsCustomer ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_cms_customer where id = '$id'");
    }
    
    static function getCmsCustomerByUser ($userId) {
        $userId = Database::escape($userId);
        return Database::queryAsObject("select * from t_cms_customer where userid = '$userId'");
    }
    
    static function getCmsCustomerUser ($cmsCustomerId) {
        $cmsCustomerId = Database::escape($cmsCustomerId);
        return Database::queryAsObject("select u.* from t_cms_customer cc join t_user u on u.id = cc.userid where cc.id = '$cmsCustomerId'");
    }
    
    static function createCmsCustomer ($userId=null) {
        
        if ($userId == null) {
            Database::query("insert into t_cms_customer (userid) values (null)");
        } else {
            $userId = Database::escape($userId);
            Database::query("insert into t_cms_customer (userid) values ('$userId')");
        }
        $result = Database::queryAsObject("select max(id) as newid from t_cms_customer");
        $cmsCustomerId = $result->newid;
        
        return $cmsCustomerId;
    }
    
    static function setCmsCustomerUserId ($cmsCustomerId, $userId) {
        
        $cmsCustomerId = Database::escape($cmsCustomerId);
        $userId = Database::escape($userId);
        
        Database::query("update t_cms_customer set userid = '$userId' where id = '$cmsCustomerId'");
    }
    
    static function deleteCmsCustomer ($cmsCustomerId) {
        
    }
}

?>