<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");

class AdminPagesBaseModule extends XModule {

    function savePageAction () {
        
        // save page settings create page if new page
        if (empty($_GET['id'])) {
            if (empty($_GET['parent']))
                $_GET['parent'] = null;
            $newPageId = PagesModel::createPage($_POST['pagename'], "", Context::getLang(),isset($_POST['welcome']) ? "1" : "0",$_POST['pagetitle'],$_POST['pagekeywords'],$_POST['template'],null,$_POST['pagedescription']);
            MenuModel::createPageInMenu($newPageId, $_GET["menu"], $_GET["parent"], Context::getLang());
            MenuModel::setPageActivateInMenu($newPageId, $_POST['active'], Context::getLang());
            $_GET['id'] = $newPageId;
        } else {
            PagesModel::updatePage($_GET['id'], $_POST['pagename'], "", Context::getLang(),isset($_POST['welcome']) ? "1" : "0",$_POST['pagetitle'],$_POST['pagekeywords'],$_POST['pagedescription'],$_POST['template'],null);
            MenuModel::updatePageInMenu($_GET['id'], $_GET["menu"], $_GET["parent"], Context::getLang());
            MenuModel::setPageActivateInMenu($_GET['id'], $_POST['active'], Context::getLang());
        }
        
        // save page roles
        $roleGroups = $_POST['roleGroups'];
        RolesModel::clearPageRoles($_GET['id']);
        if ($roleGroups != null && count($roleGroups) > 0) {
            foreach ($roleGroups as $roleGroup) {
                RolesModel::savePageRole($_GET['id'], $roleGroup);
            }
        }
    }
    
    function deletePageAction () {
        
        PagesModel::deletePage($_GET['id']);
    }
    
    function movePageUpAction () {
        
        $pages = MenuModel::getPagesInAllLangs($_GET['menu'],$_GET['parent'],false,Context::getLang());
        for ($i=0; $i<count($pages); $i++) {
            if ($pages[$i]->id == $_GET['id']) {
                if ($i != 0) {
                    MenuModel::setPagePosition($pages[$i]->id,$pages[$i-1]->position);
                    MenuModel::setPagePosition($pages[$i-1]->id,$pages[$i]->position);
                    return;
                }
            }
        }
    }
                    
    function movePageDownAction () {
        
        $pages = MenuModel::getPagesInAllLangs($_GET['menu'],$_GET['parent'],false,Context::getLang());
        for ($i=count($pages)-1; $i>-1; $i--) {
            if ($pages[$i]->id == $_GET['id']) {
                if (count($pages)-1 > $i) {
                    MenuModel::setPagePosition($pages[$i]->id,$pages[$i+1]->position);
                    MenuModel::setPagePosition($pages[$i+1]->id,$pages[$i]->position);
                    return;
                }
            }
        }
    }
                    
    
    function printPageSettingsView ($page) {
        
        $allRoles = Common::toMap(RolesModel::getCustomRoles(),"id","name");
        $pageRoles = null;
        if (empty($page)) {
            $pageRoles = $allRoles;
        } else {
            $pageRoles = Common::toMap(RolesModel::getPageRoles($page->id),"roleid","roleid");
        }

        ?>
        <div class="pageSettingsView">
            <form method="post" action="<?php 
                echo parent::link(array("action"=>"savepage",
                    "menuModuleId"  => isset($_GET['menuModuleId']) ? $_GET['menuModuleId'] : '',
                    "menu"          => empty($page) ? "" : $page->menuid,
                    "parent"        => empty($page) ? "" : $page->parent,
                    "id"            => empty($page) ? "" : $page->id)); 
                ?>">

                <table class="formTable"><tr><td>
                    Name der Seite:
                </td><td>
                    <input type="text" name="pagename" value="<?php echo $page == null ? "" : $page->name; ?>" />
                </td></tr><tr><td>
                    Titel der Seite:
                </td><td>
                    <input type="text" name="pagetitle" value="<?php echo $page == null ? "" : $page->title; ?>" />
                </td></tr><tr><td>
                    Keywords:
                </td><td>
                    <input type="text" name="pagekeywords" value="<?php echo $page == null ? "" : $page->keywords; ?>" />
                </td></tr><tr><td>
                    Description:
                </td><td>
                    <textarea rows="3" cols="5" name="pagedescription" ><?php echo $page == null ? "" : $page->description; ?></textarea>
                </td></tr><tr><td>
                    Template:
                </td><td class="expand">
                    <?php
                    if (empty($page)) {
                        $defaultTemplate = TemplateModel::getMainTemplate(Context::getSiteId());
                        $template = $defaultTemplate->id;
                    } else {
                        $template = $page->template;
                    }
                    $valuesNames = Common::toMap(TemplateModel::getTemplates(DomainsModel::getCurrentSite()->siteid),"id","name");
                    InputFeilds::printSelect("template",  $template, $valuesNames);
                    ?>
                </td></tr><tr><td>
                </td><td>
                    <input type="checkbox" name="active" value="1" <?php echo ($page != null && $page->active) ? "checked='true'" : ""; ?> />
                    Diese Seite im Men&uuml; in der aktiven Sprache anzeigen.
                </td></tr><tr><td>
                </td><td>
                    <input type="checkbox" name="welcome" value="1" <?php echo ($page != null && $page->welcome) ? "checked='true'" : ""; ?> />
                    Diese Seite als Startseite festlegen.
                </td></tr><tr><td colspan="2">
                    <?php
                    InfoMessages::printInfoMessage("Please select the user groups that can view this page. By default all users can see the page.");
                    ?>
                </td></tr><tr><td>
                    User Role Groups: 
                </td><td>
                    <?php
                    InputFeilds::printMultiSelect("roleGroups",$allRoles,$pageRoles);
                    ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button class="btnSave" type="submit">Save</button>
                    <button class="btnBack">Abbrechen</button>
                </div>
                
            </form>
        </div>
        <script>
        $(".pageSettingsView button").button();
        </script>
        <?php
    }
    
