<?php

require_once 'core/model/rolesModel.php';

class Context {

    static $queryLog;

    // user attribs

    static function setUser ($userId,$username) {
        $_SESSION["userName"] = $username;
        $_SESSION["userId"] = $userId;
        $_SESSION["userLoggedin"] = true;
        Session::setUserFromContext();
    }

    static function getUsername () {
        if (isset($_SESSION["userName"]) && !Common::isEmpty($_SESSION["userName"]))
            return $_SESSION["userName"];
        return null;
    }

    static function getUserId () {
        if (isset($_SESSION["userId"]) && !Common::isEmpty($_SESSION["userId"]))
            return $_SESSION["userId"];
        return null;
    }

    static function getUserObjectId () {
        if (isset($_SESSION["userObjectId"]) && !Common::isEmpty($_SESSION["userObjectId"]))
            return $_SESSION["userObjectId"];
        return null;
    }
    
    static function getUserHome () {
        if (isset($_SESSION["userId"]) && !Common::isEmpty($_SESSION["userId"]))
            return "home/".Common::hash($_SESSION["userId"]);
        return null;
    }

    static function isLoggedIn () {
        return (isset($_SESSION["userLoggedin"]) && $_SESSION["userLoggedin"] == true) ? true : false;
    }

    // user roles

    static function getRoles () {
        return (isset($_SESSION["userRoles"]) && is_array($_SESSION["userRoles"])) ? $_SESSION["userRoles"] : array();
    }
    
    static function getRoleGroups () {
        return (isset($_SESSION["userRoleGroups"]) && is_array($_SESSION["userRoleGroups"])) ? $_SESSION["userRoleGroups"] : array();
    }
    
    static function getRoleIds () {
        return array_values(Context::getRoles());
    }

    static function hasRole ($roleName) {
        $result = true;
        $roles = Context::getRoles();
        if (is_array($roleName)) {
            foreach ($roleName as $role) {
                if ($result == true) {
                    $result = isset($roles[$role]);
                }
            }
        } else {
            $result = isset($roles[$roleName]);
        }
        if ($result == null)
            return false;
        return $result;
    }

    static function addRole ($roleId, $roleName) {
        $_SESSION["userRoles"][$roleName] = $roleId;
    }
    
    static function hasRoleGroup ($roleName) {
        $result = true;
        $roles = Context::getRoleGroups();
        if (is_array($roleName)) {
            foreach ($roleName as $role) {
                if ($result == true) {
                    $result = isset($roles[$role]);
                }
            }
        } else {
            $result = isset($roles[$roleName]);
        }
        if ($result == null)
            return false;
        return $result;
    }

    static function addRoleGroup ($roleId, $roleName) {
        $_SESSION["userRoleGroups"][$roleName] = $roleId;
    }
    
    static function reloadRoles () {
	Context::clearRoles();
    	$userRoles = RolesModel::getRoles(Context::getUserId());
        foreach ($userRoles as $userRole) {
                Context::addRoleGroup($userRole->customrole, $userRole->rolegroup);
                Context::addRole($userRole->customrole,$userRole->modulerole);
        }
    }
	
    static function addDefaultRoles () {
        // set user default roles if none exist
        if (Common::isEmpty(Context::getRoles())) {
            $defaultRoles = RolesModel::getPageRoleByName("guest");
            Context::addRoleGroup($defaultRoles->id, $defaultRoles->name);
            $moduleRoles = RolesModel::getCustomRoleModuleRoles($defaultRoles->id);
            foreach ($moduleRoles as $moduleRole) {
                Context::addRole($moduleRole->id,$moduleRole->modulerole);
            }
        }
    }

    static function clearRoles () {
        $_SESSION["userRoles"] = array();
        $_SESSION["userRoleGroups"] = array();
    }
    
    static function clear () {
        $_SESSION["userId"] = null;
        $_SESSION["userName"] = null;
        $_SESSION["userRoles"] = array();
        $_SESSION["userObjectId"] = null;
        $_SESSION["userRoleGroups"] = array();
        $_SESSION["userLoggedin"] = false;
    }

    // current request

    static function isAjaxRequest () {
        return (isset($_GET["moduleAjaxRequest"]) && $_GET["moduleAjaxRequest"] == "true");
    }
    
