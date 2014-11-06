<?php

include_once('core/includes.php');

interface IModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function process ($pageid);

    /**
     * called when page is viewed and html created
     */
    function view ($pageid);

    /**
     * called when page is destroyed
     */
    function destroy ($pageid);

    /**
     * called when module is installed
     */
    function install ();

    /**
     * returns style sheets used by this module
     */
    function getStyles ();

    /**
     * returns scripts used by this module
     */
    function getScripts ();
    
    /**
     * returns the roles defined by this module
     */
    function getRoles ();

    /**
     * returns search results for given text
     */
    function search ($searchText, $lang);
}

interface ITranslatable {

    /**
     * returns the translations for texts used in this module
     */
    static function getTranslations ();

    /**
     * returns the translation for a code specified by getTranslations
     */
    static function getTranslation ($key,$escape=true,$lang=null);
}

/*
 * extends IModule
 */
abstract class XModule implements IModule, ITranslatable {
    public $moduleId;
    public $include;
    public $params = array();
    public $tanslations = array();
    public $paramsDirty = false;
    public $moduleAreaName;
    public $modulePosition;
    public $sysname;
    public $includeId;
    function getAreaName () {
        return $this->moduleAreaName;
    }
    function getPosition () {
        return $this->modulePosition;
    }
    function getId () {
        return $this->moduleId;
    }
    function getIncludeId () {
        return $this->includeId;
    }
    function process ($moduleId) {
        $this->moduleId = $moduleId;
        $this->onProcess();
    }
    function onProcess () {
    }
    function view ($moduleId) {
        $this->moduleId = $moduleId;
        $this->loadRequiredResources();
        $this->onView();
    }
    function onView () {
    }
    function param ($name, $value = null) {
        if ($value != null) {
            if (!isset($this->params[$name]) || $this->params[$name] != $value) {
                $this->params[$name] = $value;
                $this->paramsDirty = true;
                ModuleModel::setModuleParam($this->getId(),$name,$value);
            }
        } else {
            return isset($this->params[$name]) ? $this->params[$name] : "";
        }
    }
    function setParams ($params) {
        $this->params = $params;
	$this->paramsDirty = false;
    }
    function getParams () {
        return  $this->params;
    }
    function getAction () {
        
        // return action for a service
        if (Context::getService() != null && isset($_GET['action'])) {
            return $_GET['action'];
        }
        // 
        if (Context::getModuleId() == $this->moduleId && isset($_GET['action'])) {
            if (Context::getFocusedArea() == $this->moduleId && Context::getIsFocusedArea()) {
                return $_GET['action'];
            }
            if (Context::getModuleId() == $this->moduleId && Context::getFocusedArea() == null) {
                return $_GET['action'];
            }
        }
        return null;
    }
    function link ($params = null, $xhtml = true, $sessionKeysOnUrl = false) {
        return NavigationModel::createModuleLink($this->moduleId,$params,$xhtml,$sessionKeysOnUrl);
    }
    function ajaxLink ($params = null, $xhtml = false) {
        return NavigationModel::createModuleAjaxLink($this->moduleId,$params,$xhtml);
    }
    function staticLink ($moduleName, $params = null, $xhtml = true) {
        return NavigationModel::createStaticPageLink($moduleName,$params,$xhtml);
    }
    function redirect ($moduleId = null, $params = null) {
        if (is_array($moduleId)) {
            $params = $moduleId;
            $moduleId = null;
        }
        NavigationModel::redirectModule($moduleId == null ? $this->moduleId : $moduleId, $params);
    }
    function focus () {
        Context::setFocusedArea($this->moduleId);
    }
    function blur () {
        Context::setFocusedArea(null);
    }
    function destroy ($moduleId) {
    }
    function install () {
    }
    function getStyles () {
        return array();
    }
    function getScripts () {
        return array();
    }
    static function getTranslations () {
        return array();
    }
    static function getTranslation ($key,$replace=null,$escape=true,$lang=null) {
        return TranslationsModel::getTranslation($key,$lang,$escape,$replace);
    }
    function getRoles () {
        return array();
    }
    function search ($searchText, $lang) {
        return array();
    }
    // recrusive modules
    function processService ($moduleName) {
        ModuleController::processService($moduleName);
    }
    function renderService ($moduleName) {
        ModuleController::renderService($moduleName);
    }
    // creates an alias for a value
    function alias ($var) {
        return Common::hash($this->moduleId."_".$var,false,true);
    }
    function log ($message) {
        Log::info($message);
    }
    function cookie ($name) {
        return $this->request($name, $_COOKIE);
    }
    function get ($name) {
        return $this->request($name, $_GET);
    }
    function post ($name) {
        return $this->request($name, $_POST);
    }
    function request ($name, $object = null) {
        $object = $object == null ? $_REQUEST : $object;
        $value = isset($object[$name]) ? $object[$name] : null;
        if ($value == null) {
            $value = isset($object[$this->moduleId.'_'.$name]) ? $object[$this->moduleId.'_'.$name] : null;
        }
        if ($value == null) {
            $alias = $this->alias($name);
            $value = isset($object[$alias]) ? $object[$alias] : null;
        }
        return $value;
    }
    
