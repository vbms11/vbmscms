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
        $userId = Database::escape($userId);
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
        $userId = Database::escape($userId);
        Database::query("delete from t_roles where userid = '$userId'");
    }

    static function saveRole ($id,$name,$userId,$roleId) {
        $id = Database::escape($id);
        $name = Database::escape($name);
        $userId = Database::escape($userId);
        $roleId = Database::escape($roleId);
        $existsResult = Database::queryAsObject("select 1 from t_roles where id = '$id'");
        if ($existsResult == null) {
            Database::query("insert into t_roles (name,userid,roleid) values ('$name', '$userId', '$roleId')");
        } else {
            Database::query("update t_roles set roleid = '$roleId' where id = '$id'");
        }
    }
    
    // user roles
    static function getUserCustomRoles ($userId) {
        $userId = Database::escape($userId);
        return Database::queryAsArray("select * from t_roles where userid = '$userId'");
    }
    static function addCustomRoleToUser ($roleId,$userId) {
        $userId = Database::escape($userId);
        $roleId = Database::escape($roleId);
        $exists = Database::queryAsObject("select 1 as res from t_roles where userid = '$userId' and roleid = '$roleId'");
        if ($exists == null) {
            Database::query("insert into t_roles(userid,roleid) values('$userId','$roleId')");
        }
    }
    static function removeCustomRoleFromUser ($roleId,$userId) {
        $userId = Database::escape($userId);
        $roleId = Database::escape($roleId);
        Database::query("delete from t_roles where userid = '$userId' and roleid = '$roleId'");
    }



    static function getCustomRoles () {
        return Database::queryAsArray("select * from t_roles_custom","id");
    }
    
    static function getCustomRoleById ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_roles_custom where id = '$id'");
    }
    
    static function createCustomRole ($name, $system) {
        $name = Database::escape($name);
        $system = Database::escape($system);
        Database::query("insert into t_roles_custom (name,system) values ('$name','$system')");
        $newRole = Database::queryAsObject("select max(id) as newid from t_roles_custom");
        return $newRole->newid;
    }
    
    static function deleteCustomRole ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_roles_custom where id = '$id' and system = '0'");
    }
    
    static function getCustomRoleModuleRoles ($customRoleId) {
        $customRoleId = Database::escape($customRoleId);
        return Database::queryAsArray("select * from t_module_roles where customrole = '$customRoleId'", "modulerole");
    }
    
    static function addModuleRoleToCustomRole ($moduleRoleName,$customRoleId) {
        
        // insert if it dosent exist
        $customRoleId = Database::escape($customRoleId);
        $query = "insert into t_module_roles (modulerole,customrole) values ";
        
        // if 
        if (is_array($moduleRoleName)) {
            
            $first = true;
            foreach ($moduleRoleName as $moduleRole) {
                
                // add custom role to query if it dose not already exist
                $moduleRole = Database::escape($moduleRole);
                $result = Database::query("select 1 from t_module_roles where modulerole = '$moduleRole' and customrole = '$customRoleId'");
                if (Database::numRows($result) == 0) {
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
            $moduleRoleName = Database::escape($moduleRoleName);
            $query .= "('$moduleRoleName','$customRoleId')";
            $result = Database::query("select 1 from t_module_roles where modulerole = '$moduleRoleName' and customrole = '$customRoleId'");
            if (Database::numRows($result) == 0) {
                Database::query($query);
            }
        }
        
    }
    
    static function hasModuleRole ($userId, $roleName) {
        $userId = Database::escape($userId);
        $roleName = Database::escape($roleName);
        $result = Database::queryAsObject("select r.userid, tc.name as rolegroup, tc.id as id, tpr.customrole, tpr.modulerole
            from t_module_roles tpr
            join t_roles_custom tc ON tc.id = tpr.customrole
            join t_roles r ON tc.id = r.roleid
            where r.userid = '$userId' and tc.name = '$roleName'");
        return !empty($result);
    }
    
    static function removeModuleRoleFromCustomRole ($moduleRoleName,$customRoleId) {
        $moduleRoleName = Database::escape($moduleRoleName);
        $customRoleId = Database::escape($customRoleId);
        Database::query("delete from t_module_roles where modulerole = '$moduleRoleName' and customrole = '$customRoleId'");
    }

    static function savePageRole ($pageId,$roleId) {
        $pageId = Database::escape($pageId);
        $roleId = Database::escape($roleId);
        if (!RolesModel::hasPageRole($pageId,$roleId)) {
            Database::query("insert into t_page_roles (pageid,roleid) values ('$pageId','$roleId')");
        }
    }
    
    static function clearPageRoles ($pageId) {
        $pageId = Database::escape($pageId);
        Database::query("delete from t_page_roles where pageid = '$pageId'");
    }
    
    static function clearCustomRoles ($groupId) {
        $groupId = Database::escape($groupId);
        Database::query("delete from t_module_roles where customrole = '$groupId'");
    }
    
    static function removePageRole ($pageId,$roleId) {
        $pageId = Database::escape($pageId);
        $roleId = Database::escape($roleId);
        Database::query("delete from t_page_roles where pageid = '$pageId' and roleid = '$roleId'");
    }
    
    static function getPageRoleByName ($name) {
        $name = Database::escape($name);
        return Database::queryAsObject("select * from t_roles_custom where name = '$name'");
    }
    
    static function hasPageRole ($pageId,$roleId) {
        $pageId = Database::escape($pageId);
        $roleId = Database::escape($roleId);
        $result = Database::queryAsObject("select 1 from t_page_roles where pageid = '$pageId' and roleid = '$roleId'");
        return $result != null;
    }

    static function getPageRoles ($pageId) {
        $pageId = Database::escape($pageId);
        return Database::queryAsArray("select pr.*, rc.name from t_page_roles pr left join t_roles_custom rc on pr.roleid = rc.id where pr.pageid = '$pageId'");
    }

}

?>