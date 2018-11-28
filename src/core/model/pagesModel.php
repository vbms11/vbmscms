<?php

require_once 'core/plugin.php';

class PagesModel {
    
    static function updateModifyDate ($pageId = null) {
        if (empty($pageId)) {
            $pageId = Context::getPageId();
        }
        if (Context::isAdminMode() == "adminPages") {
            $pageId = $_SESSION['adminPageId'];
        }
        $pageId = Database::escape($pageId);
        Database::query("update t_page set modifydate = now() where id = '$pageId'");
    }
    
    static function getPageNameInMenu ($pageId, $lang) {
        $pageId = Database::escape($pageId);
        $lang = Database::escape($lang);
        $query = "select c.value as name from t_page p
            left join t_code as c on p.namecode = c.code and c.lang = '$lang'
            where p.id = '$pageId'";
        $obj = Database::queryAsObject($query);
        if ($obj == null)
            return null;
        return $obj->name;
    }

    static function getPageIdFromModuleId ($moduleId) {
        $moduleId = Database::escape($moduleId);
        $result = Database::queryAsObject("select pageid from t_templatearea where instanceid = '$moduleId'");
        return $result->pageid;
    }
    
    static function getWelcomePage ($lang) {
        $lang = Database::escape($lang);
        $siteId = Context::getSiteId();
        if ($siteId != null) {
            $endQuery = "(siteid = '$siteId' or siteid is null) order by p.siteid desc";
        } else {
            $endQuery = "siteid is null";
        }
        $query = "select p.id, p.codeid as codeid, t.css, t.html, t.js, p.id, p.type, m.parent, m.position, m.active, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.description, p.template, t.template as templateinclude, t.interface as interface, p.pagetrackerscript 
            from t_page p
            left join t_template t on p.template = t.id
            left join t_menu as m on p.id = m.page
            left join t_code as c on p.namecode = c.code and c.lang = '$lang'
            where p.welcome = '1' and p.id in (
                    select p1.id from t_page p1 
                    inner join t_page_roles as pc on p1.id = pc.pageid and 
                    pc.roleid in (".implode(array_values(Context::getRoleGroups()),',').")
                    where p1.siteid = $siteId
                ) and $endQuery";
        
        $pageObj = Database::queryAsObject($query);
        
        if (!empty($pageObj)) {
            $pageObj = self::ensureAdminTemplate($pageObj);
        }
        
	if (count(Context::getRoleGroups()) > 0) {
            return $pageObj;
	}
        return null;
    }
    
    static function getPageByCode ($code, $lang) {
        $code = Database::escape($code);
        $lang = Database::escape($lang);
        $siteId = Context::getSiteId();
        $query = "select p.id, p.codeid as codeid, t.css, t.html, t.js, p.id, p.type, m.parent, m.position, m.active, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.template, t.template as templateinclude, t.interface as interface, p.description, p.pagetrackerscript 
            from t_page p
            left join t_template t on p.template = t.id
            left join t_menu as m on p.id = m.page and lang = '$lang'
            left join t_code as c on p.namecode = c.code and c.lang = '$lang'
            where p.code = '$code' and p.id in (
                    select p1.id from t_page p1 
                    inner join t_page_roles as pc on p1.id = pc.pageid and 
                    pc.roleid in (".implode(array_values(Context::getRoleGroups()),',').")
                    where p1.siteid = '$siteId'
                )";
        
        $pageObj = Database::queryAsObject($query);
        $pageObj = self::ensureAdminTemplate($pageObj);
        
	if (count(Context::getRoleGroups()) > 0) {
		return $pageObj;
	}
        return null;
    }
    
