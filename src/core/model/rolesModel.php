<?php

class RolesModel {
    
    static function getModuleRoles ($moduleObj = null) {
        
        $roles = array();
        if ($moduleObj == null) {
            foreach (ModuleModel::getModules() as $module) {
                $roles = array_merge($roles,RolesModel::getModuleRoles($module));
            }
        } else {
            $troles = ModuleModel::getModuleClass($moduleObj)->getRoles();
            if (!is_array($roles))
                return array();
            foreach ($troles as $role) {
                $roles[$role] = $role;
            }
        }
        return $roles;
    }
    
    static function getRoles ($userId) {
        $userId = mysql_real_escape_string($userId);
        $query = "
            SELECT r.userid, tc.name as rolegroup, tc.id as id, tpr.customrole, tpr.modulerole
            FROM t_module_roles tpr
            LEFT JOIN t_roles_custom tc ON tc.id = tpr.customrole
            LEFT JOIN t_roles r ON tc.id = r.roleid
            WHERE r.userid = '$userId'";
        // echo $query;
        return Database::queryAsArray($query);
    }

    static function deleteRoles ($userId) {
        $userId = mysql_real_escape_string($userId);
        Database::query("delete from t_roles where userid = '$userId'");
    }

    static function saveRole ($id,$name,$userId,$roleId) {
        $id = mysql_real_escape_string($id);
        $name = mysql_real_escape_string($name);
        $userId = mysql_real_escape_string($userId);
        $roleId = mysql_real_escape_string($roleId);
        $existsResult = Database::query("select 1 from t_roles where id = '$id'");
        if (mysql_fetch_object($existsResult) == null) {
            Database::query("insert into t_roles (name,userid,roleid) values ('$name', '$userId', '$roleId')");
        } else {
            Database::query("update t_roles set roleid = '$roleId' where id = '$id'");
        }
    }
	



    // user roles
    static function getUserCustomRoles ($userId) {
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsArray("select * from t_roles where userid = '$userId'");
    }
    static function addCustomRoleToUser ($roleId,$userId) {
        $userId = mysql_real_escape_string($userId);
        $roleId = mysql_real_escape_string($roleId);
        $exists = Database::queryAsObject("select 1 as res from t_roles where userid = '$userId' and roleid = '$roleId'");
        if ($exists == null) {
            Database::query("insert into t_roles(userid,roleid) values('$userId','$roleId')");
        }
    }
    static function removeCustomRoleFromUser ($roleId,$userId) {
        $userId = mysql_real_escape_string($userId);
        $roleId = mysql_real_escape_string($roleId);
        Database::query("delete from t_roles where userid = '$userId' and roleid = '$roleId'");
    }



    static function getCustomRoles () {
        return Database::queryAsArray("select * from t_roles_custom","id");
    }
    
    static function getCustomRoleById ($id) {
        $id = mysql_real_escape_string($id);
        return Database::queryAsObject("select * from t_roles_custom where id = '$id'");
    }
    
    static function createCustomRole ($name) {
        $name = mysql_real_escape_string($name);
        Database::query("insert into t_roles_custom (name) values ('$name')");
        $newRole = Database::queryAsObject("select last_insert_id() as newid from t_roles_custom");
        return $newRole->newid;
    }
    
    static function deleteCustomRole ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_roles_custom where id = '$id'");
    }
    
    static function getCustomRoleModuleRoles ($customRoleId) {
        $customRoleId = mysql_real_escape_string($customRoleId);
        $result = Database::query("select * from t_module_roles where customrole = '$customRoleId'");
        $roles = array();
        while ($obj = mysql_fetch_object($result))
            $roles[$obj->modulerole] = $obj;
        return $roles;
    }
    
    static function addModuleRoleToCustomRole ($moduleRoleName,$customRoleId) {
        
        // insert if it dosent exist
        $customRoleId = mysql_real_escape_string($customRoleId);
        $query = "insert into t_module_roles (modulerole,customrole) values ";
        
        // if 
        if (is_array($moduleRoleName)) {
            
            $first = true;
            foreach ($moduleRoleName as $moduleRole) {
                
                // add custom role to query if it dose not already exist
                $moduleRole = mysql_real_escape_string($moduleRole);
                $result = Database::query("select 1 from t_module_roles where modulerole = '$moduleRole' and customrole = '$customRoleId'");
                if (mysql_num_rows($result) == 0) {
                    $query .= $first ? "" : ", ";
                    $query .= "('$moduleRole','$customRoleId')";
                    $first = false;
                }
            }
            
            // run the query if needed
            if (!$first) {
                Database::query($query);
            }
            
        } else {
            
            // inserte custom role if it dose not already exist
            $moduleRoleName = mysql_real_escape_string($moduleRoleName);
            $query .= "('$moduleRoleName','$customRoleId')";
            $result = Database::query("select 1 from t_module_roles where modulerole = '$moduleRoleName' and customrole = '$customRoleId'");
            if (mysql_num_rows($result) == 0) {
                Database::query($query);
            }
        }
        
    }
    
    static function removeModuleRoleFromCustomRole ($moduleRoleName,$customRoleId) {
        $moduleRoleName = mysql_real_escape_string($moduleRoleName);
        $customRoleId = mysql_real_escape_string($customRoleId);
        Database::query("delete from t_module_roles where modulerole = '$moduleRoleName' and customrole = '$customRoleId'");
    }

    static function savePageRole ($pageId,$roleId) {
        $pageId = mysql_real_escape_string($pageId);
        $roleId = mysql_real_escape_string($roleId);
        if (!RolesModel::hasPageRole($pageId,$roleId)) {
            Database::query("insert into t_page_roles (pageid,roleid) values ('$pageId','$roleId')");
        }
    }
    
    static function clearPageRoles ($pageId) {
        $pageId = mysql_real_escape_string($pageId);
        Database::query("delete from t_page_roles where pageid = '$pageId'");
    }
    
    static function clearCustomRoles ($groupId) {
        $groupId = mysql_real_escape_string($groupId);
        Database::query("delete from t_module_roles where customrole = '$groupId'");
    }
    
    static function removePageRole ($pageId,$roleId) {
        $pageId = mysql_real_escape_string($pageId);
        $roleId = mysql_real_escape_string($roleId);
        Database::query("delete from t_page_roles where pageid = '$pageId' and roleid = '$roleId'");
    }
    
    static function getPageRoleByName ($name) {
        $name = mysql_real_escape_string($name);
        $result = Database::query("select * from t_roles_custom where name = '$name'");
        return mysql_fetch_object($result);
    }
    
    static function hasPageRole ($pageId,$roleId) {
        $pageId = mysql_real_escape_string($pageId);
        $roleId = mysql_real_escape_string($roleId);
        $result = Database::query("select 1 from t_page_roles where pageid = '$pageId' and roleid = '$roleId'");
        $obj = mysql_fetch_object($result);
        return $obj != null;
    }

    static function getPageRoles ($pageId) {
        $pageId = mysql_real_escape_string($pageId);
        $result = Database::query("select pr.*, rc.name from t_page_roles pr left join t_roles_custom rc on pr.roleid = rc.id where pr.pageid = '$pageId'");
        $pageRoles = array();
        while ($obj = mysql_fetch_object($result))
            $pageRoles[] = $obj;
        return $pageRoles;
    }

}

?>