    static function isRenderRequest () {
        return (isset($_GET["reRender"]) && !Common::isEmpty($_GET["reRender"]));
    }

    static function getPage () {
        return isset($_SESSION["req.page"]) ? $_SESSION["req.page"] : null;
    }

    static function getPageId () {
        return isset($_SESSION["req.pageId"]) ? $_SESSION["req.pageId"] : null;
    }

    static function getModuleId () {
        return isset($_SESSION["req.moduleId"]) ? $_SESSION["req.moduleId"] : null;
    }

    static function setModuleId ($moduleId) {
        $_SESSION["req.moduleId"] = $moduleId;
    }
    
    static function setService ($moduleName = null) {
        $_SESSION["req.service"] = $moduleName;
    }
    
    static function getService () {
        return isset($_SESSION["req.service"]) ? $_SESSION["req.service"] : null;
    }

    static function getPageName () {
        return isset($_SESSION["req.pageName"]) ? $_SESSION["req.pageName"] : null;
    }

    static function getPageHash () {
        return isset($_SESSION["req.pageHash"]) ? $_SESSION["req.pageHash"] : null;
    }

    static function getLang () {
        return isset($_SESSION["req.lang"]) ? $_SESSION["req.lang"] : null;
    }
    
    static function getSiteId () {
        if (!isset($_SESSION["req.site"])) {
            $_SESSION["req.site"] = DomainsModel::getCurrentSite();
        }
        return $_SESSION["req.site"]->siteid;
    }

    // renderer

    static function loadRenderer () {
        Context::setRenderer(TemplateModel::getTemplateObj(self::getPage()));
    }

    static function setRenderer ($templateObj) {
        $_REQUEST["req.renderer"] = $templateObj;
    }

    static function getRenderer () {
        return isset($_REQUEST["req.renderer"]) ? $_REQUEST["req.renderer"] : null;
    }

    // modules in this page

    static function loadModules () {

        // get static modules
        $staticModules = self::getRenderer()->getStaticModules();
        $templateAreas = self::getRenderer()->getAreas();

        // load the modules
        $pageModules = TemplateModel::getAreaModules(self::getPageId(), $templateAreas, $staticModules);
        $pageAreaNames = array();
        foreach ($pageModules as $module) {
            self::addModule($module);
            $pageAreaNames[$module->id] = $module->name;
        }
        
        // load the module parameters
        $instanceParams = array();
        $allParams = ModuleModel::getAreaModuleParams(array_keys($pageAreaNames));
        foreach ($allParams as $param) {
            if (!isset($instanceParams[$param->instanceid])) {
                $instanceParams[$param->instanceid] = array();
            }
            $instanceParams[$param->instanceid][$param->name] = unserialize($param->value);
        }

        self::setModuleParams($instanceParams);
    }

    static function getPageModules () {
        if (!isset($_REQUEST['req.modules'])) {
            self::loadModules();
        }
        return $_REQUEST['req.modules'];
    }
    
    static function setModuleParams ($instanceParams) {
        foreach ($instanceParams as $instanceId => $params) {
            $module = &self::getModule($instanceId);
            $module->setParams($params);
        }
    }
    
    static function addModule ($module) {
        if (!isset($_REQUEST['req.modules'])) {
            $_REQUEST['req.modules'] = array();
        }
        if (!isset($modules[$module->name])) {
            $_REQUEST['req.modules'][$module->name] = array();
        }
        $_REQUEST['req.modules'][$module->name][$module->id] = &ModuleModel::getModuleClass($module);
    }

    static function getModules ($areaName = null) {
        $modules = self::getPageModules();
        if ($areaName == null) {
            return $modules;
        }
        if (isset($modules[$areaName])) {
            return $modules[$areaName];
        }
        return null;
    }
    
    static function getModule ($id) {
        $modules = &self::getPageModules();
        foreach ($modules as $areaName => $modules) {
            if (isset($modules[$id])) {
                return $modules[$id];
            }
        }
        return null;
    }

    static function getAreaNames () {
        return array_keys(self::getPageModules());
    }
    static function addQueryToLog ($query) {
		self::$queryLog[] = $query;
	}

    // methods called at the start and end of the context

