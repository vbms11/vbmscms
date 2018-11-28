<?php

class UserController extends Controller {
    
    function getConfig () {
        return array(
            "name" => "user",
            "feilds" => array(
                array(
                    "name" => "firstname", 
                    "label" => "", 
                    "type" => "", 
                    "length" => "200", 
                    "" => "", 
                    "" => "", 
                ),array(
                    
                ),array(
                    
                )
            )
        );
    }
    
    function validate ($id, $username, $firstname, $lastname, $password, $email, $gender) {
        
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
            $_email = Database::escape($email);
            $result = Database::queryAsObject("select 1 as emailexists from t_user where email = '$_email'");
            if ($result != null) {
                $validate["email"] = "Email already registered by another user!";
            }
            $_username = Database::escape($username);
            $result = Database::queryAsObject("select 1 as usernameexists from t_user where username = '$_username'");
            if ($result != null) {
                $validate["username"] = "Username already registered by another user!";
            }
        } else {
            $_id = Database::escape($id);
            $_email = Database::escape($email);
            $result = Database::queryAsObject("select 1 as emailexists from t_user where email = '$_email' and id != '$id'");
            if ($result != null) {
                $validate["email"] = "Email already registered by another user!";
            }
            $_username = Database::escape($username);
            $result = Database::queryAsObject("select 1 as usernameexists from t_user where username = '$_username' and id != '$id'");
            if ($result != null) {
                $validate["username"] = "Username already registered by another user!";
            }
        }
        return $validate;
    }
    
    function register () {
        
        $user;
        $user->username = Request::post("username");
        $user->firstName = Request::post("firstName");
        $user->lastName = Request::post("lastName");
        $user->birthDate = Request::post("birthDate");
        $user->telephone = Request::post("telephone");
        $user->homepage = Request::post("homepage");
        $user->password = Request::post("password");
        $user->agbs = Request::post("agbs");
        $user->email = Request::post("email");
        $user->gender = Request::post("gender");
        
        $validation = self::validate(null, $user->username, $user->firstname, $user->lastname, $user->password, $user->email, $user->gender);
        
        if ($user->agbs) {
            $validation["agbs"] = "You can only use the application if you accept the agbs AGBs";
        }
        
        if (count($validation) > 0) {
            return $validation;
        }
        
        $user->password = md5($user->password);
        
        return $user;
    }
    
    function delete ($publicId) {
        
        return DB::delete(self::getTableName(), "publicid = $publicId");
    }
    
    function login () {
        
        $username = Request::post("username");
        $password = Request::post("password");
        //$loginAttempts = Request::session("login.attempts");
        $password = md5($password);
        //if ($loginAttempts > Config::getMaxLoginAttempts()) {
        //    return array("Max login attempts!");
        //}
        //$loginAttempts++;
        $user = DB::get(self::getTableName(), array("username"=>$username,"password"=>$password), false);
        if ($user == null) {
            Request::session("loginAttempts", $loginAttempts);
            return array("Username or password invalid!");
        }
        return $user;
    }
    
    function ssoLogin ($ssoKey) {
        
        $user = DB::get(self::getTableName(), array("ssokey"=>$ssoKey), false);
        
        return $user;
    }
    
    function logout () {
        
    }
}

?>