    /**
     * returns a page object of the default page
     */
    static function getStaticPage ($_name,$_lang) {
        $name = Database::escape($_name);
        $lang = Database::escape($_lang);
        $query = "select p.id, p.codeid as codeid, p.code, t.css, t.html, t.js, p.id, p.type, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.template, t.template as templateinclude, t.interface as interface, p.description, p.pagetrackerscript 
            from t_page p
            left join t_template t on p.template = t.id 
            left join t_code as c on p.namecode = c.code and c.lang = '$lang'
            where p.code = '$name'";
        $pageObj = Database::queryAsObject($query);
        
        // create page if it dose not exist
        if (empty($pageObj)) {
            $site = DomainsModel::getCurrentSite();
            if (empty($site)) {
                $site->siteid = 1;
            }
            $moduleTypeId = ModuleModel::getModuleByName($_name);
            if (!empty($moduleTypeId)) {
                $template = TemplateModel::getMainTemplate($site->siteid);
                $pageId = PagesModel::createPage($_name, 0, $_lang, 0, $_name, $_name, $template->id, 0, $_name, $_name);
                foreach (RolesModel::getCustomRoles() as $roleId => $role) {
                    RolesModel::savePageRole($pageId, $roleId);
                }
                $page = PagesModel::getPageTemplate($pageId, $_lang);
                $templateAreas = TemplateModel::getAreaNames($page);
                $moduleId = TemplateModel::insertTemplateModule($pageId, $templateAreas[0], $moduleTypeId->id);
                Database::query("update t_page set codeid = '$moduleId' where id = '$pageId'");
                return PagesModel::getStaticPage($_name,$_lang);
            } else {
                return null;
            }
        }
        
        $pageObj = self::ensureAdminTemplate($pageObj);
        
        return $pageObj;
    }
    
        /**
     * returns a page object of the default page
     */
    static function getTemplatePreviewPage ($templateId) {
        $templateId = Database::escape($templateId);
        return Database::queryAsObject("select '0' as codeid, '' as code, t.css, t.html, t.js, '0' as id, '0' as type, '0' as namecode, '' as name, '0' as welcome, '' as title, '' as keywords, t.id as template, t.template as templateinclude, t.interface as interface, '' as description, '' as pagetrackerscript 
            from  t_template t
            where t.id = '$templateId'");
    }
    
    /**
     * 
     * @param type $pageObj
     */
    static function ensureAdminTemplate ($pageObj) {
        
        if (Context::isAdminMode()) {
            $adminTemplate = TemplateModel::getAdminTemplate();
            $pageObj->css = $pageObj->html  = $pageObj->js = "";
            $pageObj->templateinclude = $adminTemplate->template;
            $pageObj->interface = $adminTemplate->interface;
            $pageObj->template = $adminTemplate->template;
        }
        
        return $pageObj;
    }
    
    static function getPageTemplate ($id, $lang) {
        $id = Database::escape($id);
        $lang = Database::escape($lang);
        $query = "select p.id, p.codeid as codeid, t.css, t.html, t.js, p.id, p.type, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.template, t.template as templateinclude, t.interface as interface, p.description, p.pagetrackerscript 
            from t_page p
            left join t_template t on p.template = t.id
            left join t_code as c on p.namecode = c.code and c.lang = '$lang'
            where p.id = '$id'";
        return Database::queryAsObject($query);
    }
    
    static function setPageTemplate ($pageId, $templateId) {
        $pageId = Database::escape($pageId);
        $templateId = Database::escape($templateId);
        Database::query("update t_page set template = '$templateId' where id = '$pageId'");
    }
    
    static function getPage ($id, $lang, $roles=true, $checkName=null, $ensureAdminTemplate = true) {
        $id = Database::escape($id);
        $lang = Database::escape($lang);
        $siteId = Context::getSiteId();
        $query = "select p.id, p.codeid as codeid, t.css, t.html, t.js, p.id, p.type, m.parent, m.position, m.active, m.type as menuid, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.template, t.template as templateinclude, t.interface as interface, p.description, p.pagetrackerscript 
            from t_page p
            left join t_template t on p.template = t.id
            left join t_menu as m on p.id = m.page and lang = '$lang'
            left join t_code as c on p.namecode = c.code and c.lang = '$lang'
            where ";
        if ($checkName != null) {
            $checkName = Database::escape($checkName);
            $query .= "c.value = '$checkName' ";
        } else {
            $query .= "p.id = '$id'";
        }
        if ($roles) {
            $query .= " and p.id in (
                select p1.id from t_page p1 
                inner join t_page_roles as pc on p1.id = pc.pageid and 
                pc.roleid in (".implode(array_values(Context::getRoleGroups()),',').")
                where p1.siteid = $siteId
            )";
        }
        
	if (count(Context::getRoleGroups()) > 0) {
            $page = Database::queryAsObject($query);
            if ($ensureAdminTemplate) {
                $page = self::ensureAdminTemplate($page);
            }
            return $page;
	}
        
	return null;
    }

