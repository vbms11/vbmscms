<?php

require_once 'core/model/moduleModel.php';

class ModuleModel {
    
    static function getModule ($id) {
        $id = mysql_real_escape_string($id);
        $result = Database::query("select * from t_module where id = '$id'");
        return mysql_fetch_object($result);
    }

    static function getModules () {
        return Database::queryAsArray("select * from t_module");
    }
    
    static function getModuleBySysname ($sysname) {
        $sysname = mysql_real_escape_string($sysname);
        return Database::queryAsObject("select * from t_module where sysname = '$sysname' and static = '1'");
    }
    
    static function getModuleByName ($moduleName) {
        $moduleName = mysql_real_escape_string($moduleName);
        return Database::queryAsObject("select * from t_module where sysname = '$moduleName'");
    }
    
    static function getModuleCategorys () {
        return Database::queryAsArray("select * from t_module_category");
    }
    
    static function getModulesInMenu () {
        return Database::queryAsArray("select * from t_module where inmenu = '1'");
    }

    static function createModule ($name,$description,$include,$interface,$inmenu) {
        $name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);
        $include = mysql_real_escape_string($include);
        $interface = mysql_real_escape_string($interface);
        $inmenu = mysql_real_escape_string($inmenu);
        Database::query("insert into t_module(name,description,include,interface,inmenu) values ('$name','$description','$include','$interface','$inmenu')");
        $newObj = Database::query("select last_insert_id() as lastid from t_module");
        return $newObj->lastid;
    }
    
    
    
    static function addModule ($siteId,$moduleId) {
        $siteId = mysql_real_escape_string($siteId);
        $moduleId = mysql_real_escape_string($moduleId);
        $obj = Database::queryAsObject("select 1 from t_site_module where siteid = '$siteId' and moduleid = '$moduleId'");
        if ($obj == null) {
            Database::query("insert into t_site_module (siteid,moduleid) values('$siteId','$moduleId')");
        }
    }
    
    static function removeModule ($siteId,$moduleId) {
        $siteId = mysql_real_escape_string($siteId);
        $moduleId = mysql_real_escape_string($moduleId);
        Database::query("delete from t_site_module where siteid = '$siteId' and templateid = '$moduleId'");
    }
    
    static function getModuleClass ($moduleObj) {
        // get the module instance
        require_once($moduleObj->include);
        $className = $moduleObj->interface;
        $obj = eval("return new $className();");
        // add the translations
        if (in_array("Translatable", class_implements($obj))) {
            TranslationsModel::addTranslations($obj->getTranslations());
        }
        return $obj;
    }

    static function processModule ($moduleId) {
        
        $module = TemplateModel::getTemplateModule($moduleId);
        if ($module != null) {
            Context::setIsFocusedArea(true);
            $moduleClass = ModuleModel::getModuleClass($module);
            $moduleParams = ModuleModel::getModuleParams($moduleId);
            $moduleClass->setParams($moduleParams);
            $moduleClass->process($module->id);
            Context::setIsFocusedArea(false);
        } else {
            //log("invalid moduleId: $moduleId");
        }
    }

    static function renderModule ($moduleObj) {

        $moduleClass = ModuleModel::getModuleClass($moduleObj);
        $contextMenu = false;
        $page = Context::getPage();
        
        if (!Context::isAjaxRequest() || Context::isRenderRequest()) {
            $roles = $moduleClass->getRoles();
            if (Context::hasRole($roles) && Context::getFocusedArea() != $moduleObj->id) {
                $contextMenu = true;
            }
        }

        ?>
        <div class="vcms_module" id="vcms_module_<?php echo $moduleObj->id; ?>">
            <?php
            $moduleParams = ModuleModel::getModuleParams($moduleObj->id);
            $moduleClass->setParams($moduleParams);
            $moduleClass->view($moduleObj->id);
            ?>
        </div>
        <?php
	
        if ($contextMenu == true) {
            ?>
            <script>
            var moduleMenuDiv = $('#vcms_module_<?php echo $moduleObj->id; ?>');
	    moduleMenuDiv.contextMenu([
                {'Edit Module':function (menuItem,menu) {   callUrl('<?php echo NavigationModel::createModuleLink($moduleObj->id,array("action"=>"edit"),false); ?>'); }},
                {'Insert Module':function (menuItem,menu) { callUrl('<?php echo NavigationModel::createStaticPageLink("insertModule",array("action"=>"insertModule","selectedPage"=>Context::getPageId(),"area"=>$moduleObj->name,"position"=>$moduleObj->position),false); ?>'); }},
                {'Configure Page':function (menuItem,menu) {   callUrl('<?php echo NavigationModel::createStaticPageLink("pageConfig",array("action"=>"edit","id"=>Context::getPageId()),false); ?>'); }},
                $.contextMenu.separator,                
                {'Move Up':function (menuItem,menu) {       callUrl('<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"moveup","id"=>$moduleObj->id),false); ?>'); }},
                {'Move Down':function (menuItem,menu) {     callUrl('<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"movedown","id"=>$moduleObj->id),false); ?>'); }},
                <?php
		if ($page->codeid !== $moduleObj->id) {
			?>
			$.contextMenu.separator,
                	{'Delete Module':function (menuItem,menu) { doIfConfirm('Wollen Sie wirklich dieses Modul l&ouml;schen?','<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"delete","id"=>$moduleObj->id),false); ?>'); }}
			<?php
		}
		?>
		],
                {theme:'vista'});
	    moduleMenuDiv.mouseover(function(){ 
		$(this).addClass("vcms_module_show_border");
	    });
	    moduleMenuDiv.mouseout(function(){ 
		$(this).removeClass("vcms_module_show_border");
 	    });
            </script>
            <?php
        }
    }
    
    /*
     * gets module class by name
     */
    static function getServiceClass ($serviceName) {
        return ModuleModel::getModuleBySysname($serviceName);
    }
    
    /*
     * processes module class as service
     */
    static function processService ($serviceName, $params = array()) {
        
        $serviceClass = ModuleModel::getModuleClass(ModuleModel::getModuleBySysname($serviceName));
        Context::setIsFocusedArea(true);
        $serviceClass->setParams($params);
        $serviceClass->process($serviceName);
        Context::setIsFocusedArea(false);
    }
    
    /*
     * render module class as service
     */
    static function renderService ($serviceName, $params = array()) {
        $serviceClass = ModuleModel::getServiceClass($serviceName);
        Context::setIsFocusedArea(true);
        $serviceClass->setParams($params);
        $serviceClass->view($serviceName);
        Context::setIsFocusedArea(false);
    }
    
    /**
     * calls the destroy method on the module interface
     */
    static function destroyModule ($moduleObj) {

        $moduleClass = ModuleModel::getModuleClass($moduleObj);
        $moduleClass->destroy($moduleObj->id);
    }

    /**
     * performs page module management actions
     */
    static function processAction () {

        if (Context::hasRole("pages.edit") && isset($_GET['action'])) {

            $id = isset($_GET['id']) ? $_GET['id'] : null;

            switch ($_GET['action']) {
                case "new":
                    NavigationModel::redirectStaticModule("pages", array("action"=>"insertModule","module"=>$id));
                    break;
                case "delete":
                    TemplateModel::deleteAreaModule($id);
                    break;
                case "moveup":
                    TemplateModel::moveTemplateModuleUp(Context::getPageId(),$id);
                    break;
                case "movedown":
                    TemplateModel::moveTemplateModuleDown(Context::getPageId(),$id);
                    break;
                case "movemodule":
		    TemplateModel::moveTemplateModule(Context::getPageId(),$_GET["id"],$_GET["area"],$_GET["pos"]);
		    Context::returnValue("");
                default:
            }
        }
    }

    static function processActions () {
        
        $moduleId = Context::getModuleId();

        // decide if to unfocus the main content area
        if (Context::getFocusedArea() != $moduleId || $moduleId == null) {
            Context::setFocusedArea(null);
        }

        // process system or module actions
        if ($moduleId != null) {
            ModuleModel::processModule($moduleId);
        } else {
            ModuleModel::processAction();
        }
    }
    
    static function getModuleParams ($moduleId) {
        $moduleId = mysql_real_escape_string($moduleId);
        $ret = array();
        $params = Database::queryAsArray("select * from t_module_instance_params where instanceid = '$moduleId'");
        foreach ($params as $param) {
            $ret[$param->name] = unserialize($param->value);
        }
        return $ret;
    }
    
    static function setModuleParam ($moduleId,$name,$value) {
        $moduleId = mysql_real_escape_string($moduleId);
        $name = mysql_real_escape_string($name);
        $value = mysql_real_escape_string(serialize($value));
        $result = Database::queryAsObject("select 1 as paramexists from t_module_instance_params where instanceid = '$moduleId' and name = '$name'");
        if ($result != null && $result->paramexists == 1) {
            Database::query("update t_module_instance_params set value = '$value' where instanceid = '$moduleId' and name = '$name'");
        } else {
            Database::query("insert into t_module_instance_params (instanceid,name,value) values ('$moduleId','$name','$value')");
        }
    }

}

?>