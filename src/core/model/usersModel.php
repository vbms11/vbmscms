<?php

require_once 'core/model/rolesModel.php';
require_once 'core/model/eventsModel.php';
require_once 'core/util/common.php';
require_once 'core/context.php';

class UsersModel {

    static function login ($username,$password) {
        $username = mysql_real_escape_string($username);
        $password = md5($password);
        $result = Database::query("select * from t_users where username = '$username' and password = '$password' and active = '1'");
        $userObj = mysql_fetch_object($result);
        
        // validate login
        if ($userObj != null && $userObj->username == $username && $userObj->password == $password) {
            Context::setUser($userObj->id,$username);
            Context::reloadRoles();
            return true;
        }
        return false;
    }
    
    static function loginWithKey ($key) {
        $key = mysql_real_escape_string($key);
        $result = Database::query("select * from t_users where authkey = '$key' and active = '1'") or die (mysql_error());
        $userObj = mysql_fetch_object($result);
        
        // validate login
        if ($userObj != null) {
            
            Context::setUser($userObj->id,$username);
            
            // add all module roles the uesr has
            $userRoles = RolesModel::getRoles($userObj->id);
            foreach ($userRoles as $userRole) {
                Context::addRoleGroup($userRole->customrole, $userRole->rolegroup);
                Context::addRole($userRole->customrole,$userRole->modulerole);
            }
            
            return true;
        }
        return false;
    }

    static function logout () {
        Session::clear();
    }

    static function getUsers ($registered = null, $active = null) {
        $condition = "";
        //if ($registered != null) {
        //    $condition .= "active = '".($registered ? '1' : '0')."' ";
        //}
        if ($active != null) {
            $condition .= "active = '".($active ? '1' : '0')."' ";
        }
        if ($condition != "") {
            $condition = "where ".$condition;
        }
        
        $usersQuery = Database::query("select * from t_users $condition");
        $users = array();
        while (($obj = mysql_fetch_object($usersQuery)) != null) {
            $users[] = $obj;
        }
        return $users;
    }

    static function getUser ($id) {
        $id = mysql_real_escape_string($id);
        $usersQuery = Database::query("select * from t_users where id = '$id'");
        return mysql_fetch_object($usersQuery);
    }
    
    static function getUserByUserName ($username) {
        $username = mysql_real_escape_string($username);
        return Database::query("select * from t_users where username = '$username'");
    }
    
    static function getUserByObjectId ($objectId) {
        $objectId = mysql_real_escape_string($objectId);
        return Database::queryAsObject("select * from t_users where objectid = '$objectId'");
    }
    
    static function getUsersByCustomRole ($customRole) {
        $customRoles = array();
        if (is_array($customRole)) {
            foreach ($customRole as $role) {
                $customRoles[] = mysql_real_escape_string($role);
            }
        } else {
            $customRoles[] = mysql_real_escape_string($customRole);
        }
        $sqlCustomRoles = "in ('".implode("','",$customRoles)."')";
        return Database::queryAsArray("select * from t_users u join t_roles r on r.userid = u.id join t_roles_custom c on c.id = r.roleid where c.id $sqlCustomRoles");
    }
    
    static function getUsersByCustomRoleId ($customRole) {
        $customRole = mysql_real_escape_string($customRole);
        return Database::queryAsArray("select u.* from t_users u join t_roles r on r.userid = u.id join t_roles_custom c on c.id = r.roleid where c.id = '$customRole'");
    }
    
    static function getUsersEmailsByCustomRoleId ($customRole) {
        $customRole = mysql_real_escape_string($customRole);
        $result = Database::queryAsArray("select email as email from t_users u join t_roles r on r.userid = u.id join t_roles_custom c on c.id = r.roleid where c.id = '$customRole'");
        return Common::toMap($result, "email", "email");
    }
    
    static function getUserEmailById ($userId) {
        $userId = mysql_real_escape_string($userId);
        $userEmail = Database::queryAsObject("select email as email from t_users where id = '$userId'");
        return $userEmail->email;
    }
    
    static function setUserActiveFlag ($id,$flag) {
        $id = mysql_real_escape_string($id);
        $flag = mysql_real_escape_string($flag);
        Database::query("update t_users set active = '$flag' where id = '$id'");
    }

    static function getUserByEmail ($email) {
        $email = mysql_real_escape_string($email);
        return Database::queryAsObject("select * from t_users where email = '$email'");
    }
    
    static function setUserImage ($userId, $imageId) {
        $userId = mysql_real_escape_string($userId);
        $imageId = mysql_real_escape_string($imageId);
        Database::query("update t_users set image = '$imageId' where id = '$userId'");
    }
    
    static function saveUser ($id, $username, $firstName, $lastName, $password, $email, $birthDate, $registerDate, $profileImage = null) {
        $username = mysql_real_escape_string($username);
        $firstName = mysql_real_escape_string($firstName);
        $lastName = mysql_real_escape_string($lastName);
        $email = mysql_real_escape_string($email);
        $birthDate = mysql_real_escape_string($birthDate);
        if ($profileImage == null) {
            $profileImage = "null";
        } else {
            $profileImage = "'".mysql_real_escape_string($profileImage)."'";
        }
        if ($id == null) {
            // create user objectid
            $objectId = DynamicDataView::createObject("userAttribs",false);
            // create user
            Database::query("insert into t_users (username,firstname,lastname,email,birthdate,registerdate,objectid,image)
                values ('$username','$firstName','$lastName','$email','$birthDate',now(),'$objectId',$profileImage)");
            $result = Database::queryAsObject("select last_insert_id() as id from t_users");
            $id = $result->id;
            // set user password
            UsersModel::setPassword($id, $password);
            // update user attribs
            VirtualDataModel::loadRefTable("userAttribs",$objectId);
        } else {
            $id = mysql_real_escape_string($id);
            $registerDateSql = "";
            if ($registerDate != null)
                $registerDateSql = ", registerdate = '".mysql_real_escape_string($registerDate)."'";
            Database::query("update t_users set username = '$username', email = '$email', birthdate = STR_TO_DATE('$birthDate','%d.%m.%Y')' $registerDateSql where id = '$id'");
        }
        EventsModel::addUserEvents($firstName,$lastName,$id,$birthDate);
        return $id;
    }
    
    static function setUserObjectId ($id, $objectId) {
        $id = mysql_real_escape_string($id);
        $objectId = mysql_real_escape_string($objectId);
        Database::query("update t_users set objectid = '$objectId' where id = '$id'");
    }

    static function setPassword ($userId,$password,$oldPassword = null) {
        $userId = mysql_real_escape_string($userId);
        $password = md5($password);
        if ($oldPassword != null) {
            $oldPassword = md5($oldPassword);
        }
        Database::query("update t_users set password = '$password' where id = '$userId'".($oldPassword != null ? " password='$oldPassword'" : ""));
    }

    static function deleteUser ($userId) {
        RolesModel::deleteRoles($userId);
        $userId = mysql_real_escape_string($userId);
        Database::query("delete from t_users where id = '$userId'");
    }
    
    static function getMaxUserId () {
        $ret = Database::queryAsObject("select max(id) as max from t_users");
        return $ret->max;
    }

}

?>