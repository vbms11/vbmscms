<?php
/**
 * Description of navigationModel
 *
 * @author vbms
 */

class NavigationModel {
    
    static $secureLink = true;

    // saves next actions in nav.nextAction

    static function hasNextAction () {
        if (isset($_SESSION["nav.nextAction"]) && count($_SESSION["nav.nextAction"]) > 0) {
            return true;
        }
        return false;
    }

    static function redirectNextAction () {
        $nextAction = array_pop($_SESSION["nav.nextAction"]);
        switch ($nextAction->type) {
            case "static":
                self::redirectStaticModule($nextAction->name, $nextAction->params);
                break;
            case "module":
                self::redirectModule($nextAction->name, $nextAction->params);
                break;
            case "page":
                self::redirectPage($nextAction->name, $nextAction->params);
                break;
        }
    }

    static function addStaticNextAction ($name,$params=null) {
        self::addNextAction("static",$name,$params);
    }

    static function addModuleNextAction ($name,$params=null) {
        self::addNextAction("module",$name,$params);
    }

    static function addPageNextAction ($name,$params=null) {
        self::addNextAction("page",$name,$params);
    }

    static function addNextAction ($type,$name,$params=null) {
        $action;
        $action->type = $type;
        $action->name = $name;
        $action->params = $params;
        if (!isset($_SESSION["nav.nextAction"])) {
            $_SESSION["nav.nextAction"] = array();
        }
        $_SESSION["nav.nextAction"][] = $action;
    }

    static function clearNextActions () {
        $_SESSION["nav.nextAction"] = array();
    }

    static function getSitePath () {
        return "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']);
    }
    
    //TODO put in lang select module / find better way
    static function createLangSelectLink ($lang, $params = array(), $xhtml = true) {
        foreach ($_GET as $key => $value) {
            if ($key == "changelang") {
                continue;
            }
            $params[$key] = $value;
        }
        $params["changelang"] = $lang;
        if (Common::isEmpty(Context::getModuleId())) {
            return NavigationModel::createPageLink(Context::getPageId(),$params,$xhtml);
        } else {
            return NavigationModel::createModuleLink(Context::getModuleId(),$params,$xhtml);
        }
    }
    
    static function modifyLink ($link,$extraParams,$xhtml=true) {
        // if ($xhtml == false) $link = urldecode($link);
        return $link.NavigationModel::buildParams($extraParams,$xhtml);
    }

    static function modifyRedirect ($link,$extraParams,$xhtml=true) {
        return NavigationModel::redirect($link.NavigationModel::buildParams($extraParams,false));
    }

    static function redirectPage ($pageId,$params=null) {
        NavigationModel::redirect(NavigationModel::createPageLink($pageId, $params, false, false));
    }

    static function redirectModule ($moduleId,$params=null) {
        NavigationModel::redirect(NavigationModel::createModuleLink($moduleId, $params, false, false, false));
    }
    
    static function redirectStaticModule ($name,$params=null) {
        NavigationModel::redirect(NavigationModel::createStaticPageLink($name, $params, false, false));
    }

    static function redirect ($url=null,$secure=true) {
        if ($url == null) {
            // redirect to welcome page
            $url = "?".NavigationModel::addSessionKeys($xhtml);
        }
        // parse link if its a secure link
        if ($secure) {
            $params = NavigationModel::getLinkParams($url);
                if (isset($params["c"])) {
                    $url = NavigationModel::getSecureLink($params["c"]);
                }
                header("Location: ". NavigationModel::registerSecureLink($url,false));
        } else {
            header("Location: ". $url);
        }
    }
    
    static function createPageRenderClick($pageId,$reRender,$animate,$effect=null) {
        $reRenderJs = "['".implode("','",$reRender)."']";
        $params = NavigationModel::addAjaxParam();
        $params["reRender"] = implode(",",$reRender);
        $params["animate"] = Common::urlEscape($animate);
        $params["effect"] = $effect;
        $renderLink = NavigationModel::createPageLink($pageId,$params,false);
        return "smefCmsRender('$renderLink'); return false;";
    }
    
    static function createWelcomePageLink ($xhtml=true) {
        $link = "?".NavigationModel::addSessionKeys($xhtml);
        return NavigationModel::$secureLink ? NavigationModel::registerSecureLink($link,$xhtml):$link;
    }
    
