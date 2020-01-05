<?php

class TemplateModel {

    static function renderSetupPage () {
        require_once('core/template/installTemplate.php');
        $installTemplate = new InstallTemplate();
        $installTemplate->render();
    }

    static function getTemplatePath ($page) {
        return dirname($page->templateinclude)."/";
    }
    
    static function getTemplatePreviewObj ($page) {
        $templateClass = null;
        if (!empty($page->templateinclude) && !empty($page->interface)) {
            require_once($page->templateinclude);
            $templateClass = eval("return new $page->interface();");
            $templateClass->setPath(dirname($page->templateinclude));
        } else {
            $templateClass = new EditableTemplatePreview();
            $templateClass->setData($page->html);
            $templateClass->setPath(Resource::createResourceLink("template/".$page->templatepath));
        }
        return $templateClass;
    }
    
    static function getTemplatePreviewFromTemplateId ($templateId) {
        $template = TemplateModel::getTemplate($templateId);
        $templateClass = new EditableTemplatePreview();
        $templateClass->setData($template->html);
        $templateClass->setPath(Resource::createResourceLink("template/".$template->path));
        return $templateClass;
    }
    
    static function getTemplateObj ($page) {
        $templateClass = null;
        // echo "p=".$page;
        if (!empty($page->templateinclude) && !empty($page->interface)) {
            require_once($page->templateinclude);
            $templateClass = eval("return new $page->interface();");
            $templateClass->setPath(dirname($page->templateinclude));
        } else {
            $templateClass = new EditableTemplate();
            $templateClass->setData($page->html);
            $templateClass->setPath(Resource::createResourceLink("template/".$page->templatepath));
        }
        return $templateClass;
    }
    
    static function getAreaNames ($page) {
        $templateObj = TemplateModel::getTemplateObj($page);
        return $templateObj->getAreas();
    }

    static function deleteAreaModule ($moduleId) {
        // Context::getRenderer()->removeModule($moduleId);
        // call destroy on the module interface
        $moduleObj = TemplateModel::getTemplateModule($moduleId);
        ModuleController::destroyModule($moduleObj);
        // remove the template area include
        Database::query("delete from t_templatearea where instanceid = '$moduleId'");
        ModuleInstanceModel::deleteModuleInstance($moduleId);
    }