    function printPageMenuView ($menuId, $pageId) {
        
        // get pages to be shown
        $pages = MenuModel::getPagesInAllLangs($menuId,$pageId,false,Context::getLang());
        
        ?>
        <div>
            <div class="alignLeft">
                <button class="newPageButton">Neue Seite erstellen</button>
            </div>
            <?php
            if (count($pages) > 0) {
                if (isset($_GET['parent']) && !empty($_GET['parent'])) {

                    $parentPages = MenuModel::getPageParents($_GET['parent'],Context::getLang());
                    ?>
                    <table><tr><td><td>
                    <a class="pagesPathLink" href="<?php echo parent::link(array("action"=>"edit","menu"=>$_GET['parent'],"parent"=>"")); ?>">Menu</a>
                    <?php
                    for ($i=count($parentPages)-1; $i>-1; $i--) {
                        if ($i - 1 < 0) $parentId = $parent;
                        else $parentId = $parentPages[$i-1]->parent;
                        ?>
                        <a class="pagesPathLink" href="<?php echo parent::link(array("action"=>"edit","menu"=>$_GET['parent'],"parent"=>$parentId)); ?>"><?php echo $parentPages[$i]->name; ?></a>
                        <?php
                    }
                    ?>
                    </td></tr></table>
                    <?php
                }
                ?>
                <table class="resultTable" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <td align="center">ID</td>
                        <td class="expand" align="center">Name</td>
                        <td align="center" colspan="5">Tools</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($pages as $page) {
                        ?>
                        <tr>
                            <td align="center"><?php echo $page->id; ?></td>
                            <td align="center">
                                <?php
                                $name = empty($page->name) ? "Bitte Name vergeben" : $page->name;
                                ?>
                                <a href="<?php echo parent::link(array("action"=>"edit","menu"=>$page->menuid,"parent"=>$page->id)); ?>"><?php echo $name; ?></a>
                            </td>
                            <td><a href="<?php echo NavigationModel::createPageLink($page->id,array("setAdminMode"=>"0")); ?>"><img src="resource/img/view.png" alt="" /></a></td>
                            <td><a href="<?php echo NavigationModel::createStaticPageLink("pageConfig",array("menu"=>$page->menuid,"parent"=>$page->parent,"id"=>$page->id,"menuModuleId"=>isset($_GET['menuModuleId']) ? $_GET['menuModuleId'] : '')); ?>"><img src="resource/img/preferences.png" alt="" /></a></td>
                            <td><a href="<?php echo parent::link(array("action"=>"movedown","menu"=>$page->menuid,"parent"=>$page->parent,"id"=>$page->id)); ?>"><img src="resource/img/movedown.png" alt="" /></a></td>
                            <td><a href="<?php echo parent::link(array("action"=>"moveup","menu"=>$page->menuid,"parent"=>$page->parent,"id"=>$page->id)); ?>"><img src="resource/img/moveup.png" alt="" /></a></td>
                            <td><img src="resource/img/delete.png" alt="" onclick="doIfConfirm('Wollen Sie wirklich diese Seite l&ouml;schen?','<?php echo parent::link(array("action"=>"deletepage","menu"=>$page->menuid,"parent"=>$page->parent,"id"=>$page->id),false); ?>');" /></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                </table>
                <div class="alignLeft" style="margin-top:10px">
                    <button class="newPageButton">Neue Seite erstellen</button>
                </div>
                <?php
            }
            ?>
            <script>
            $(".newPageButton").each(function (index,object) {
                $(object).button().click(function () {
                    callUrl("<?php echo NavigationModel::createStaticPageLink("pageConfig",array("menu"=>$page->menuid,"parent"=>$page->parent)); ?>");
                });
            })
            </script>
        </div>
        <?php
    }
    
    function printPageTemplateView () {
        ?>
        <h3>Configure Page Template</h3>
        <?php
    }
    
    function printPageContentView ($page) {
        
        ?>
        <h3>Configure Page Modules</h3>
        <?php
        
        $areaNames = TemplateModel::getAreaNames($page);
        foreach ($areaNames as $areaName) {
            ?>
            <fieldset>
                <legend><?php echo $areaName; ?></legend>
                <?php
                $modules = TemplateModel::getAreaModules($page->id, $areaName);
                ?>
                <div class="adminPagesModuleList">
                    <?php
                    foreach ($modules as $module) {
                        ?>
                        <div class="adminPagesModule">
                            <div class="adminPagesModuleTools">
                                <img src="resource/img/preferences.png" alt="" onclick="callUrl('<?php echo NavigationModel::createModuleLink($module->id,array("action"=>"edit"),false); ?>');" />
                                <img src="resource/img/delete.png" alt="" onclick="doIfConfirm('Wollen Sie wirklich dieses Modul l&ouml;schen?','<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"delete","id"=>$module->id),false); ?>');" />
                            </div>
                            <?php
                            $moduleClass = ModuleModel::getModuleClass($module);
                            ModuleModel::renderModuleObject($moduleClass,false);
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </fieldset>
            <?php
        }
    }
    
}
?>