    static function createPageLink ($pageId=null,$params=null,$xhtml=true,$secure=null) {
        if ($pageId == null) {
            $welcomePage = PagesModel::getWelcomePage(Context::getLang());
            if ($welcomePage == null) {
                $welcomePage = PagesModel::getStaticPage("startup", Context::getLang());
            }
            $pageId = $welcomePage->id;
        }
        $link = "?pageid=$pageId".NavigationModel::buildParams($params,$xhtml).NavigationModel::addSessionKeys($xhtml);
        return ($secure == null ? NavigationModel::$secureLink : $secure) ? NavigationModel::registerSecureLink($link,$xhtml):$link;
    }
    
    static function createPageNameLink ($name=null,$pageId=null,$params=null,$xhtml=true,$secure=null) {
        if ($params == null) {
            $params = array();
        }
        if (Config::getSeoUrl() === true) {
            return "/".urlencode($pageId)."/".urlencode($name)."/";
        } else {
            $params["n"] = urlencode($name);
            $params["p"] = urlencode($pageId);
            if ($pageId == null) {
                $welcomePage = PagesModel::getWelcomePage(Context::getLang());
                if ($welcomePage == null) {
                    $welcomePage = PagesModel::getStaticPage("startup", Context::getLang());
                }
                $pageId = $welcomePage->id;
            }
            return "?".NavigationModel::buildParams($params,$xhtml,true);
        }
    }

    static function createModuleLink ($moduleId,$params=null,$xhtml=true,$sessonKeysOnUrl=false,$secure=null) {
        $link = "?moduleid=$moduleId".NavigationModel::buildParams($params,$xhtml);
        return ($secure == null ? NavigationModel::$secureLink : $secure) ? NavigationModel::registerSecureLink($link,$xhtml,$sessonKeysOnUrl):$link;
    }
    
    static function createTemplatePreviewLink ($templateId,$xhtml=true,$secure=null) {
        $link = "?templatePreview=$templateId".NavigationModel::addSessionKeys($xhtml);
        return ($secure == null ? NavigationModel::$secureLink : $secure) ? NavigationModel::registerSecureLink($link,$xhtml):$link;
    }

    static function createModuleAjaxLink ($moduleId,$params=null,$xhtml=true,$secure=true) {
        $link = "?moduleid=$moduleId".NavigationModel::buildParams(NavigationModel::addAjaxParam($params),$xhtml);
        return NavigationModel::$secureLink ? NavigationModel::registerSecureLink($link,$xhtml).NavigationModel::addSessionKeys($xhtml,true) : $link.NavigationModel::addSessionKeys($xhtml,true);
    }

    static function redirectAjaxModule ($moduleId,$params=null) {
        NavigationModel::redirect(NavigationModel::createModuleLink($moduleId,NavigationModel::addAjaxParam($params),false));
    }
    
    static function createActionLink ($action,$params=null,$xhtml=true) {
        $moduleId = Context::getModuleId();
        $link = "?moduleid=$moduleId&action=$action".NavigationModel::buildParams($params,$xhtml).(!NavigationModel::$secureLink ? NavigationModel::addSessionKeys($xhtml) : "");
        return NavigationModel::$secureLink ? NavigationModel::registerSecureLink($link,$xhtml):$link;
    }
    
    static function createServiceLink ($service,$params=null,$xhtml=true,$secure=true) {
        $link = "?service=$service".NavigationModel::buildParams($params,$xhtml).(!NavigationModel::$secureLink ? NavigationModel::addSessionKeys($xhtml) : "");
        return NavigationModel::$secureLink && $secure ? NavigationModel::registerSecureLink($link,$xhtml):$link;
    }
    
    static function createStaticPageLink ($name,$params=null,$xhtml=true,$secure=true) {
        $link = "?static=$name".NavigationModel::buildParams($params,$xhtml).(!NavigationModel::$secureLink ? NavigationModel::addSessionKeys($xhtml) : "");
        return NavigationModel::$secureLink && $secure ? NavigationModel::registerSecureLink($link,$xhtml):$link;
    }
    
    static function addSessionKeys ($xhtml=true,$onUrl=false) {
        $keys = array();
        $sessionKeys = Session::getSessionKeysArray();
        foreach ($sessionKeys as $sessionKey => $sessionValue) {
            if (isset($_COOKIE[$sessionKey]) && $onUrl == false) {
                continue;
            } else {
                $keys[$sessionKey] = $sessionValue;
            }
        }
        return NavigationModel::buildParams($keys,$xhtml);
    }
    