    static function startRequest () {

        if (Config::getQueryLog()) {
            self::$queryLog = array();
        }

        if (!@include_once('config.php')) {
            Session::startDefaultSession();
        } else {

            Session::useSession();
            NavigationModel::startRequest();

            // set the language
            $lang = "de";
            if (isset($_GET['changelang'])) {
                $lang = $_GET['changelang'];
            } else if (isset($_SESSION["req.lang"])) {
                $lang = $_SESSION["req.lang"];
            } else {
                if (isset($_REQUEST['local'])) {
                    switch ($_REQUEST['local']) {
                        case "en_us":
                            $lang = $_SESSION["req.lang"] = "en";
                        case "es_sp":
                            $lang = $_SESSION["req.lang"] = "sp";
                    }
                }
            }
            unset($_SESSION["req.returnValue"]);
            $_SESSION["req.lang"] = $lang;

            // set the siteid
            $_SESSION["req.site"] = DomainsModel::getCurrentSite();

            // set the selected page
            $page = NavigationModel::selectPage();
            if ($page != null) {
                $_SESSION["req.page"] = $page;
                $_SESSION["req.pageId"] = $page->id;
                $_SESSION["req.pageName"] = $page->name;
                $_SESSION["req.pageCode"] = $page->code;
                self::loadRenderer();
                self::loadModules();
            }
        }
    }
    
    static function endRequest () {

        // write the query log
        if (Config::getQueryLog()) {
            $queryHtml = "<html><head></head><body>";
            foreach (self::$queryLog as $key => $query) {
                $queryHtml .= "<div class='query' style='background-color:rgb(".($key % 2 == 0 ? "230,230,230" : "245,245,245").")'>";
                $queryHtml .= $key." : ".$query;
                $queryHtml .= "</div></br>";
            }
            $filename = "logs/".session_id()."_query.html";
            $queryHtml .= "</body></html>";
            if (file_exists($filename)) {
                unlink($filename);
            }
            file_put_contents($filename, $queryHtml);
        }

        // unset session request data
        $_SESSION["req.page"] = null;
        $_SESSION["req.pageId"] = null;
        $_SESSION["req.pageName"] = null;
        $_SESSION["req.pageCode"] = null;
        $_SESSION["req.service"] = null;
    }
    
    static function setIsFocusedArea ($bool) {
        $_SESSION["req.mainArea"] = $bool;
    }
    
    // is the module currently being rendered or processed 
    // the module that should receive the action parameter
    static function getIsFocusedArea () {
        if (!isset($_SESSION["req.mainArea"]))
            return false;
        return $_SESSION["req.mainArea"];
    }
    
    static function getFocusedArea () {
    	if (isset($_SESSION['focusedArea']))
        	return $_SESSION['focusedArea'];
    	return null;
    }

    function setFocusedArea ($incudeId) {
    	$_SESSION['focusedArea'] = $incudeId;
    }

    /**
     * if called the value will be returned as the response the 
     * render methods of the modules in the page will not be called
     */
    static function returnValue ($value) {
        $_SESSION["req.returnValue"] = $value;
    }
    
    /**
     * returns the return value and null if none was set
     */
    static function getReturnValue () {
        return isset($_SESSION["req.returnValue"]) ? $_SESSION["req.returnValue"] : null;
    }
    
    /**
     * accessors for request vars
     */
    static function get ($varName) {
        return isset($_GET[$varName]) ? $_GET[$varName] : null;
    }
    static function post ($varName) {
        return isset($_POST[$varName]) ? $_POST[$varName] : null;
    }

}

class Config {

    static function getCurrency () {
        return $GLOBALS['currencySymbol'];
    }

    static function getWeight () {
        return $GLOBALS['weightUnit'];
    }

    static function getQueryLog () {
        if (!isset($GLOBALS['queryLog'])) {
            return true;
        }
        return $GLOBALS['queryLog'];
    }

    static function getShippingMode () {
        return $GLOBALS['shippingMode'];
    }
}

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
        
        $getParamsArray = array();
        foreach ($_GET as $key => $value) {
            $getParamsArray[] = $key.":".$value;
        }
        $getParamsArray = "{".implode(",",$getParamsArray)."}";
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
        // setcookie("s",'',0,'/');
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