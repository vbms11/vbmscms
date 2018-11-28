<?php

class Session extends DbObject {
    
    private $key_sessionId = "k";
    private $key_sessionKey = "s";
    private $key_seoKeyName = "ssoKey";
    private $key_private = "session.privateKey";
    private static $sessionIdLength = 60;
    private static $sessionKeyLength = 40;
    private static $sessionPrivateCodeLength = 40;
    
    private $sessionId = null;
    private $sessionKey = null;
    private $sessionPrivateCode = null;
    private $userId = null;
    private $privateKey = null;
    private $publicKey = null;
    
    // abstract function getTableName (); 
    function getTableName () {
        return "session";
    }
            
    // abstract function getColumns ();
    function getColumns () {
        array(
            
        );
    }
    
    function getSessionKeysString () {
        return $this->key_sessionKey."-".$this->sessionId;
    }
    
    function getSessionKeysArray () {
        
        if ($this->isStarted()) {
            return array(
                $this->key_sessionKey => $this->key_sessionKey,
                $this->key_sessionKey => $this->sessionId
            );
        } else {
            return array();
        }
    }
    
    function useSession () {
        
        $noError = true;
        $keysValid = true;
        $sessionValid = false;
        
        // get php session key param
        $this->sessionId = null;
        if (isset($_COOKIE[$this->key_sessionKey])) {
            $this->sessionId = $_COOKIE[$this->key_sessionKey];
        } else if (isset($_GET[$this->key_sessionKey])) {
            $this->sessionId = $_GET[$this->key_sessionKey];
        } else if (isset($_POST[$this->key_sessionKey])) {
            $this->sessionId = $_POST[$this->key_sessionKey];
        }
        
        // get session key param
        $this->sessionKey = null;
        if (isset($_COOKIE[$this->key_sessionId])) {
            $this->sessionKey = $_COOKIE[$this->key_sessionId];
        } else if (isset($_GET[$this->key_sessionId])) {
            $this->sessionKey = $_GET[$this->key_sessionId];
        } else if (isset($_POST[$this->key_sessionId])) {
            $this->sessionKey = $_POST[$this->key_sessionId];
        }
        
        // validate keys
        if (empty($this->sessionId)  || strlen($this->sessionId)  != $this->sessionIdLength || 
            empty($this->sessionKey) || strlen($this->sessionKey) != $this->sessionKeyLength) {
            
            // session keys are invalid
            $keysValid = false;
            $sessionValid = false;
            
        } else {

            // try starting session
            $sessionValid = $this->startSession($this->key_sessionKey, $this->sessionId);
            
            if ($sessionValid == true) {
                
                // remove old sessions
                $this->cleanOldSessions();
                
                // check if session valid
                $sessionValid = $this->isValid();
            }
            
            // if session invalid destroy session
            if ($sessionValid == false) {
                
                $this->endSession($this->sessionId);
            }
        }
        
        // if session is invalid create session
        if ($keysValid == false || $sessionValid == false) {
            
            // create session keys
            $this->sessionId = $this->generateSessionId();
            $this->sessionKey = $this->generateSessionKey();
            
            // start session
            $this->startSession($this->key_sessionId, $this->sessionId);
	        
            // set session key
            setcookie($this->key_sessionId, $this->sessionId, 0, "/");
	        
            // start database session
            DB::connect();
	        
            // remove old sessions
            $this->cleanOldSessions();
            
            // start a clean session in the model
            Device::$state->clear();
            $this->startSession($this->sessionId, $this->sessionKey, $this->sessionId);
            Device::$state->addDefaultRoles();
        }
        
        // if user single sign on code exists log user in
        if (isset($_GET[$this->seoKeyName])) {
            
            UserController::loginWithKey($_GET[$this->seoKeyName]);
        }
    }
    
    function setUserFromContext () {
        SessionController::setSessionUser($this->sessionId, Device::user);
    }
    
    function clear () {
        Device::$state->reset();
        Device::$controller->session->end();
        Device::$controller->session->clean();
    }
    
    function generateSessionId () {
        return sha1(Common::randHash($this->sessionIdLength,false));
    }
    
    function generateSessionKey () {
        return Common::randHash($this->sessionIdLength);
    }
    
    function generateSessionPrivateCode () {
        return Common::randHash($this->sessionPrivateCodeLength);
    }
    
    function isStarted () {
        if ($this->sessionKey != null && $this->sessionId != null) {
            return true;
        }
        return false;
    }
    
    function startSession ($sessionName, $sessionId) {
        // try starting the session
        session_name($sessionName);
        session_id($sessionId);
        return session_start();
    }

    function startDefaultSession () {
        // try starting the session
        return session_start();
    }

    function endSession ($sessionId) {
        // end php session
        session_unset();
        session_destroy();
        session_write_close();
        session_regenerate_id(true);
    }
    
    function isValid () {
        return Device::$controller->session->isValid($this->sessionId, $this->sessionKey);
    }
}

?>