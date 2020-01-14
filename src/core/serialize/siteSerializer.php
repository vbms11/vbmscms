<?php

class SiteSerializer extends Serializer {
    
    public $siteId;
    public $moduleIds;
    
    function __construct($siteId=null) {
        parent::__construct();
        $this->siteId = $siteId;
    }
    
    function setModuleIds ($moduleIds) {
        $this->moduleIds = $moduleIds;
    }
    
    function exportSite () {
        
        $site = array(SiteModel::getSite($this->siteId));
        $menus = MenuModel::getMenus($this->siteId);
        $menuInstances = MenuModel::getMenuInstances($this->siteId);
        $menuStyle = MenuModel::getMenuStyles($this->siteId);
        $pages = PagesModel::getPagesBySiteId($this->siteId);
        $pageRoles = RolesModel::getPageRolesBySiteId($this->siteId);
        $pageNames = PagesModel::getCodesBySiteId($this->siteId);
        $templateIncludes = TemplateModel::getTemplateAreasBySiteId($this->siteId);
        $moduleInstances = ModuleModel::getModuleInstancesBySiteId($this->siteId);
        $moduleInstanceParams = ModuleModel::getModuleInstanceParamsBySiteId($this->siteId);
        
        $this->addTable("t_site",$site);
        $this->addTable("t_menu",$menus);
        $this->addTable("t_menu_instance",$menuInstances);
        $this->addTable("t_menu_style",$menuStyle);
        $this->addTable("t_page",$pages);
        $this->addTable("t_page_roles",$pageRoles);
        $this->addTable("t_code",$pageNames);
        $this->addTable("t_templatearea",$templateIncludes);
        $this->addTable("t_module_instance",$moduleInstances);
        $this->addTable("t_module_instance_param",$moduleInstanceParams);
        
        // each module exports via siteId
        foreach (ModuleModel::getModules() as $module) {
            $moduleClass = ModuleModel::getModuleClass($module);
            // 
            $moduleIds = array();
            foreach ($moduleInstances as $moduleInstance) {
                if ($moduleInstance->moduleid == $module->id) {
                    $moduleIds []= $moduleInstance;
                }
            }
            $this->setModuleIds($moduleIds);
            $moduleClass->export($this);
        }
    }
    
