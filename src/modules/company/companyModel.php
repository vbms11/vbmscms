<?php

class CompanyModel {
    
    const role_boss = 1;
    const role_finance  = 2;
    const role_worker = 3;
    
    public static $companyRoles = array(
        "companyUserRole.boss" => self::role_boss, 
        "companyUserRole.finance" => self::role_finance, 
        "companyUserRole.worker" => self::role_worker
    );
    
    // company
    
    static function createCompany ($name) {
        
        $name = Database::escape($name);
        Database::query("insert into t_company (name,deleted,registerdate) values ('$name',0,now())");
        $obj = Database::queryAsObject("select last_insert_id() as newid from t_company");
        return $obj->newid;
    }
    
    static function saveCompany ($id, $name) {
        
        $id = Database::escape($id);
        $name = Database::escape($name);
        Database::query("update t_company set name = '$name' where id = '$id'");
    }
    
    static function deleteCompany ($id) {
        
        $id = Database::escape($id);
        Database::query("delete from t_company where id = '$id'");
    }
    
    static function getCompany ($id) {
        
        $id = Database::escape($id);
        return Database::queryAsObject("select c.*, (select count(*) from t_company_user as cu where cu.companyid = '$id') as employees from t_company as c where c.id = '$id'");
    }
    
    
    // company user
    
    static function addCompanyUser ($companyId, $userId, $role) {
        
        $companyId = Database::escape($companyId);
        $userId = Database::escape($userId);
        $role = Database::escape($role);
        Database::query("insert into t_company_user (companyid, userid, role) values('$companyId','$userId','$role')");
        $obj = Database::queryAsObject("select last_insert_id() as newid from t_company_user");
        return $obj->newid;
    }
    
    static function removeCompanyUser ($companyId, $userId) {
        
        $companyId = Database::escape($companyId);
        $userId = Database::escape($userId);
        Database::query("delete from t_company_user where companyid = '$companyId' and userid = '$userId'");
    }
    
    static function getMainUserCompany ($userId) {
        
        $userId = Database::escape($userId);
        return Database::queryAsObject(" 
            select c.*, (select count(*) from t_company_user as cu2 where cu2.companyid = cu1.companyid) as employees 
            from t_company as c 
            join t_company_user as cu1 on cu1.userid = '1'
            order by employees desc");
    }
    
    static function getCompanyUsers ($companyId) {
        
        $companyId = Database::escape($companyId);
        return Database::queryAsArray("select userid from t_company_user where companyid = '$companyId'");
    }
    
    static function getUserCompanys ($userId) {
        
        $userId = Database::escape($userId);
        return Database::queryAsArray("select c.*, cu.*  
            from t_company_user as cu 
            join t_company as c on c.id = cu.companyid 
            where cu.userid = '$userId'");
    }
    
    static function find ($name) {
        
        $name = Database::escape($name);
        return Database::queryAsArray("select * from t_company where name like '%$name%'");
    }
    
}