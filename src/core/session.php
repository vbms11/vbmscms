<?php

class Session {

    static function getSessionKeysString () {
        return isset($_SESSION["session.started"]) ? $_SESSION["session.started"]."-".session_id() : "";
    }

    static function getSessionKeysArray () {
        return isset($_SESSION["session.started"]) ? array("k"=>$_SESSION["session.started"],session_name()=>session_id()) : array();
    }
    
    static function useSession () {
        
        $noError = true;
        $keysValid = true;
        $sessionValid = false;
        
        // get php session key param
        $sessionId = null;
        if (isset($_COOKIE["s"])) {
            $sessionId = $_COOKIE["s"];
        } else if (isset($_GET["s"])) {
            $sessionId = $_GET["s"];
        } else if (isset($_POST["s"])) {
            $sessionId = $_POST["s"];
        }
        
        // get session key param
        $sessionKey = null;
        if (isset($_COOKIE["k"])) {
            $sessionKey = $_COOKIE["k"];
        } else if (isset($_GET["k"])) {
            $sessionKey = $_GET["k"];
        } else if (isset($_POST["k"])) {
            $sessionKey = $_POST["k"];
        }
        
        // validate keys
        if (Common::isEmpty($sessionId)  || strlen($sessionId)  != 40 || 
            Common::isEmpty($sessionKey) || strlen($sessionKey) != 40) {
            
            // session keys are invalid
            $keysValid = false;
            $sessionValid = false;
            
        } else {

            // try starting session
            $sessionValid = Session::startSession("s",$sessionId);
            
            if ($sessionValid == true) {
                
                // start database session
                Database::getDataSource();
            
                // check if session valid
                $sessionValid = Session::isValid($sessionId,$sessionKey);
            }
            
            // if session invalid destroy session
            if ($sessionValid == false) {
                
                Session::endSession($sessionId);
            }
        }
        
        // if session is invalid create session
        if ($keysValid == false || $sessionValid == false) {
            
            // create session keys
            $sessionId = Session::generateSessionId();
            $sessionKey = Session::generateSessionKey();
            
            // start session
            Session::startSession("s", $sessionId);
            $_SESSION["session.started"] = $sessionKey;
	    
            // set cookies
            setcookie("k",$sessionKey);
            setcookie("s",$sessionId);
	    
            // start database session
            Database::getDataSource();
	    
            // start a clean session in the model
            Context::clear();
            SessionModel::startSession($sessionId, $sessionKey, $_SERVER['REMOTE_ADDR']);
            Context::addDefaultRoles();
        }
    }
    
    static function setUserFromContext () {
        SessionModel::setSessionUser($_SESSION["session.started"], Context::getUserId());
    }
    
    static function clear () {
        Context::clear();
        Context::addDefaultRoles();
        SessionModel::endSession($_SESSION["session.started"]);
        SessionModel::cleanOldSessions();
    }
    
    static function generateSessionId () {
        return sha1(Common::randHash(64,false));
    }
    
    static function generateSessionKey () {
        return Common::randHash(40);
    }
    
    static function startSession ($sessionName,$sessionId) {
        // try starting the session
        session_name($sessionName);
        session_id($sessionId);
        return session_start();
    }

    static function startDefaultSession () {
        // try starting the session
        return session_start();
    }

    static function endSession ($sessionId) {
        
        // end database session
	SessionModel::endSession($sessionId);
        // end php session
        session_unset();
        session_destroy();
        session_write_close();
        session_regenerate_id(true);
    }
    
    static function isValid ($sessionId, $sessionKey) {
        $valid = false;
        // check if session is valid
        if (!isset($_SESSION["session.started"]) || $_SESSION["session.started"] != $sessionKey) {
            // session key new or invalid
            $valid = false;
        } else {
	    // is session valid
            if (SessionModel::pollSession($sessionId,$sessionKey) == true) {
            	// valid
            	$valid = true;
            } else {
            	$valid = false;
            }
        }
        return $valid;
    }
}

?>