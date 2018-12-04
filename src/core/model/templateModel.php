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
            $templateClass->setPath(ResourcesModel::createResourceLink("template/".Common::hash($page->template,false,false)));
        }
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
            $templateClass->setPath(ResourcesModel::createResourceLink("template/".Common::hash($page->template,false,false)));
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
            where m.sysname = '$sysName' and name = '$areaName'");
        if (empty($result)) {
            TemplateModel::createStaticModule($areaName,$sysName);
            return TemplateModel::getStaticModule($areaName,$sysName);
        }
        return $result;
    }
    
    static function createStaticModule ($areaName, $sysName) {
        $areaName = Database::escape($areaName);
        $module = ModuleModel::getModuleByName($sysName);
        if ($module == null) {
            return null;
        }
        $instanceId = ModuleInstanceModel::createModuleInstance($module->id);
        Database::query("insert into t_templatearea(name,instanceid,pageid,position) values('$areaName','$instanceId','','')");
        return $instanceId;
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

    static function getTemplateModule ($moduleId) {
        $moduleId = Database::escape($moduleId);
        $result = Database::queryAsObject("select mi.id, a.id as includeid, a.name, a.pageid, a.position, m.id as typeid, m.include, m.interface, m.sysname, m.name as modulename
            from t_templatearea a
            join t_module_instance mi on a.instanceid = mi.id 
            join t_module m on m.id = mi.moduleid
            where a.id = '$moduleId'");
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
        } else {
            $result = Database::queryAsObject("select max(position)+1 as max from t_templatearea where name = '$area' and pageid = '$pageId'");
            $position = $result->max;
        }
        $pageId = Database::escape($pageId);
        $area = Database::escape($area);
        $position = Database::escape($position);
        $instanceId = ModuleInstanceModel::createModuleInstance($moduleId);
        Database::query("insert into t_templatearea(name,instanceid,pageid,position) values('$area','$instanceId','$pageId','$position')");
        return $instanceId;
    }

    static function moveTemplateModuleUp ($pageId, $moduleId) {
        $pageId = Database::escape($pageId);
        $moduleId = Database::escape($moduleId);
        $moduleObj = TemplateModel::getTemplateModule($moduleId);
        $area = $moduleObj->name;
        $modulePosition = $moduleObj->position;
        $result = Database::queryAsObject("select max(position) as max from t_templatearea where position < '$modulePosition' and name = '$area' and pageid = '$pageId'");
        if ($result != null) {
            $newPosition = $result->max;
            Database::query("update t_templatearea set position = '$modulePosition' where pageid = '$pageId' and name = '$area' and position = '$newPosition'");
            Database::query("update t_templatearea set position = '$newPosition' where id = '$moduleId'");
        }
    }

    static function moveTemplateModuleDown ($pageId, $moduleId) {
        $pageId = Database::escape($pageId);
        $moduleId = Database::escape($moduleId);
        $moduleObj = TemplateModel::getTemplateModule($moduleId);
        $area = $moduleObj->name;
        $modulePosition = $moduleObj->position;
        $result = Database::queryAsObject("select min(position) as max from t_templatearea where position > '$modulePosition' and name = '$area' and pageid = '$pageId'");
        if ($result != null && $result->max != 0) {
            $newPosition = $result->max;
            Database::query("update t_templatearea set position = '$modulePosition' where pageid = '$pageId' and name = '$area' and position = '$newPosition'");
            Database::query("update t_templatearea set position = '$newPosition' where id = '$moduleId'");
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
    
    static function saveTemplate ($id,$name,$include,$interface,$html="",$js="",$css="") {
        // save files if template is dynamic
        if (!Common::isEmpty($js) || !Common::isEmpty($css)) {
            $templatePath = "template/".Common::hash($id,false,false);
            file_put_contents(ResourcesModel::getResourcePath($templatePath, "template.js"), $js);
            file_put_contents(ResourcesModel::getResourcePath($templatePath, "template.css"), $css);
        }
        $id = Database::escape($id);
        $name = Database::escape($name);
        $include = Database::escape($include);
        $interface = Database::escape($interface);
        $html = Database::escape($html);
        $js = Database::escape($js);
        $css = Database::escape($css);
        Database::query("update t_template set template = '$include', name = '$name', interface = '$interface', html = '$html', js = '$js', css = '$css' where id = '$id'");
    }
    
    static function createTemplate ($name,$include,$interface,$html="",$js="",$css="") {
        $name = Database::escape($name);
        $include = Database::escape($include);
        $interface = Database::escape($interface);
        $html = Database::escape($html);
        $js = Database::escape($js);
        $css = Database::escape($css);
        Database::query("insert into t_template(template,name,interface,html,js,css) values('$include','$name','$interface','$html','$js','$css')");
        $newId = Database::queryAsObject("select max(id) as newid from t_template");
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
        return Database::queryAsObject("select t.id, t.name, t.template, t.interface 
            from t_template t
            join t_site_template st on st.templateid = t.id and st.siteid = '$siteId' 
            where st.main = 1");
    }
    
    static function getAdminTemplate () {
        return Database::queryAsObject("select t.id, t.name, t.template, t.interface  
            from t_template t
            where t.id = 1");
    }
    
    static function getTemplates ($siteId = null) {
        $templates = array();
        if ($siteId != null) {
            $siteId = Database::escape($siteId);
            $templates = Database::queryAsArray("select t.id, t.name, t.template, t.interface, t.main from t_template t
                                                join t_site_template st on st.templateid = t.id and st.siteid = '$siteId'");
        } else {
            $templates = Database::queryAsArray("select id, name, template, interface, main from t_template");
        }
        return $templates;
    }

    static function getTemplate ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select id, name, template, interface, css, html, js from t_template where id = '$id'");
    }
    
}

?>