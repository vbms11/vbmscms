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
    
    static function getUserHome ($userId = null) {
        if ($userId != null)
            return "home/".Common::hash($userId);
        if (isset($_SESSION["userId"]) && !Common::isEmpty($_SESSION["userId"]))
            return "home/".Common::hash($_SESSION["userId"]);
        return null;
    }
    
    static function setSelectedUser ($userId) {
        $_SESSION["context.selectedUser"] = $userId;
    }
    
    static function getSelectedUserId () {
        return isset($_SESSION["context.selectedUser"]) ? $_SESSION["context.selectedUser"] : null;
    }
    
    static function getSelectedUserHome () {
        if (isset($_SESSION["context.selectedUser"]) && !Common::isEmpty($_SESSION["context.selectedUser"]))
            return "home/".Common::hash($_SESSION["context.selectedUser"]);
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
        $mode = self::get("renderRequest");
        if ($mode == null && self::get("ajax") == "1") {
            $mode = "ajax";
        }
        switch ($mode) {
            case "vcms":
                $renderer = new VCmsRenderer(TemplateModel::getTemplateObj(self::getPage()));
                break;
            case "ajax":
                $renderer = new AJaxRenderer(TemplateModel::getTemplateObj(self::getPage()));
                break;
            default:
                $renderer = TemplateModel::getTemplateObj(self::getPage());
                break;
        }
        Context::setRenderer($renderer);
    }
    
    /**
     * 
     * @param type $templateObj
     */
    static function setRenderer ($templateObj) {
        $_REQUEST["req.renderer"] = $templateObj;
    }
    
    /**
     * 
     * @return TemplateRenderer
     */
    static function getRenderer () {
        return isset($_REQUEST["req.renderer"]) ? $_REQUEST["req.renderer"] : null;
    }

    // modules in this page

    static function loadModules () {

        // get static modules
        $staticModules = self::getRenderer()->getStaticModules();
        $templateAreas = self::getRenderer()->getAreas();
        
        $_REQUEST['req.modules'] = array();
        
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
        if (!isset($_REQUEST['req.modules'][$module->name])) {
            $_REQUEST['req.modules'][$module->name] = array();
        }
        $_REQUEST['req.modules'][$module->name][$module->id] = &ModuleModel::getModuleClass($module);
    }
    
    static function removeModule ($moduleId) {
        foreach (self::getPageModules() as $modules) {
            if (isset($modules[$moduleId])) {
                unset($modules[$moduleId]);
            }
        }
    }

    static function getModules ($areaName = null) {
        $modules = self::getPageModules();
        if ($areaName == null) {
            return $modules;
        }
        if (isset($modules[$areaName])) {
            return $modules[$areaName];
        }
        return array();
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
        
        if (Config::getNoDatabase()) {
            Session::startDefaultSession();
        } else {

            Session::useSession();
            NavigationModel::startRequest();
            LanguagesModel::selectLanguage();
            
            unset($_SESSION["req.returnValue"]);
            // set the siteid
            $_SESSION["req.site"] = DomainsModel::getCurrentSite();

            // set the selected page
            $page = NavigationModel::selectPage();
            if ($page != null) {
                $_SESSION["req.page"] = $page;
                $_SESSION["req.pageId"] = $page->id;
                $_SESSION["req.pageName"] = $page->name;
                // $_SESSION["req.pageCode"] = $page->code;
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
        
        // save module parameters
        /*
        $moduleParams = array();
        $modules = self::getModules();
        foreach ($modules as $module) {
            if ($module->paramsDirty) {
                $moduleParams[$module->getId()] = $module->params();
            }
        }
        ModuleModel::saveModuleParams($moduleParams);
        */
        
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
    
    static function addError ($message) {
        $backtrace = Common::getBacktrace(3);
        echo $message.$backtrace;
        Log::error($message.$backtrace);
        if (!isset($_REQUEST['context.errors'])) {
            $_REQUEST['context.errors'] = array();
        }
        $_REQUEST['context.errors'][] = $message;
    }
    
    static function addMessage ($message) {
        if (!isset($_REQUEST['context.messages'])) {
            $_REQUEST['context.messages'] = array();
        }
        $_REQUEST['context.messages'][] = $message;
    }
    
    
    
    static function addRequiredScript ($script) {
        if (!isset($_REQUEST['context.scripts'])) {
            $_REQUEST['context.scripts'] = array();
        }
        $_REQUEST['context.scripts'][] = $script;
    }
    
    static function getRequiredScripts () {
        $scripts = array();
        $includedScripts = array();
        if (!isset($_REQUEST['context.scripts'])) {
            return $scripts;
        }
        foreach ($_REQUEST['context.scripts'] as $script) {
            if (!isset($includedScripts[$script])) {
                $scripts[] = $script;
                $includedScripts[$script] = true;
            }
        }
        return $scripts;
    }
    
    static function addRequiredStyle ($style) {
        if (!isset($_REQUEST['context.styles'])) {
            $_REQUEST['context.styles'] = array();
        }
        $_REQUEST['context.styles'][] = $style;
    }
    
    static function getRequiredStyles () {
        $styles = array();
        $includedStyles = array();
        if (!isset($_REQUEST['context.styles'])) {
            return $styles;
        }
        foreach ($_REQUEST['context.styles'] as $style) {
            if (!isset($includedStyles[$style])) {
                $styles[] = $style;
                $includedStyles[$style] = true;
            }
        }
        return $styles;
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
            return false;
        }
        return $GLOBALS['queryLog'];
    }
    
    static function getNoDatabase () {
        if (!isset($GLOBALS['noDatabase'])) {
            return true;
        }
        return $GLOBALS['noDatabase'];
    }

    static function getShippingMode () {
        return $GLOBALS['shippingMode'];
    }
}


?>