    function importCopySite () {
        
        $site = $this->getTable("t_site");
        $menus = $this->getTable("t_menu");
        $menuInstances = $this->getTable("t_menu_instance");
        $menuStyles = $this->getTable("t_menu_style");
        $pages = $this->getTable("t_page");
        $pageRoles = $this->getTable("t_page_roles");
        $pageNames = $this->getTable("t_code");
        $templateAreas = $this->getTable("t_templatearea");
        $moduleInstances = $this->getTable("t_module_instance");
        $moduleInstanceParams = $this->getTable("t_module_instance_param");
        
        $firstSite = current($site);
        $this->siteId = SiteModel::createSite($firstSite->name,$firstSite->cmscustomerid,$firstSite->description);
        $this->setNewId("t_site", $firstSite->id, $this->siteId);
        
        $this->setNewId("t_code", CodeModel::createCodes($pageNames));
        
        foreach ($pages as $page) {
            $this->setNewId("t_page", $page->id, PagesModel::createPageBasic($this->siteId,$this->getNewId("t_code",$page->namecode),$page->type,$page->welcome,$page->title,$page->keywords,$page->template,$page->description,$page->code,$page->parentmoduleinstanceid));
        }
        
        foreach ($pageRoles as $pageRole) {
            RolesModel::savePageRole($this->getNewId("t_page",$pageRole->pageid),$pageRole->roleid);
        }
        
        foreach ($menus as $menu) {
            $pageId = $this->getNewId("t_page",$menu->page);
            $parent = $this->getNewId("t_page",$menu->parent);
            if ($pageId == null || $parent == null) {
                continue;
            }
            $menuId = MenuModel::createPageInMenu($pageId, $menu->type, $parent, $menu->lang, $menu->active, $menu->position);
            $this->setNewId("t_menu", $menu->id, $menuId);
        }
        
        foreach ($menuInstances as $menuInstance) {
            $this->setNewId("t_menu_instance", $menuInstance->id, MenuModel::saveMenuInstance(null, $menuInstance->name, $this->siteId));
        }
        
        foreach ($menuStyles as $menuStyle) {
            $this->setNewId("t_menu_style", $menuStyle->id, MenuModel::saveMenuStyle(null, $menuStyle->name, $menuStyle->cssclass, $menuStyle->cssstyle, $menuStyle->siteid));
        }
        
        foreach ($moduleInstances as $moduleInstance) {
            $this->setNewId("t_module_instance", $moduleInstance->id, ModuleInstanceModel::createModuleInstance($moduleInstance->moduleid));
        }
        
        foreach ($moduleInstanceParams as $moduleInstanceParam) {
            ModuleInstanceModel::addModuleInstanceParam($this->getNewId("t_module_instance", $moduleInstanceParam->instanceid), $moduleInstanceParam->name, $moduleInstanceParam->value);
        }
        
        foreach ($templateAreas as $templateArea) {
            $moduleInstanceId = $this->getNewId("t_module_instance", $templateArea->instanceid);
            $pageId = $this->getNewId("t_page", $templateArea->pageid);
            if ($moduleInstanceId == null || $pageId == null || empty($templateArea->name)) {
                continue;
            }
            TemplateModel::createTemplateArea($templateArea->name, $moduleInstanceId, $pageId, $templateArea->position);
        }
        
        // 
        foreach (ModuleModel::getModules() as $module) {
            $moduleClass = ModuleModel::getModuleClass($module);
            $moduleClass->importCopy($this);
        }
        
        // module instances must update parameters because ids have changed
        foreach ($moduleInstances as $moduleInstance) {
            $moduleObj = TemplateModel::getTemplateModule($this->getNewId("t_module_instance", $moduleInstance->id));
            if (empty($moduleObj)) {
                continue;
            }
            $moduleClass = ModuleModel::getModuleClass($moduleObj);
            $moduleClass->updateParameters($this);
        }
        
    }
    
    function importSite () {
        
        $site = $this->getTable("t_site");
        $menus = $this->getTable("t_menu");
        $menuInstances = $this->getTable("t_menu_instance");
        $menuStyles = $this->getTable("t_menu_style");
        $pages = $this->getTable("t_page");
        $pageRoles = $this->getTable("t_page_roles");
        $pageNames = $this->getTable("t_code");
        $templateAreas = $this->getTable("t_templatearea");
        $moduleInstances = $this->getTable("t_module_instance");
        $moduleInstanceParams = $this->getTable("t_module_instance_param");
        
        $firstSite = current($site);
        $siteId = SiteModel::createSite($firstSite->name,$firstSite->cmscustomerid,$firstSite->description);
        //SiteModel::updateSite($firstSite->id, $firstSite->name, $description, $trackerScript, $facebookAppId, $facebookSecret, $googleClientId, $googleClientSecret, $twitterKey, $twitterSecret)$siteId, $name, $description, $trackerScript, $facebookAppId = '', $facebookSecret = '', $googleClientId = '', $googleClientSecret = '', $twitterKey = '', $twitterSecret = ''
        $nameCodeOldNewCode = CodeModel::createCodes($pageNames);
        
        $pagesOldIdNewId = array();
        foreach ($pages as $page) {
            $pagesOldIdNewId[$page->id] = PagesModel::createPageBasic($siteId,$nameCodeOldNewCode[$nameCode],$page->type,$page->welcome,$page->title,$page->keywords,$page->template,$page->description,$page->code,$page->parentmoduleinstanceid);
        }
        
        foreach ($pageRoles as $pageRole) {
            RolesModel::savePageRole($pagesOldIdNewId[$pageRole->pageid],$pageRole->roleid);
        }
        
        foreach ($menus as $menu) {
            MenuModel::createPageInMenu($pagesOldIdNewId[$menu->page], $menu->type, $menu->parent, $menu->lang, $menu->active, $menu->position);
        }
        
        foreach ($menuInstances as $menuInstance) {
            MenuModel::saveMenuInstance(null, $menuInstance->name, $siteId);
        }
        
        foreach ($menuStyles as $menuStyle) {
            MenuModel::insertMenuStyle($menuStyle->id, $menuStyle->name, $menuStyle->cssname, $menuStyle->cssstyle, $siteId);
        }
        
        $instancesOldIdNewId = array();
        foreach ($moduleInstances as $moduleInstance) {
            $instancesOldIdNewId[$moduleInstance->id] = ModuleInstanceModel::createModuleInstance($moduleInstance->moduleid);
        }
        
        foreach ($moduleInstanceParams as $moduleInstanceParam) {
            ModuleInstanceModel::addModuleInstanceParam($instancesOldIdNewId[$moduleInstanceParam->instanceid], $moduleInstanceParam->name, $moduleInstanceParam->value);
        }
        
        foreach ($templateAreas as $templateArea) {
            TemplateModel::createTemplateArea($templateArea->name, $instancesOldIdNewId[$templateArea->instanceid], $pagesOldIdNewId[$templateArea->pageid], $templateArea->position);
        }
        
        
        // each module imports via siteId
        foreach (ModuleModel::getModules() as $module) {
            $moduleClass = ModuleModel::getModuleClass($module);
            $moduleClass->import($this);
        }
    }
    
