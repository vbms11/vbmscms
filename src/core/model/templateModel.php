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

    static function getTemplateObj ($page) {
        $templateClass = null;
        // echo "p=".$page;
        if (Common::isEmpty($page->html) && !Common::isEmpty($page->templateinclude) && !Common::isEmpty($page->interface)) {
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
    
    static function renderTemplate ($page) {
        $templateClass = null;
        if (Common::isEmpty($page->html)) {
            $templateClass = TemplateModel::getTemplateObj($page);
        } else {
            $templateClass = new EditableTemplate();
            $templateClass->setData($page->html);
        }
        Context::setRenderer($templateClass);
        $templateClass->invokeRender();
    }

    static function getAreaNames ($pageId) {
        $templateObj = TemplateModel::getTemplateObj($pageId);
        return $templateObj->getAreas();
    }

    static function deleteAreaModule ($moduleId) {
        $moduleId = mysql_real_escape_string($moduleId);
        // call destroy on the module interface
        $moduleObj = TemplateModel::getTemplateModule($moduleId);
        ModuleModel::destroyModule($moduleObj);
        // remove the template area include
        Database::query("delete from t_templatearea where id = '$moduleId'");
    }

    static function getAreaModules ($pageId, $teplateArea = null, $staticModules = null) {
        
        // make are modules condition
        if (empty($teplateArea)) {
            $teplateArea = "";
        } elseif (is_array($teplateArea)) {
            foreach ($teplateArea as $key => $area) {
                $teplateArea[$key] = mysql_real_escape_string($area);
            }
            $teplateArea = "a.name in ('".implode("','", $teplateArea)."') ";
        } else {
            $teplateArea = "a.name = '".mysql_real_escape_string($teplateArea)."' ";
        }
        
        // make static modules condition
        if (empty($staticModules)) {
            $staticModules = "";
        } elseif (is_array($staticModules)) {
            foreach ($staticModules as $key => $area) {
                $staticModules[$key] = mysql_real_escape_string($area);
            }
            $staticModules = "a.code in ('".implode("','", $staticModules)."') ";
        } else {
            $staticModules = "a.code = '".mysql_real_escape_string($staticModules)."' ";
        }

        // make the condition
        $conditionSql = "";
        if (!empty($teplateArea) && !empty($staticModules)) {
            $conditionSql = "((a.pageid = '$pageId' and $teplateArea) or $staticModules)";
        } elseif (!empty($teplateArea)) {
            $conditionSql = "(a.pageid = '$pageId' and $teplateArea)";
        } elseif (!empty($staticModules)) {
            $conditionSql = "$staticModules";
        }

        // 
        $pageId = mysql_real_escape_string($pageId);
        $moduleIncludes = Database::queryAsArray("select a.id, a.name as name, a.pageid, a.position, pt.id as typeid, pt.include, pt.interface, pt.name as modulename, a.code
            from t_templatearea a
            left join t_module pt on pt.id = a.type
            where $conditionSql
            order by a.position asc");

	// if no area name exists use code instead, this is for static modules
	foreach ($moduleIncludes as $moduleInclude) {
		$areaName = trim($moduleInclude->name);
		if (empty($areaName) && !empty($moduleInclude->code)) {
			$moduleInclude->name = $moduleInclude->code;
		}
	}

	return $moduleIncludes;
    }

    static function getStaticModule ($code, $sysName) {
        $code = mysql_real_escape_string($code);
        $sysName = mysql_real_escape_string($sysName);
        $result = Database::query("select a.id, a.name, a.pageid, a.position, pt.id as typeid, pt.include, pt.interface, pt.name as modulename
            from t_templatearea a
            left join t_module pt on pt.id = a.type
            where a.code = '$code'");
        $res = mysql_fetch_object($result);
        if ($res == null) {
            TemplateModel::createStaticModule($code,$sysName);
            return TemplateModel::getStaticModule($code,$sysName);
        }
        return $res;
    }

    static function createStaticModule ($code, $sysName) {
        $code = mysql_real_escape_string($code);
        $sysName = mysql_real_escape_string($sysName);
        $module = ModuleModel::getModuleByName($sysName);
        if ($module == null) {
            return null;
        }
        Database::query("insert into t_templatearea(name,pageid,type,position,code) values('','','".($module->id)."','','$code')");
        $result = Database::queryAsObject("select last_insert_id() as max from t_templatearea");
        return $result->max;
    }

    static function getTemplateAreas ($pageId) {
        $pageId = mysql_real_escape_string($pageId);
        $result = Database::query("select a.id, a.name, a.pageid, pt.id as typeid, pt.include, pt.interface
            from t_templatearea a
            left join t_module pt on pt.id = a.type
            where a.pageid = '$pageId' order by a.position asc");
        $areasByName = array();
        while ($obj = mysql_fetch_object($result))
            $areasByName[$obj->name][] = $obj;
        return $areasByName;
    }

    static function getTemplateModule ($moduleId) {
        $moduleId = mysql_real_escape_string($moduleId);
        $result = Database::query("select a.id, a.name, a.pageid, a.position, pt.id as typeid, pt.include, pt.interface
            from t_templatearea a
            left join t_module pt on pt.id = a.type
            where a.id = '$moduleId'");
        return mysql_fetch_object($result);
    }

    static function shiftTemplateModulesDown ($pageId,$area,$fromPosition) {
        $pageId = mysql_real_escape_string($pageId);
        $area = mysql_real_escape_string($area);
        $fromPosition = mysql_real_escape_string($fromPosition);
        Database::query("update t_templatearea set position = position + 1 where pageid = '$pageId' and name = '$area' and position >= '$fromPosition'");
    }

    static function insertTemplateModule ($pageId,$area,$pageTypeId,$position) {
        if ($position == -1) {
            TemplateModel::shiftTemplateModulesDown($pageId, $area, $position);
            $result = Database::queryAsObject("select min(position)-1 as max from t_templatearea where name = '$area' and pageid = '$pageId'");
            $position = $result->max;
        } else {
            $result = Database::queryAsObject("select max(position)+1 as max from t_templatearea where name = '$area' and pageid = '$pageId'");
            $position = $result->max;
        }
        $pageId = mysql_real_escape_string($pageId);
        $area = mysql_real_escape_string($area);
        $pageTypeId = mysql_real_escape_string($pageTypeId);
        $position = mysql_real_escape_string($position);
        // stop hack
        //if (1==1) 
            //return;
        Database::query("insert into t_templatearea(name,pageid,type,position) values('$area','$pageId','$pageTypeId','$position')");
        $result = Database::queryAsObject("select last_insert_id() as max from t_templatearea");
        return $result->max;
    }

    static function createTemplateAreas ($pageId,$areas) {
        $pageId = mysql_real_escape_string($pageId);
        foreach ($areas as $name => $type) {
            $name = mysql_real_escape_string($name);
            $type = mysql_real_escape_string($type);
            Database::query("insert into t_templatearea(name,pageid,type,position) values('$name','$pageId','$type',(select max(id)+1 from t_templatearea))");
        }
    }

    static function moveTemplateModuleUp ($pageId, $moduleId) {
        $pageId = mysql_real_escape_string($pageId);
        $moduleId = mysql_real_escape_string($moduleId);
        $moduleObj = TemplateModel::getTemplateModule($moduleId);
        $area = $moduleObj->name;
        $modulePosition = $moduleObj->position;
        $result = Database::query("select max(position) as max from t_templatearea where position < '$modulePosition' and name = '$area' and pageid = '$pageId'");
        $maxPosition = mysql_fetch_object($result);
        if ($maxPosition != null) {
            $newPosition = $maxPosition->max;
            Database::query("update t_templatearea set position = '$modulePosition' where pageid = '$pageId' and name = '$area' and position = '$newPosition'");
            Database::query("update t_templatearea set position = '$newPosition' where id = '$moduleId'");
        }
    }

    static function moveTemplateModuleDown ($pageId, $moduleId) {
        $pageId = mysql_real_escape_string($pageId);
        $moduleId = mysql_real_escape_string($moduleId);
        $moduleObj = TemplateModel::getTemplateModule($moduleId);
        $area = $moduleObj->name;
        $modulePosition = $moduleObj->position;
        $result = Database::query("select min(position) as max from t_templatearea where position > '$modulePosition' and name = '$area' and pageid = '$pageId'");
        $maxPosition = mysql_fetch_object($result);
        if ($maxPosition != null && $maxPosition->max != 0) {
            $newPosition = $maxPosition->max;
            Database::query("update t_templatearea set position = '$modulePosition' where pageid = '$pageId' and name = '$area' and position = '$newPosition'");
            Database::query("update t_templatearea set position = '$newPosition' where id = '$moduleId'");
        }
    }

	static function moveTemplateModule($pageId,$moduleId,$areaName,$position) {
		$pageId = mysql_real_escape_string($pageId);
		$moduleId = mysql_real_escape_string($moduleId);
		$areaName = mysql_real_escape_string($areaName);
		$position = mysql_real_escape_string($position);
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

    static function setArea ($pageId,$name,$type) {
        $pageId = mysql_real_escape_string($pageId);
        $name = mysql_real_escape_string($name);
        $type = mysql_real_escape_string($type);
	$result = Database::query("select 1 from t_templatearea where pageid = '$pageId' and name = '$name'");
        $numRows = mysql_num_rows($result);
        if ($numRows == 0) {
            Database::query("insert into t_templatearea(type,name,pageid) values('$type','$name','$pageId')");
        } else {
            Database::query("update t_templatearea set type = '$type' where pageid = '$pageId' and name = '$name'");
        }
    }

    static function deleteTemplateAreas ($pageId) {
        $pageId = mysql_real_escape_string($pageId);
        Database::query("delete from t_templatearea where pageid = '$pageId'");
    }
    
    static function saveTemplate ($id,$name,$include,$interface,$html="",$js="",$css="") {
        // save files if template is dynamic
        if (!Common::isEmpty($js) || !Common::isEmpty($css)) {
            $templatePath = "template/".Common::hash($id,false,false);
            file_put_contents(ResourcesModel::getResourcePath($templatePath, "template.js"), $js);
            file_put_contents(ResourcesModel::getResourcePath($templatePath, "template.css"), $css);
        }
        $id = mysql_real_escape_string($id);
        $name = mysql_real_escape_string($name);
        $include = mysql_real_escape_string($include);
        $interface = mysql_real_escape_string($interface);
        $html = mysql_real_escape_string($html);
        $js = mysql_real_escape_string($js);
        $css = mysql_real_escape_string($css);
        Database::query("update t_template set template = '$include', name = '$name', interface = '$interface', html = '$html', js = '$js', css = '$css' where id = '$id'");
    }
    
    static function createTemplate ($name,$include,$interface,$html="",$js="",$css="") {
        $name = mysql_real_escape_string($name);
        $include = mysql_real_escape_string($include);
        $interface = mysql_real_escape_string($interface);
        $html = mysql_real_escape_string($html);
        $js = mysql_real_escape_string($js);
        $css = mysql_real_escape_string($css);
        Database::query("insert into t_template(template,name,interface,html,js,css) values('$include','$name','$interface','$html','$js','$css')");
        $newId = Database::queryAsObject("select last_insert_id() as newid from t_template");
        return $newId->newid;
    }
    
    static function addTemplate ($siteId,$templateId) {
        $siteId = mysql_real_escape_string($siteId);
        $templateId = mysql_real_escape_string($templateId);
        $obj = Database::queryAsObject("select 1 from t_site_template where siteid = '$siteId' and templateid = '$templateId'");
        if ($obj == null) {
            Database::query("insert into t_site_template (siteid,templateid) values('$siteId','$templateId')");
        }
    }
    
    static function removeTemplate ($siteId,$templateId) {
        $siteId = mysql_real_escape_string($siteId);
        $templateId = mysql_real_escape_string($templateId);
        Database::query("delete from t_site_template where siteid = '$siteId' and templateid = '$templateId'");
    }
    
    static function setMainTemplate ($siteId,$templateId) {
        $siteId = mysql_real_escape_string($siteId);
        $templateId = mysql_real_escape_string($templateId);
        Database::query("update t_site_template set main = '0' where siteid = '$siteId'");
        Database::query("update t_site_template set main = '1' where templateid = '$templateId' and siteid = '$siteId'");
    }
    
    static function getMainTemplate ($siteId) {
        $siteId = mysql_real_escape_string($siteId);
        return Database::queryAsObject("select t.id, t.name, t.template, t.interface from t_template t
                                        join t_site_template st on st.templateid = t.id and st.siteid = '$siteId' where st.main = 1");
    }
    
    static function getTemplates ($siteId = null) {
        $templates = array();
        if ($siteId != null) {
            $siteId = mysql_real_escape_string($siteId);
            $templates = Database::queryAsArray("select t.id, t.name, t.template, t.interface from t_template t
                                                join t_site_template st on st.templateid = t.id and st.siteid = '$siteId'");
        } else {
            $templates = Database::queryAsArray("select id, name, template, interface from t_template");
        }
        return $templates;
    }

    static function getTemplate ($id) {
        $id = mysql_real_escape_string($id);
        $result = Database::query("select id, name, template, interface, css, html, js from t_template where id = '$id'");
        return mysql_fetch_object($result);
    }

    
}

?>