    /**
     * returns path names as required
     */
    function getResourcePaths ($paths) {
        $retPaths = array();
        foreach ($paths as $path) {
            if (strpos($path, "http://") === 0 || strpos($path, "https://") === 0) {
                $retPaths[] = $path;
            } else if (strpos($path, "/") === 0) {
                $retPaths[] = substr($path,1);
            } else {
                $retPaths[] = ResourcesModel::createModuleResourceLink($this, $path);
            }
        }
        return $retPaths;
    }
    
    function loadRequiredResources () {
        $styles = $this->getStyles();
        if (!empty($styles)) {
            $stylePaths = $this->getResourcePaths($styles);
            foreach ($stylePaths as $stylePath) {
                Context::addRequiredStyle($stylePath);
            }
        }
        $scripts = $this->getScripts();
        if (!empty($scripts)) {
            $scriptPaths = $this->getResourcePaths($scripts);
            foreach ($scriptPaths as $scriptPath) {
                Context::addRequiredScript($scriptPath);
            }
        }
    }
    
    function setMessages ($messages) {
        $_SESSION["messages.".$this->moduleId] = $messages;
    }
    
    function clearMessages () {
        $this->setMessages(array());
    }
    
    function getMessages () {
        if (!isset($_SESSION["messages.".$this->moduleId])) {
            $this->clearMessages();
        }
        return $_SESSION["messages.".$this->moduleId];
    }
    
    function addMessages ($messages) {
        $this->setMessages(array_merge($this->getMessages(),$messages));
    }
    
    function getMessage ($key = null) {
        $messages = $this->getMessages();
        if (isset($messages[$key])) {
            return $messages[$key];
        }
        return null;
    }
}

interface ITemplate {
    
    /**
     * returns the names of the areas defined by this template
     */
    function getAreas ();

    /**
     * renders this template
     */
    function render ();

    /**
     * returns script used by this template
     */
    function getScripts ();

    /**
     * returns styles used by this template
     */
    function getStyles ();
}

abstract class XTemplate extends TemplateRenderer {
    
    public $menus = null;
    public $path = null;
    
    /**
     * returns the names of the areas defined by this template
     */
    abstract function getAreas ();

    /**
     * renders this template
     */
    abstract function render ();

    /**
     * returns script used by this template
     */
    function getScripts () {
        return array();
    }

    /**
     * returns styles used by this template
     */
    function getStyles () {
        return array();
    }
    
    /**
     * returns path names as required
     */
    function getResourcePaths ($paths) {
        $retPaths = array();
        foreach ($paths as $path) {
            if (strpos($path, "/") === 0) {
                $retPaths[] = substr($path,1);
            } else if (strpos($path, "http://") === 0) {
                $retPaths[] = $path;
            } else if (strpos($path, "https://") === 0) {
                $retPaths[] = $path;
            } else {
                $retPaths[] = $this->path."/".$path;
            }
        }
        return $retPaths;
    }
    
    function setPath ($path) {
        $this->path = $path;
    }
}

abstract class XUiPlugin {
    
    public $type_input;
    public $type_table;
    public $type_slider;
    public $type_select;
    public $type_date;
    public $type_time;
    public $type_button;
    public $type_menu;
    
    abstract function setData ($val);
    
    abstract function getData ();
    
    abstract function render ();
    
    abstract function renderConfig ();
}

class Dependency {
    public $name;
    public $scripts;
    public $stlyes;
    function Dependency ($name,$scripts,$styles) {
    	$this->name = $name;
        $this->scripts = $scripts;
        $this->styles = $styles;
    }
    function getName () {
        return $this->name;
    }
    function getStyles () {
        return $this->styles;
    }
    function getScripts () {
        return $this->scripts;
    }
}

?>