    static function getAreaModules ($pageId, $templateArea = null, $staticModules = null) {
        
        // make are modules condition
        $templateAreaClean = null;
        if (empty($templateArea)) {
            $templateAreaClean = "";
        } elseif (is_array($templateArea)) {
            foreach ($templateArea as $key => $area) {
                $templateAreaClean[$key] = Database::escape($area);
            }
            $templateAreaClean = "a.name in ('".implode("','", $templateAreaClean)."') ";
        } else {
            $templateAreaClean = "a.name = '".Database::escape($templateArea)."' ";
        }
        
        // make static modules condition
        $staticModuleNames = array();
        $staticModulesCondition = null;
        if (empty($staticModules)) {
            $staticModulesCondition = "";
        } elseif (is_array($staticModules)) {
            foreach ($staticModules as $staticModule) {
                $staticModuleNames[$staticModule['type']] = Database::escape($staticModule['type']);
            }
            $staticModulesCondition = "m.sysname in ('".implode("','", $staticModuleNames)."') ";
        } else {
            $staticModulesCondition = "m.sysname = '".Database::escape($staticModules['type'])."' ";
        }

        // make the condition
        $conditionSql = "";
        if (!empty($templateAreaClean) && !empty($staticModules)) {
            $conditionSql = "((a.pageid = '$pageId' and $templateAreaClean) or $staticModulesCondition)";
        } elseif (!empty($templateAreaClean)) {
            $conditionSql = "(a.pageid = '$pageId' and $templateAreaClean)";
        } elseif (!empty($staticModules)) {
            $conditionSql = $staticModulesCondition;
        }

        // 
        $pageId = Database::escape($pageId);
        $moduleIncludes = Database::queryAsArray("select a.id as includeid, mi.id, a.name as name, a.pageid, a.position, m.id as typeid, m.include, m.interface, m.name as modulename, m.sysname as sysname 
            from t_templatearea a
            join t_module_instance mi on a.instanceid = mi.id
            join t_module m on m.id = mi.moduleid
            where $conditionSql
            order by a.position asc");
        
	// load static modules if needed (first time a page is loaded)
        if (!empty($staticModules)) {
            $staticModulesCreated = false;
            foreach ($staticModules as $staticModule) {
                $staticModuleExists = false;
                foreach ($moduleIncludes as $moduleInclude) {
                    if ($moduleInclude->sysname == $staticModule['type'] && $moduleInclude->name == $staticModule['name']) {
                        $staticModuleExists = true;
                    }
                }
                if (!$staticModuleExists) {
                    TemplateModel::createStaticModule($staticModule['name'], $staticModule['type']);
                    $staticModulesCreated = true;
                }
            }
            if ($staticModulesCreated) {
                return self::getAreaModules($pageId, $templateArea, $staticModules);
            }
        }
	return $moduleIncludes;
    }

    static function getStaticModule ($areaName, $sysName) {
        $areaName = Database::escape($areaName);
        $sysName = Database::escape($sysName);
        $result = Database::queryAsObject("select a.id as includeid, mi.id, a.name, a.pageid, a.position, m.id as typeid, m.include, m.interface, m.sysname as sysname, m.name as modulename
            from t_templatearea a 
            join t_module_instance mi on a.instanceid = mi.id
            join t_module m on m.id = mi.moduleid
            where m.sysname = '$sysName' and a.name = '$areaName'");
        //if (empty($result)) {
        //    TemplateModel::createStaticModule($areaName,$sysName);
        //    return TemplateModel::getStaticModule($areaName,$sysName);
        //}
        return $result;
    }
    
    static function createStaticModule ($areaName, $sysName, $pageId=null) {
        $areaName = Database::escape($areaName);
        $pageId = Database::escape($pageId);
        $module = ModuleModel::getModuleByName($sysName);
        if ($module == null) {
            return null;
        }
        $instanceId = ModuleInstanceModel::createModuleInstance($module->id);
        if ($pageId == null) {
            $pageId = Context::getPageId();
        }
        Database::query("insert into t_templatearea(name,instanceid,pageid,position) values('$areaName','$instanceId','$pageId',0)");
        return $instanceId;
    }
    
    static function createTemplateArea ($name, $instanceId, $pageId, $position) {
        $name = Database::escape($name);
        $instanceId = Database::escape($instanceId);
        $pageId = Database::escape($pageId);
        $position = Database::escape($position);
        Database::query("insert into t_templatearea(name,instanceid,pageid,position) values('$area','$instanceId','$pageId','$position')");
        
    }

    static function getTemplateAreas ($pageId) {
        $pageId = Database::escape($pageId);
        $result = Database::queryAsArray("select a.id as includeid, mi.id, a.name, a.pageid, m.id as typeid, m.include, m.interface
            from t_templatearea a
            join t_module_instance mi on a.instanceid = mi.id 
            join t_module m on m.id = mi.moduleid
            where a.pageid = '$pageId' order by a.position asc");
        $areasByName = array();
        foreach ($result as $obj) {
            $areasByName[$obj->name][] = $obj;
        }
        return $areasByName;
    }
    
    static function getTemplateAreasBySiteId ($siteId) {
        $siteId = Database::escape($siteId);
        return Database::queryAsArray("select ta.* from t_templatearea ta join t_page p on p.id = ta.pageid and p.siteid = '$siteId'");
    }

    static function getTemplateModule ($moduleInstanceId) {
        $moduleInstanceId = Database::escape($moduleInstanceId);
        $result = Database::queryAsObject("select mi.id, a.id as includeid, a.name, a.pageid, a.position, m.id as typeid, m.include, m.interface, m.sysname, m.name as modulename
            from t_templatearea a
            join t_module_instance mi on a.instanceid = mi.id 
            join t_module m on m.id = mi.moduleid
            where mi.id = '$moduleInstanceId'");
        return $result;
    }

    static function getTemplateAreaModule ($includeId) {
        $includeId = Database::escape($includeId);
        $result = Database::queryAsObject("select mi.id, a.id as includeid, a.name, a.pageid, a.position, m.id as typeid, m.include, m.interface, m.sysname, m.name as modulename
            from t_templatearea a
            join t_module_instance mi on a.instanceid = mi.id 
            join t_module m on m.id = mi.moduleid
            where a.id = '$includeId'");
        return $result;
    }

    static function shiftTemplateModulesDown ($pageId,$area,$fromPosition) {
        $pageId = Database::escape($pageId);
        $area = Database::escape($area);
        $fromPosition = Database::escape($fromPosition);
        Database::query("update t_templatearea set position = position + 1 where pageid = '$pageId' and name = '$area' and position >= '$fromPosition'");
    }

    static function insertTemplateModule ($pageId,$area,$moduleId,$position = -1) {
        if ($position == -1) {
            TemplateModel::shiftTemplateModulesDown($pageId, $area, $position);
            $result = Database::queryAsObject("select min(position)-1 as max from t_templatearea where name = '$area' and pageid = '$pageId'");
            $position = $result->max;
            if ($position == null) {
                $position = 0;
            }
        } else {
            $result = Database::queryAsObject("select max(position)+1 as max from t_templatearea where name = '$area' and pageid = '$pageId'");
            $position = $result->max;
        }
        $pageId = Database::escape($pageId);
        $area = Database::escape($area);
        $position = Database::escape($position);
        $instanceId = ModuleInstanceModel::createModuleInstance($moduleId);
        Database::query("insert into t_templatearea(name,instanceid,pageid,position) values('$area','$instanceId','$pageId','$position')");
        $moduleObj = self::getTemplateModule($instanceId);
        $moduleClass = ModuleModel::getModuleClass($moduleObj);
        $moduleClass->create($instanceId);
        return $instanceId;
    }

    static function moveTemplateModuleUp ($pageId, $moduleIncludeId) {
        $pageId = Database::escape($pageId);
        $moduleIncludeId = Database::escape($moduleIncludeId);
        $moduleObj = TemplateModel::getTemplateAreaModule($moduleIncludeId);
        $area = $moduleObj->name;
        $modulePosition = $moduleObj->position;
        $result = Database::queryAsObject("select max(position) as max from t_templatearea where position < '$modulePosition' and name = '$area' and pageid = '$pageId'");
        if ($result != null) {
            $newPosition = $result->max;
            Database::query("update t_templatearea set position = '$modulePosition' where pageid = '$pageId' and name = '$area' and position = '$newPosition'");
            Database::query("update t_templatearea set position = '$newPosition' where id = '$moduleIncludeId'");
        }
    }

    static function moveTemplateModuleDown ($pageId, $moduleIncludeId) {
        $pageId = Database::escape($pageId);
        $moduleIncludeId = Database::escape($moduleIncludeId);
        $moduleObj = TemplateModel::getTemplateAreaModule($moduleIncludeId);
        $area = $moduleObj->name;
        $modulePosition = $moduleObj->position;
        $result = Database::queryAsObject("select min(position) as max from t_templatearea where position > '$modulePosition' and name = '$area' and pageid = '$pageId'");
        if ($result != null && $result->max != 0) {
            $newPosition = $result->max;
            Database::query("update t_templatearea set position = '$modulePosition' where pageid = '$pageId' and name = '$area' and position = '$newPosition'");
            Database::query("update t_templatearea set position = '$newPosition' where id = '$moduleIncludeId'");
        }
    }

    static function moveTemplateModule($pageId,$moduleId,$areaName,$position) {
        $pageId = Database::escape($pageId);
        $moduleId = Database::escape($moduleId);
        $areaName = Database::escape($areaName);
        $position = Database::escape($position);
        // set the area
        Database::query("update t_templatearea set name = '$areaName', position = '$position' where id = '$moduleId'");
        // set the order
        $modules = Database::queryAsArray("select a.id, a.name, a.position, a.pageid from t_templatearea a where a.pageid = '$pageId' and name = '$areaName' order by a.position asc");
        foreach ($modules as $index => $module) {
            $currentModuleId = $module->id;
            if ($currentModuleId == $moduleId) {
                continue;
            }
            Database::query("update t_templatearea set position = '$index' where id = '$currentModuleId'");
        }
    }

    static function deleteTemplateAreas ($pageId) {
        $pageId = Database::escape($pageId);
        $moduleInstances = Database::query("select instanceid from t_templatearea where pageid = '$pageId'");
        foreach ($moduleInstances as $moduleInstance) {
            ModuleInstanceModel::deleteModuleInstance($moduleInstance->instanceid);
        }
        Database::query("delete from t_templatearea where pageid = '$pageId'");
    }
    
    static function deleteTemplateAreaById ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_templatearea where id = '$pageId'");
    }
    
    static function makeTemplatePath () {
        $path;
        do {
            $path = substr(Common::hash(rand(),false,false), 0, 32);
            $result = Database::queryAsObject("select 1 as taken from t_template where path = '$path'");
        } while ($result);
        return $path;
    }
    
    static function saveTemplate ($id,$name,$html="",$js="",$css="",$type=null,$packId=null) {
        
        $id = Database::escape($id);
        $name = Database::escape($name);
        $html = Database::escape($html);
        $jsEscaped = Database::escape($js);
        $cssEscaped = Database::escape($css);
        $query = "update t_template set name = '$name', html = '$html', js = '$jsEscaped', css = '$cssEscaped'";
        if ($type != null) {
            $type = Database::escape($type);
            $query .= ", type = '$type'";
        }
        if ($packId != null) {
            $packId = Database::escape($packId);
            $query .= ", packid = '$packId'";
        }
        $query .= " where id = '$id'";
        Database::query($query);
        
        $template = self::getTemplate($id);
        file_put_contents(Resource::getResourcePath("template/".$template->path, "template.js"), $js);
        file_put_contents(Resource::getResourcePath("template/".$template->path, "template.css"), $css);
    }
    
    static function createTemplate ($name,$html="",$js="",$css="",$type=null,$packId=null) {
        $name = Database::escape($name);
        $html = Database::escape($html);
        $jsEscaped = Database::escape($js);
        $cssEscaped = Database::escape($css);
        $type = Database::escape($type);
        $packId = Database::escape($packId);
        $templatePath = self::makeTemplatePath();
        Database::query("insert into t_template(name,html,js,css,main,type,packid,path) values('$name','$html','$jsEscaped','$cssEscaped',0,'$type','$packId','$templatePath')");
        $newId = Database::queryAsObject("select max(id) as newid from t_template");
        file_put_contents(Resource::getResourcePath("template/".$templatePath, "template.js"), $js);
        file_put_contents(Resource::getResourcePath("template/".$templatePath, "template.css"), $css);
        return $newId->newid;
    }
    
    static function addTemplate ($siteId,$templateId,$main = '0') {
        $siteId = Database::escape($siteId); 
        $templateId = Database::escape($templateId);
        $main = Database::escape($main);
        $obj = Database::queryAsObject("select 1 from t_site_template where siteid = '$siteId' and templateid = '$templateId'");
        if ($obj == null) {
            Database::query("insert into t_site_template (siteid,templateid,main) values('$siteId','$templateId','$main')");
        }
    }
    
    static function removeTemplate ($siteId,$templateId) {
        $siteId = Database::escape($siteId);
        $templateId = Database::escape($templateId);
        Database::query("delete from t_site_template where siteid = '$siteId' and templateid = '$templateId'");
    }
    
    static function setMainTemplate ($siteId,$templateId) {
        $siteId = Database::escape($siteId);
        $templateId = Database::escape($templateId);
        Database::query("update t_site_template set main = '0' where siteid = '$siteId'");
        Database::query("update t_site_template set main = '1' where templateid = '$templateId' and siteid = '$siteId'");
    }
    
    static function getMainTemplate ($siteId) {
        $siteId = Database::escape($siteId);
        return Database::queryAsObject("select t.* from t_template t  
            join t_site s on s.templatepackid = t.packid where t.type = '".self::type_stackpanel."'");
    }
    
    static function getAdminTemplate () {
        return Database::queryAsObject("select t.* from t_template t where t.id = 1");
    }
    
    static function getTemplates ($siteId = null) {
        $templates = array();
        if ($siteId != null) {
            $siteId = Database::escape($siteId);
            $templates = Database::queryAsArray("select t.* from t_template t
                                                join t_site_template st on st.templateid = t.id and st.siteid = '$siteId'");
        } else {
            $templates = Database::queryAsArray("select * from t_template");
        }
        return $templates;
    }

    static function getTemplate ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_template where id = '$id'");
    }
    
    static function deleteTemplate ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_template where id = '$id'");
    }
    
    static function getTemplatesByPack ($packId) {
        $packId = Database::escape($packId);
        return Database::queryAsArray("select * from t_template where packid = '$packId'");
    }
    
    static function getTemplatePack ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * t_template_pack where id = '$id'");
    }
    
    static function createTemplatePack ($name, $description) {
        
        $name = Database::escape($name);
        $description = Database::escape($description);
        Database::query("insert into t_template_pack (name,description) values('$name','$description')");
        $result = Database::queryAsObject("select max(id) as id from t_template_pack");
        return $result->id;
    }
    
    static function getTemplatePacks () {
        
        return Database::queryAsArray("select * from t_template_pack");
    }
    
    static function deleteTemplatePack ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_template_pack where id='$id'");
    }
    
    const type_docpanel = 1;
    const type_docpanelLeft = 2;
    const type_docpanelRight = 3;
    const type_stackpanel = 4;
    const type_fullscreen = 5;
    const type_profile = 6;
    
    static function getTemplateTypes () {
        return array(
            self::type_docpanel => "Docpanel",
            self::type_docpanelLeft => "Content Left",
            self::type_docpanelRight => "Content Right",
            self::type_stackpanel => "Content center",
            self::type_fullscreen => "Fullscreen",
            self::type_profile => "Profile"
        );
    }
}

?>