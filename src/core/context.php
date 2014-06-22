<?php

class Context {
    
    // user

    static function setUser ($user) {
        $_SESSION["context.user"] = $user;
        Session::setUserFromContext();
    }
    
    static function getUser () {
        return isset($_SESSION["context.user"]) ? $_SESSION["context.user"] : null;
    }

    static function getUserId () {
        $user = self::getUser();
        if (empty($user)) {
            return null;
        }
        return $user->id;
    }
    
    static function isLoggedIn () {
        $user = self::getUser();
        return !empty($user);
    }
    
    // user home
    
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
        $_SESSION["context.userId"] = null;
        $_SESSION["context.userName"] = null;
        $_SESSION["context.user"] = null;
        $_SESSION["userRoles"] = array();
        $_SESSION["context.userObjectId"] = null;
        $_SESSION["userRoleGroups"] = array();
        $_SESSION["context.userLoggedin"] = false;
    }

    // current request

    static function isAjaxRequest () {
        return (isset($_GET["moduleAjaxRequest"]) && $_GET["moduleAjaxRequest"] == "true");
    }
    
    static function isRenderRequest () {
        return (isset($_GET["reRender"]) && !empty($_GET["reRender"]));
    }
    
    static function isTemplatePreviewRequest () {
        return isset($_GET["templatePreview"]);
    }
    
    static function isAdminMode () {
        return isset($_SESSION["context.mode.admin"]) ? $_SESSION["context.mode.admin"] : false;
    }
    
    static function setAdminMode ($isAdminMode) {
        $_SESSION["context.mode.admin"] = $isAdminMode;
    }

    static function getPage () {
        return isset($_REQUEST["req.page"]) ? $_REQUEST["req.page"] : null;
    }

    static function getPageId () {
        $page = self::getPage();
        if (empty($page)) {
            return null;
        }
        return $page->id;
    }

    static function getModuleId () {
        return isset($_REQUEST["req.moduleId"]) ? $_REQUEST["req.moduleId"] : null;
    }

    static function setModuleId ($moduleId) {
        $_REQUEST["req.moduleId"] = $moduleId;
    }
    
    static function setService ($moduleName = null) {
        $_REQUEST["req.service"] = $moduleName;
    }
    
    static function getService () {
        return isset($_REQUEST["req.service"]) ? $_REQUEST["req.service"] : null;
    }

    static function getLang () {
        return isset($_SESSION["req.lang"]) ? $_SESSION["req.lang"] : null;
    }
    
    static function getSite () {
        if (!isset($_SESSION["req.site"])) {
            $_SESSION["req.site"] = DomainsModel::getCurrentSite();
        }
        if (empty($_SESSION["req.site"])) {
            return null;
        }
        if (DomainsModel::getDomainName() != $_SESSION["req.site"]->url) {
            unset($_SESSION["req.site"]);
            return self::getSite();
        }
        return $_SESSION["req.site"];
    }
    
    static function getSiteId () {
        $site = self::getSite();
        if (!isset($site->siteid)) {
            return null;
        }
        return $site->siteid;
    }

    // renderer

    static function loadRenderer () {
        
        if (Context::isRenderRequest()) {
            $renderer = new VCmsRenderer();
        } else if (Context::isAjaxRequest()) {
            $renderer = new AJaxRenderer();
        } else if (Context::isTemplatePreviewRequest()) {
            $renderer = TemplateModel::getTemplatePreviewObj(self::getPage());
        } else {
            $renderer = TemplateModel::getTemplateObj(self::getPage());
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

    /**
     * called at the start of a request
     */
    static function startRequest () {
        
        if (Config::getNoDatabase()) {
            Session::startDefaultSession();
        } else {
            
            Session::useSession();
            NavigationModel::startRequest();
            LanguagesModel::selectLanguage();
            
            // notify about cookies
            if (!isset($_COOKIE["cookiesAllowed"])) {
                $lawNotification = new stdClass();
                $lawNotification->id = "cookiesAllowed";
                $lawNotification->type = "confirmOnce";
                $lawNotification->message = TranslationsModel::getTranslation("session.cookies");
                Context::addAlertNotification($lawNotification);
            }
            
            // set the siteid
            $_SESSION["req.site"] = self::getSite();
            
            // check if admin mode
            if (isset($_GET["setAdminMode"])) {
                Context::setAdminMode($_GET["setAdminMode"]);
            }
            
            // set the selected page
            $page = NavigationController::selectPage();
            if ($page != null) {
                $_REQUEST["req.page"] = $page;
                self::loadRenderer();
            }
        }
    }
    
    /**
     * called at the end of a request
     */
    static function endRequest () {
        
        TranslationsModel::maintainTrnaslationsFile();
        Log::writeLogFile();
    }
    
    // is the module currently being rendered or processed 
    // the module that should receive the action parameter
    static function setIsFocusedArea ($bool) {
        $_SESSION["req.mainArea"] = $bool;
    }
    
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
    static function setReturnValue ($value) {
        $_REQUEST["req.returnValue"] = $value;
    }
    
    /**
     * returns the return value and null if none was set
     */
    static function getReturnValue () {
        return isset($_REQUEST["req.returnValue"]) ? $_REQUEST["req.returnValue"] : null;
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
    
    static function addAlertNotification ($message) {
        if (!isset($_REQUEST['context.alertNotification'])) {
            $_REQUEST['context.alertNotification'] = array();
        }
        $_REQUEST['context.alertNotification'][] = $message;
    }
    
    static function getAlertNotifications () {
        if (!isset($_REQUEST['context.alertNotification'])) {
            $_REQUEST['context.alertNotification'] = array();
        }
        return $_REQUEST['context.alertNotification'];
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
    
    static function getDBHost () {
        return $GLOBALS['dbHost'];
    }
    
    static function getDBUser () {
        return $GLOBALS['dbUser'];
    }
    
    static function getDBPassword () {
        return $GLOBALS['dbPass'];
    }
    
    static function getDBName () {
        return $GLOBALS['dbName'];
    }
    
    static function getShippingMode () {
        return $GLOBALS['shippingMode'];
    }
    
    static function getCmsMainDomain () {
        return $GLOBALS['cmsMainDomain'];
    }
    
    static function getSeoUrl () {
        if (isset($GLOBALS['seoUrl']) && $GLOBALS['seoUrl'] === true) {
            return true;
        }
        return false;
    }
    
    static function getPiwikUsername () {
        return $GLOBALS['piwikUsername'];
    }
    
    static function getPiwikPassword () {
        return $GLOBALS['piwikPassword'];
    }
    
    static function getAdminEmail () {
        return $GLOBALS['cmsAdminEmail'];
    }
}


?>