<?php

abstract class BaseRenderer {
    
    public $menus = null;
    public $modules = null;
    
    abstract function invokeRender ();
    
    // modules in this page

    function loadModules ($pageId = null) {
        
        if ($pageId == null) {
            $pageId = Context::getPageId();
        }

        // get static modules
        $staticModules = $this->getStaticModules();
        $templateAreas = $this->getAreas();

        // load the modules
        $pageModules = TemplateModel::getAreaModules($pageId, $templateAreas, $staticModules);
        $pageAreaNames = array();
        foreach ($pageModules as $module) {
            $this->addModule(ModuleModel::getModuleClass($module,false));
            $pageAreaNames[$module->id] = $module->name;
        }

        // load the module parameters
        $this->setModuleParams(ModuleModel::getModulesParams(array_keys($pageAreaNames)));
    }
    
    /**
     * get all modules on page
     * @return array
     */
    function getPageModules () {
        if (empty($this->modules)) {
            $this->loadModules();
        }
        return $this->modules;
    }
    
    /**
     * 
     * @param array $instanceParams
     */
    function setModuleParams ($instanceParams) {
        foreach ($instanceParams as $instanceId => $params) {
            $module = $this->getModule($instanceId);
            $module->setParams($params);
        }
    }
    
    /**
     * add module
     * @param Object $module
     */
    function addModule ($module) {
        if (empty($this->modules)) {
            $this->modules = array();
        }
        if (!isset($this->modules[$module->moduleAreaName])) {
            $this->modules[$module->moduleAreaName] = array();
        }
        $this->modules[$module->moduleAreaName][$module->moduleId] = $module;
    }
    
    /**
     * remove module by module id
     * @param Integer $moduleId
     */
    function removeModule ($moduleId) {
        foreach ($this->getPageModules() as $modules) {
            if (isset($modules[$moduleId])) {
                unset($modules[$moduleId]);
            }
        }
    }
    
    /**
     * get module by area name
     * @param String $areaName
     * @return array
     */
    function getModules ($areaName = null) {
        $modules = $this->getPageModules();
        if ($areaName == null) {
            return $modules;
        }
        if (isset($modules[$areaName])) {
            return $modules[$areaName];
        }
        return array();
    }
    
    /**
     * get module by module id
     * @param Integer $id
     * @return null
     */
    function getModule ($id) {
        $modules = $this->getPageModules();
        foreach ($modules as $modules) {
            if (isset($modules[$id])) {
                return $modules[$id];
            }
        }
        return null;
    }
    
    /**
     * returns the pages in given menu
     */
    function getMenu ($menu, $parent = null) {
        if ($this->menus == null) {
            $this->menus = MenuModel::getPagesInMenu();
        }
        if (!empty($parent)) {
            $childs = array();
            foreach ($this->menus as $menu) {
                if ($menu->parent == $parent) {
                    $childs[] = $menu;
                }
            }
            return $childs;
        }
        return isset($this->menus[$menu]) ? $this->menus[$menu] : null;
    }

    /**
     * returns the pages in all menus
     */
    function getMenus () {
    	return $this->menus;
    }
    
    /**
     * returns translations for a given code
     * @param String $key
     * @param array $replace
     * @param Boolean $escape
     * @param String $lang
     * @return String
     */
    static function getTranslation ($key,$replace=null,$escape=true,$lang=null) {
        return TranslationsModel::getTranslation($key,$lang,$escape,$replace);
    }
}

?>