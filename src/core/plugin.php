<?php

include_once('core/common.php');

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
     * returns the dependencies used by this module
     */
    function getDependencies ();

    /**
     * returns the roles defined by this module
     */
    function getRoles ();

    /**
     * returns search results for given text
     */
    function search ($searchText, $lang);
}

interface Translatable {

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
abstract class XModule implements IModule, Translatable {
    public $moduleId;
    public $include;
    public $params = array();
    public $tanslations = array();
    public $paramsDirty = false;
    public $moduleAreaName;
    public $modulePosition;
    function getAreaName () {
        return $this->moduleAreaName;
    }
    function getPosition () {
        return $this->modulePosition;
    }
    function getId () {
        return $this->moduleId;
    }
    function process ($moduleId) {
        $this->moduleId = $moduleId;
        $this->onProcess();
    }
    function onProcess () {
    }
    function view ($moduleId) {
        $this->moduleId = $moduleId;
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
    function link ($params = null, $xhtml = true) {
        return NavigationModel::createModuleLink($this->moduleId,$params,$xhtml);
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
    function getDependencies () {
        return array();
    }
    static function getTranslations () {
        return array();
    }
    static function getTranslation ($key,$escape=true,$lang=null) {
        return TranslationsModel::getTranslation($key,$lang,$escape);
    }
    function getRoles () {
        return array();
    }
    function search ($searchText, $lang) {
        return array();
    }
    // recrusive modules
    function processService ($moduleName) {
        ModuleModel::processService($moduleName);
    }
    function renderService ($moduleName) {
        ModuleModel::renderService($moduleName);
    }
    // creates an alias for a value
    function alias ($var) {
        return Common::hash($this->moduleId."_".$var,false,true);
    }
    function log ($message) {
        Log::info($message);
    }
    function get ($name) {
        $value = isset($_GET[$name]) ? $_GET[$name] : null;
        if ($value == null) {
            $value = isset($_GET[$this->moduleId.'_'.$name]) ? $_GET[$this->moduleId.'_'.$name] : null;
        }
        if ($value == null) {
            $alias = $this->alias($name);
            $value = isset($_GET[$alias]) ? $_GET[$alias] : null;
        }
        return $value;
    }
    function post ($name) {
        $value = isset($_POST[$name]) ? $_POST[$name] : null;
        if ($value == null) {
            $value = isset($_POST[$this->moduleId.'_'.$name]) ? $_POST[$this->moduleId.'_'.$name] : null;
        }
        if ($value == null) {
            $alias = $this->alias($name);
            $value = isset($_POST[$alias]) ? $_POST[$alias] : null;
        }
        return $value;
    }
    function request ($name) {
        $value = isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
        if ($value == null) {
            $value = isset($_REQUEST[$this->moduleId.'_'.$name]) ? $_REQUEST[$this->moduleId.'_'.$name] : null;
        }
        if ($value == null) {
            $alias = $this->alias($name);
            $value = isset($_REQUEST[$alias]) ? $_REQUEST[$alias] : null;
        }
        return $value;
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


/*
class DependencyResolver {

    static public $dependencies = array();
    static function addDependency ($dependency) {
	DependencyResolver::dependencies[$dependency->getName()] = $dependency;
    }
    static function getDependencyStlyes ($name) {
	DependencyResolver::dependencies[$name]->getStyles();
    }
    static function getDependencyScripts ($name) {
	DependencyResolver::dependencies[$name]->getScripts();
    }
}

DependencyResolver::addDependency(new Dependency("finder",array("resource/js/elfinder/js/elfinder.min.js"),array("resource/js/elfinder/css/elfinder.css")));
DependencyResolver::addDependency(new Dependency("editor",array("resource/js/elrte/js/i18n/elrte.en.js","resource/js/elrte/js/elrte.min.js"),array("resource/js/elrte/css/elrte.min.css")));
DependencyResolver::addDependency(new Dependency("multiselect",array("resource/js/multiselect/js/plugins/localisation/jquery.localisation-min.js","resource/js/multiselect/js/plugins/scrollTo/jquery.scrollTo-min.js","resource/js/multiselect/js/ui.multiselect.js"),array()));
DependencyResolver::addDependency(new Dependency("fileupload",array(),array());
DependencyResolver::addDependency(new Dependency("lightbox",array(),array());
DependencyResolver::addDependency(new Dependency("datatables",array(),array());
*/
?>