    static function getPageByModuleId ($id, $lang) {
        
        $id = Database::escape($id);
        $lang = Database::escape($lang);
        $siteId = Context::getSiteId();
        $query = "select p.id, p.codeid as codeid, t.css, t.html, t.js, p.id, p.type, m.parent, m.position, m.active, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.description, p.template, t.template as templateinclude, t.interface as interface, p.pagetrackerscript 
            from t_page p
            left join t_templatearea a on a.id = '$id'
            left join t_template t on p.template = t.id
            left join t_menu as m on p.id = m.page and lang = '$lang'
            left join t_code as c on p.namecode = c.code and c.lang = '$lang'
            where p.id = a.pageid";
        $result = Database::queryAsObject($query);
        return self::ensureAdminTemplate($result);
    }

    static function createPage ($name,$type,$lang,$welcome,$title,$keywords,$template,$areas,$description,$code="") {
        $type = Database::escape($type);
        $lang = Database::escape($lang);
        $welcome = Database::escape($welcome);
        $title = Database::escape($title);
        $keywords = Database::escape($keywords);
        $template = Database::escape($template);
        $description = Database::escape($description);
        $code = Database::escape($code);
        $site = DomainsModel::getCurrentSite();
        if (empty($site)) {
            $siteId = 1;
        } else {
            $siteId = DomainsModel::getCurrentSite()->siteid;
        }
        // create name code
        $codeModel = new CodeModel();
        $namecode = $codeModel->createCode($lang,$name);
        // create page
        Database::query("insert into t_page(namecode,type,title,keywords,template,description,siteid,code) values('$namecode','$type','$title','$keywords','$template','$description','$siteId','$code')");
        $result = Database::queryAsObject("select last_insert_id() as max from t_page");
        $pageId = $result->max;
        PagesModel::setWelcome($pageId, $welcome);
        // create template areas
        return $pageId;
    }

    static function updatePage ($id,$name,$type,$lang,$welcome,$title,$keywords,$description,$template) {
        $name = Database::escape($name);
        $id = Database::escape($id);
        $title = Database::escape($title);
        $keywords = Database::escape($keywords);
        $type = Database::escape($type);
        $description = Database::escape($description);
        
        // set page name
        $code = PagesModel::getPage($id,$lang);
        if ($code != null) {
            $code = $code->namecode;
        }
        $codeModel = new CodeModel();
        $codeModel->setCode($code,$lang,$name);
        
        // dont save template if null
        $templateSql = "";
        if ($template != null) {
            $template = Database::escape($template);
            $templateSql = ", template = '$template'";
        }
        
        $query = "update t_page set title = '$title', keywords = '$keywords', description = '$description', type = '$type' $templateSql where id = '$id'";
        Database::query($query);
        PagesModel::setWelcome($id,$welcome);
           
    }
    
    static function deletePage ($pageId) {
        $pageId = Database::escape($pageId);
        // delete from menu
        Database::query("delete from t_menu where page = '".$pageId."'");
        // delete page
        Database::query("delete from t_page where id = '".$pageId."'");
        // delete template areas
        TemplateModel::deleteTemplateAreas($pageId);
    }

    static function setWelcome ($id,$welcome) {
        if ($welcome == '1') {
            $siteId = DomainsModel::getCurrentSite()->siteid;
            $id = Database::escape($id);
            Database::query("update t_page set welcome = '0' where siteid = '$siteId'");
            Database::query("update t_page set welcome = '1' where siteid = '$siteId' and id = '$id'");
        }
    }
}

?>