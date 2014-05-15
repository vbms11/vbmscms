<?php

require_once 'core/model/rolesModel.php';
require_once 'core/model/eventsModel.php';
require_once 'core/util/common.php';
require_once 'core/context.php';

class UsersModel {
    
    static function search ($ageMin, $ageMax, $countryGeonameId, $place, $distance) {
        
        $country = CountryModel::getCountryByGeonameId($countryGeonameId);
        $countryName = "";
        if (isset($country->name)) {
            $countryName = $country->name;
        }
        
        $coordinates = UserAddressModel::getCoordinatesFromAddress($countryName." ".$place);
        
        if (empty($coordinates)) {
            return array();
        }
        
        $radiusOfEarthKM = 6371;
        $x = (sin($coordinates->x) * cos($coordinates->y)) * $radiusOfEarthKM;
        $y = (cos($coordinates->x) * cos($coordinates->y)) * $radiusOfEarthKM;
        $z = sin($coordinates->y) * $radiusOfEarthKM;
        
        $x = mysql_real_escape_string($x);
        $y = mysql_real_escape_string($y);
        $z = mysql_real_escape_string($z);
        
        return Database::queryAsArray("select 
            u.*, 
            year(now()) - year(u.birthdate) as age, 
            sqrt(pow(a.vectorx - '$x', 2) + pow(a.vectory - '$y', 2) + pow(a.vectorz - '$z', 2)) as distance,  
            a.country as country, a.city as city 
            from t_user u 
            join t_user_address a on u.id = a.userid 
            where 
            sqrt(pow(a.vectorx - '$x', 2) + pow(a.vectory - '$y', 2) + pow(a.vectorz - '$z', 2)) <= '$distance' and 
            year(now()) - year(u.birthdate) >= '$ageMin' and 
            year(now()) - year(u.birthdate) <= '$ageMax' 
            order by distance asc");
    }
    
    static function login ($username, $password, $siteId = null) {
        $username = mysql_real_escape_string($username);
        $password = md5($password);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        $userObj = Database::queryAsObject("select u.* from t_site_users su 
            join t_user u on su.userid = u.id 
            where (u.username = '$username' or u.email = '$username') and u.password = '$password' and u.active = '1'");
        // validate login
        if ($userObj != null) {
            Context::setUser($userObj);
            Context::reloadRoles();
            return true;
        }
        return false;
    }
    
    static function loginWithEmail ($email, $siteId = null) {
        $email = mysql_real_escape_string($email);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        $userObj = Database::queryAsObject("select u.* from t_site_users su 
            join t_user u on su.userid = u.id 
            where u.email = '$email' and u.active = '1'");
        // validate login
        if ($userObj != null) {
            Context::setUser($userObj);
            Context::reloadRoles();
            return true;
        }
        return false;
    }
    
    static function loginWithFacebookId ($facebookId, $siteId = null) {
        $facebookId = mysql_real_escape_string($facebookId);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        $userObj = Database::queryAsObject("select u.* from t_site_users su 
            join t_user u on su.userid = u.id 
            where u.facebook_uid = '$facebookId' and u.active = '1'");
        // validate login
        if ($userObj != null) {
            Context::setUser($userObj);
            Context::reloadRoles();
            return true;
        }
        return false;
    }
    
    static function setFacebookId ($userId, $facebookId) {
        $userId = mysql_real_escape_string($userId);
        $facebookId = mysql_real_escape_string($facebookId);
        Database::query("update t_user set facebook_uid = '$facebookId' where id = '$userId'");
    }
    
    static function loginWithKey ($key) {
        $key = mysql_real_escape_string($key);
        $userObj = Database::queryAsObject("select * from t_user where authkey = '$key' and active = '1'") or die (mysql_error());
        
        // validate login
        if ($userObj != null) {
            
            Context::setUser($userObj);
            
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

    static function getUsers ($registered = null, $active = null, $siteId = null) {
        $condition = "";
        if ($active != null) {
            $condition .= "active = '".($active ? '1' : '0')."' ";
        }
        if ($condition != "") {
            $condition = "where ".$condition;
        }
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        return Database::queryAsArray("select u.* from t_site_users su join t_user u on su.userid = u.id $condition");
    }

    static function getUser ($id) {
        $id = mysql_real_escape_string($id);
        return Database::queryAsObject("select u.*, year(now()) - year(u.birthdate) as age from t_user u where u.id = '$id'");
    }
    
    static function getUserByUserName ($username, $siteId = null) {
        $username = mysql_real_escape_string($username);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        return Database::query("select u.* from t_site_users join t_user u on su.userid = u.id where username = '$username'");
    }
    
    static function getUserByObjectId ($objectId) {
        $objectId = mysql_real_escape_string($objectId);
        return Database::queryAsObject("select * from t_user where objectid = '$objectId'");
    }
    
    static function getUsersByCustomRole ($customRole, $siteId = null) {
        $customRoles = array();
        if (is_array($customRole)) {
            foreach ($customRole as $role) {
                $customRoles[] = mysql_real_escape_string($role);
            }
        } else {
            $customRoles[] = mysql_real_escape_string($customRole);
        }
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        $sqlCustomRoles = "in ('".implode("','",$customRoles)."')";
        return Database::queryAsArray("select u.* from t_site_users su join t_user u on su.userid = u.id join t_roles r on r.userid = u.id join t_roles_custom c on c.id = r.roleid where c.id $sqlCustomRoles");
    }
    
    static function getUsersByCustomRoleId ($customRole, $siteId = null) {
        $customRole = mysql_real_escape_string($customRole);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        return Database::queryAsArray("select u.* from t_site_users su join t_user u on su.userid = u.id join t_roles r on r.userid = u.id join t_roles_custom c on c.id = r.roleid where c.id = '$customRole'");
    }
    
    static function getUsersEmailsByCustomRoleId ($customRole, $siteId = null) {
        $customRole = mysql_real_escape_string($customRole);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        $result = Database::queryAsArray("select email as email from t_site_users su join t_user u on su.userid = u.id join t_roles r on r.userid = u.id join t_roles_custom c on c.id = r.roleid where c.id = '$customRole'");
        return Common::toMap($result, "email", "email");
    }
    
    static function getUserEmailById ($userId) {
        $userId = mysql_real_escape_string($userId);
        $userEmail = Database::queryAsObject("select email as email from t_user where id = '$userId'");
        return $userEmail->email;
    }
    
    static function setUserActiveFlag ($id,$flag) {
        $id = mysql_real_escape_string($id);
        $flag = mysql_real_escape_string($flag);
        Database::query("update t_user set active = '$flag' where id = '$id'");
    }

    static function getUserByEmail ($email, $siteId = null) {
        $email = mysql_real_escape_string($email);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        return Database::queryAsObject("select u.* from t_site_users su join t_user u on su.userid = u.id where email = '$email'");
    }
    
    static function setUserImage ($userId, $imageId) {
        $userId = mysql_real_escape_string($userId);
        $imageId = mysql_real_escape_string($imageId);
        Database::query("update t_user set image = '$imageId' where id = '$userId'");
    }
    
    static function getUserImageUrl ($userId) {
        $user = self::getUser($userId);
        $imageUrl = null;
        if (!empty($user->image)) {
            $image = GalleryModel::getImage($user->image);
            $imageUrl = ResourcesModel::createResourceLink("gallery/small",$image->image);
        } else if (!empty($user->facebook_uid)) {
            $imageUrl = "https://graph.facebook.com/".$user->facebook_uid."/picture?type=large";
        } else if (!empty($user->twitter_uid)) {
            
        } else {
            $imageUrl = "modules/users/img/User.png";
        }
        return $imageUrl;
    }
    
    static function getUserImageSmallUrl ($userId) {
        $user = self::getUser($userId);
        $imageUrl = "";
        if (!empty($user->image)) {
            $image = GalleryModel::getImage($user->image);
            $imageUrl = ResourcesModel::createResourceLink("gallery/small",$image->image);
        } else if (!empty($user->facebook_uid)) {
            $imageUrl = "https://graph.facebook.com/".$user->facebook_uid."/picture";
        } else if (!empty($user->twitter_uid)) {
            
        } else {
            $imageUrl = "modules/users/img/User.png";
        }
        return $imageUrl;
    }
    
    static function validate ($id, $username, $firstName, $lastName, $password, $email, $birthDate, $gender, $registerDate = null) {
        $validate = array();
        if (strlen($username) < 4) {
            $validate["username"] = "user name must be at least 4 characters!";
        } else if ($username > 100) {
            $validate["username"] = "user name must be shorter that 100 characters!";
        }
        if (strlen($firstName) < 1) {
            $validate["firstname"] = "First name cannot be empty!";
        }
        if (strlen($lastName) < 1) {
            $validate["lastname"] = "Last name cannot be empty!";
        }
        if ($password != null && strlen($password) < 6) {
            $validate["password"] = "Password must be at least 6 characters!";
        }
        if (preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,7}$/D", $email) == 0) {
            $validate["email"] = "Not a valid email address!";
        }
        if ($gender != "0" && $gender != "1") {
            $validate["gender"] = "invalid value!";
        }
        if ($id == null) {
            $_email = mysql_real_escape_string($email);
            $result = Database::queryAsObject("select 1 as emailexists from t_user where email = '$_email'");
            if ($result != null) {
                $validate["email"] = "Email already registered by another user!";
            }
            $_username = mysql_real_escape_string($username);
            $result = Database::queryAsObject("select 1 as usernameexists from t_user where username = '$_username'");
            if ($result != null) {
                $validate["username"] = "Username already registered by another user!";
            }
        } else {
            $_id = mysql_real_escape_string($id);
            $_email = mysql_real_escape_string($email);
            $result = Database::queryAsObject("select 1 as emailexists from t_user where email = '$_email' and id != '$id'");
            if ($result != null) {
                $validate["email"] = "Email already registered by another user!";
            }
            $_username = mysql_real_escape_string($username);
            $result = Database::queryAsObject("select 1 as usernameexists from t_user where username = '$_username' and id != '$id'");
            if ($result != null) {
                $validate["username"] = "Username already registered by another user!";
            }
        }
        return $validate;
    }
    
    static function saveUser ($id, $username, $firstName, $lastName, $password, $email, $birthDate, $registerDate = null, $gender = "1", $profileImage = null, $siteId = null) {
        $username = mysql_real_escape_string($username);
        $firstName = mysql_real_escape_string($firstName);
        $lastName = mysql_real_escape_string($lastName);
        $email = mysql_real_escape_string($email);
        $birthDate = mysql_real_escape_string($birthDate);
        $gender = mysql_real_escape_string($gender);
        if ($profileImage == null) {
            $profileImage = "null";
        } else {
            $profileImage = "'".mysql_real_escape_string($profileImage)."'";
        }
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        } else {
            $siteId = mysql_real_escape_string($siteId);
        }
        if ($id == null) {
            // create user objectid
            $objectId = DynamicDataView::createObject("userAttribs",false);
            // create user
            Database::query("insert into t_user (username,firstname,lastname,email,birthdate,registerdate,objectid,image,gender)
                values ('$username','$firstName','$lastName','$email',STR_TO_DATE('$birthDate','%d/%m/%Y'),now(),'$objectId',$profileImage,'$gender')");
            $result = Database::queryAsObject("select last_insert_id() as id from t_user");
            $id = $result->id;
            // create site user
            Database::query("insert into t_site_users (userid,siteid) values('$id','$siteId')");
            // set user password
            if ($password != null) {
                UsersModel::setPassword($id, $password);
            }
        } else {
            $id = mysql_real_escape_string($id);
            $registerDateSql = "";
            if ($registerDate != null)
                $registerDateSql = ", registerdate = STR_TO_DATE('".mysql_real_escape_string($registerDate)."','%d/%m/%Y')";
            Database::query("update t_user set username = '$username', email = '$email', birthdate = STR_TO_DATE('$birthDate','%d/%m/%Y')', gender = '$gender' $registerDateSql where id = '$id'");
        }
        EventsModel::addUserEvents($firstName,$lastName,$id,$birthDate);
        return $id;
    }
    
    static function setUserObjectId ($id, $objectId) {
        $id = mysql_real_escape_string($id);
        $objectId = mysql_real_escape_string($objectId);
        Database::query("update t_user set objectid = '$objectId' where id = '$id'");
    }

    static function setPassword ($userId,$password,$oldPassword = null) {
        $userId = mysql_real_escape_string($userId);
        $password = md5($password);
        if ($oldPassword != null) {
            $oldPassword = md5($oldPassword);
        }
        Database::query("update t_user set password = '$password' where id = '$userId'".($oldPassword != null ? " password='$oldPassword'" : ""));
    }

    static function deleteUser ($userId) {
        RolesModel::deleteRoles($userId);
        $userId = mysql_real_escape_string($userId);
        Database::query("delete from t_site_users where userid = '$userId'");
        Database::query("delete from t_user where id = '$userId'");
    }

}

?>