    static function buildParams ($params=null,$xhtml=true,$first=false) {
        $link = "";
        if (!empty($params)) {
            foreach ($params as $key => $param) {
                if (!$first) {
                    $seperator = $xhtml ? "&amp;" : "&";
                } else {
                    $seperator = "";
                    $first = false;
                }
                $link .= $seperator.$key."=".$param;
            }
        }
        return $link;
    }
    
    static function addAjaxParam ($params = array()) {
        if ($params == null)
            $params = array();
        $params["moduleAjaxRequest"] = true;
        return $params;
    }
    
    static function registerSecureLink ($url,$xhtml=true,$sessonKeysOnUrl=false) {
        $links = array();
        if ($xhtml) {
            $url = html_entity_decode($url);
        }
        if (isset($_SESSION['nav.links'])) {
            $links = $_SESSION['nav.links'];
        }
        $authHash = NavigationModel::generateAuthHash($url);
        $links[$authHash] = $url;
        $_SESSION['nav.links'] = $links;
        return "?c=".urlencode($authHash).NavigationModel::addSessionKeys($xhtml,$sessonKeysOnUrl);
    }

    static function getSecureLink ($hash) {
        
        if (!isset($_SESSION['nav.links']))
            return null;
        $links = $_SESSION['nav.links'];
        if (!isset($links[$hash]))
            return null;

        return $links[$hash];
    }
    
    static function getLinkParams ($url) {
        $ret = array();
        $url = trim($url, "?");
        $params = explode("&", $url);
        foreach ($params as $param) {
            $paramNameLen = strpos($param,"=");
            $paramValue = substr($param, $paramNameLen+1);
            $paramName = substr($param, 0, $paramNameLen);
            $ret[$paramName] = urldecode($paramValue);
        }
        return $ret;
    }
    
    static function parseSecureLink ($url) {
        $url = trim($url, "?");
        $params = explode("&", $url);
        // parese get params
        foreach ($params as $param) {
            
            $paramNameLen = strpos($param,"=");
            $paramName = substr($param, 0, $paramNameLen);
            $paramValue = substr($param, $paramNameLen+1);
            if ($param == "c" || $param == "p" || $param == "k") {
                continue;
            } else {
                if ($paramName == "pageid") {
                    $_GET[$paramName] = $paramValue;
                } else {
                    $_GET[$paramName] = urldecode($paramValue);
                }
            }
        }
    }
    
    static function clearSecureLinks () {
        if (!Context::isAjaxRequest()) {
            $secureLinks = array();
            if (isset($_SESSION['nav.history'])) {
                $secureLinks = array_merge($secureLinks, $_SESSION['nav.history']);
            }
            $_SESSION['nav.links'] = $secureLinks;
        }
    }

    static function generateAuthHash ($url) {
        if (!isset($_SESSION['nav.links'])) {
            $_SESSION['nav.links'] = array();
        }
        $links = $_SESSION['nav.links'];
        do {
            $hash = Common::randHash(30);
        } while (isset($links[$hash]));
        return $hash;
    }
    
    static function addToHistory () {
        $pageCode = null;
        if (isset($_GET['c'])) {
            $pageCode = $_GET['c'];
            
            $link = NavigationModel::getSecureLink();
            if (!isset($_SESSION['nav.history'])) {
                $_SESSION['nav.history'] = array();
            }
            $_SESSION['nav.history'][$pageCode] = $link;
        }
        
    }
    
    static function startRequest () {

        // get request code
        $code = null;
        if (isset($_GET['c'])) {
            $code = $_GET['c'];
            unset($_GET['c']);
        } else if (isset($_POST['c'])) {
            $code = $_POST['c'];
            unset($_POST['c']);
        }

        // get params from secure link
        $secureUrl = null;
        if ($code != null) {
            $secureUrl = NavigationModel::getSecureLink($code);
            if ($secureUrl == null) {
                
            } else {
                NavigationModel::parseSecureLink($secureUrl);
            }
        }

        // unescape post params
        foreach ($_POST as $postKey => $postValue) {
            if (is_array($_POST[$postKey])) {
                
            } else {
                $_POST[$postKey] = stripslashes($postValue);
            }
        }

        // log the request
        Log::info("secure request c: ".$code." url: ".$secureUrl);
    }
    
}
?>