    function deleteSite () {
        
        $site = array(SiteModel::getSite($this->siteId));
        $menus = MenuModel::getMenus($this->siteId);
        $menuInstances = MenuModel::getMenuInstances($this->siteId);
        $menuStyles = MenuModel::getMenuStyles($this->siteId);
        $pages = PagesModel::getPagesBySiteId($this->siteId);
        $pageRoles = RolesModel::getPageRolesBySiteId($this->siteId);
        $pageNames = PagesModel::getCodesBySiteId($this->siteId);
        $templateIncludes = TemplateModel::getTemplateAreasBySiteId($this->siteId);
        $moduleInstances = ModuleModel::getModuleInstancesBySiteId($this->siteId);
        $moduleInstanceParams = ModuleModel::getModuleInstanceParamsBySiteId($this->siteId);
        
        $this->addTable("t_site",$site);
        $this->addTable("t_menu",$menus);
        $this->addTable("t_menu_instance",$menuInstances);
        $this->addTable("t_menu_style",$menuStyle);
        $this->addTable("t_page",$pages);
        $this->addTable("t_page_roles",$pageRoles);
        $this->addTable("t_code",$pageNames);
        $this->addTable("t_templatearea",$templateIncludes);
        $this->addTable("t_module_instance",$moduleInstances);
        $this->addTable("t_module_instance_param",$moduleInstanceParams);
        
        // module instances must destroy themselfs
        foreach ($moduleInstances as $moduleInstance) {
            $moduleObj = TemplateModel::getTemplateModule($moduleInstance->id);
            if (empty($moduleObj)) {
                continue;
            }
            $moduleClass = ModuleModel::getModuleClass($moduleObj);
            $moduleClass->destroy();
        }
        
        foreach ($site as $s) {
            SiteModel::deleteSite($this->siteId);
        }
        
        foreach ($menus as $menu) {
            MenuModel::deleteMenu($menu->id);
        }
        
        foreach ($menuInstances as $menuInstances) {
            MenuModel::deleteMenuInstance($menuInstances->id);
        }
        
        foreach ($menuStyles as $menuStyle) {
            MenuModel::deleteMenuStyle($menuStyle->id);
        }
        
        foreach ($pages as $page) {
            PagesModel::deletePage($page->id);
        }
        
        foreach ($pageRoles as $pageRole) {
            RolesModel::deletePageRole($pageRole->id);
        }
        
        foreach ($pageNames as $pageName) {
            CodeModel::deleteCode($pageName->code);
        }
        
        foreach ($templateIncludes as $templateInclude) {
            TemplateModel::deleteTemplateAreas($templateInclude->pageid);
        }
        
        foreach ($moduleInstances as $moduleInstance) {
            ModuleModel::deleteModuleInstanceById($moduleInstance->id);
        }
        
        foreach ($moduleInstanceParams as $moduleInstanceParam) {
            ModuleModel::deleteModuleInstanceParamById($moduleInstanceParam->id);
        }
        
    }
    
}