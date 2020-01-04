<?php

class SiteController {
    
    const site_homepage = 1;
    const site_club = 2;
    const site_shop = 4;
    const site_forum = 5;
    const site_calendar = 6;
    
    static function saveSiteType ($siteId, $title, $description, $fileInputName) {
        
        $tmp_name = $_FILES[$fileInputName]["tmp_name"];
        $name = basename($_FILES[$fileInputName]["name"]);
        $path = Resource::getResourcePath("type");
        $randName = null;
        $ext = pathinfo($name)["extension"];
        do {
            $filename = Common::randHash(20,false);
        } while (!is_file("$path/$filename.$ext"));
        $imageFile = "$path/$filename.$ext";
        $siteArchive = "$path/$filename.gz";
        move_uploaded_file($tmp_name, $imageFile);
        self::exportSite($siteId, $siteArchive);
        
        SiteModel::createSiteType($title,$description,$imageFile,$siteArchive);
        SiteModel::deleteSiteType();
        SiteModel::getSiteTypes();
        
        
    }
    
    static function createSite ($siteTemplate, $name, $description,  $cmsCustomerId) {
        
        // create inital site
        $siteId = SiteModel::createSite($name, $cmsCustomerId, $description, DomainsModel::getDomainName());
        UsersModel::createSiteUser(Context::getUserId(), $siteId);
        
        TemplateModel::addTemplatePack();
            // create site user
        Database::query("insert into t_site_users (userid,siteid) values('$id','$siteId')");
        // add templates
        $defaultTemplates = TemplateModel::getTemplates();
        foreach ($defaultTemplates as $template) {
            if (!empty($template->interface)) {
                continue;
            }
            TemplateModel::addTemplate($siteId, $template->id, $template->main);
        }
        
        // creatae the site template
        
        
        return $siteId;
    
    }
    
    static function deleteSite ($siteId) {
        
        SiteModel::deleteSite($siteId);
        MenuModel::deleteMenuInstance($id);
        $site = Sitemodel::getSite($siteId);
        $menus = MenuModel::getMenus($siteId);
        $menuInstances = MenuModel::getMenuInstancesAssocId($siteId);
        $pages = PagesModel::getPagesBySiteId($siteId);
        $pageRoles = RolesModel::getPageRolesBySiteId($siteId);
        
        $pageNames = PagesModel::getCodesBySiteId($siteId);
        
        $moduleInstances = ModuleModel::getModuleInstancesBySiteId($siteId);
        foreach ($moduleInstances as $moduleInstance) {
            $module = ModuleModel::getModule($moduleInstance);
            $moduleClass = ModuleModel::getModuleClass($moduleObj);
            $moduleExport = $moduleClass->delete();
            ModuleInstanceModel::deleteModuleInstance($moduleInstance->id);
        }
        
        $templateIncludes = TemplateModel::getTemplateAreasBySiteId($siteId);
        foreach ($templateIncludes as $templateInclude) {
            TemplateModel::deleteTemplateAreaById($templateInclude->id);
        }
        
        UsersModel::deleteSiteUser(Context::getUserId(), $siteId);
        
    }
    
    static function exportSite ($siteId, $archiveName) {
        // site, domain,
        
        SiteSerializer::clear();
        
        $site = array(SiteModel::getSite($siteId));
        $menus = MenuModel::getMenus($siteId);
        $menuInstances = MenuModel::getMenuInstances($siteId);
        $pages = PagesModel::getPagesBySiteId($siteId);
        $pageRoles = RolesModel::getPageRolesBySiteId($siteId);
        $pageNames = PagesModel::getCodesBySiteId($siteId);
        $templateIncludes = TemplateModel::getTemplateAreasBySiteId($siteId);
        $moduleInstances = ModuleModel::getModuleInstancesBySiteId($siteId);
        $moduleInstanceParams = ModuleModel::getModuleInstanceParamsBySiteId($siteId);
        
        SiteSerializer::addTable("t_site",$site);
        SiteSerializer::addTable("t_menu",$menus);
        SiteSerializer::addTable("t_menu_instance",$menuInstances);
        SiteSerializer::addTable("t_page",$pages);
        SiteSerializer::addTable("t_page_roles",$pageRoles);
        SiteSerializer::addTable("t_code",$pageNames);
        SiteSerializer::addTable("t_templatearea",$templateIncludes);
        SiteSerializer::addTable("t_module_instance",$moduleInstances);
        SiteSerializer::addTable("t_module_instance_param",$moduleInstanceParams);
        
        // export each module
        foreach ($moduleInstances as $moduleInstance) {
            $module = ModuleModel::getModule($moduleInstance->moduleid);
            if (empty($module)) {
                continue;
            }
            $moduleClass = ModuleModel::getModuleClass($module);
            $moduleExport = $moduleClass->export($siteId);
        }
        
        SiteSerializer::createArchive($archiveName);
    }
    
    static function importSite ($archive) {
        
        SiteSerializer::loadArchive($archive);
        
        $site = SiteSerializer::getTable("t_site");
        $menus = SiteSerializer::getTable("t_menu");
        $menuInstances = SiteSerializer::getTable("t_menu_instance");
        $pages = SiteSerializer::getTable("t_page");
        $pageRoles = SiteSerializer::getTable("t_page_roles");
        $pageNames = SiteSerializer::getTable("t_code");
        $templateAreas = SiteSerializer::getTable("t_templatearea");
        $moduleInstances = SiteSerializer::getTable("t_module_instance");
        $moduleInstanceParams = SiteSerializer::getTable("t_module_instance_param");
        
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
        
        
        
        $modules = ModuleModel::getModules();
        foreach ($modules as $i => $module) {
            
        }
    }
    
    static function importSiteCopy ($archive) {
        
        $user = Context::getUser();
        
        SiteSerializer::loadArchive($archive);
        
        $site = SiteSerializer::getTable("t_site");
        $menus = SiteSerializer::getTable("t_menu");
        $menuInstances = SiteSerializer::getTable("t_menu_instance");
        $pages = SiteSerializer::getTable("t_page");
        $pageRoles = SiteSerializer::getTable("t_page_roles");
        $pageNames = SiteSerializer::getTable("t_code");
        $templateAreas = SiteSerializer::getTable("t_templatearea");
        $moduleInstances = SiteSerializer::getTable("t_module_instance");
        $moduleInstanceParams = SiteSerializer::getTable("t_module_instance_param");
        
        $firstSite = current($site);
        $siteId = SiteModel::createSite($firstSite->name,$firstSite->cmscustomerid,$firstSite->description);
        
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
        
    }
    
}