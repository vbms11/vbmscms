<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");

class AdminPagesBaseModule extends XModule {
    
    function newMenuAction () {
        return MenuModel::saveMenuInstance(null, parent::post('newMenuName'));
    }
    
    function editMenuAction () {
        MenuModel::saveMenuInstance(parent::get('id'), parent::post('editMenuName'));
    }
    
    function deleteMenuAction () {
        MenuModel::deleteMenuInstance($_GET['id']);
    }
    
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
    
    function selectTemplateAction () {
        $templates = TemplateModel::getTemplates(Context::getSiteId());
        $pageId = parent::get("id");
        $index = parent::get("index");
        if ($index !== null) {
            PagesModel::setPageTemplate($pageId,$templates[$index]->id);
        }
        Context::setReturnValue("setTemplate:".$index);
    }
    
    function printPageSettingsTabView () {
        ?>
        <div id="adminMenusTabs">
            <ul>
                <li><a href="#tabs-1"><?php echo parent::getTranslation("admin.pages.tab.settings"); ?></a></li>
            </ul>
            <div id="tabs-1">
                <?php $this->printPageSettingsView(); ?>
            </div>
        </div>
        <script>
        $("#adminMenusTabs").tabs();
        </script>
        <?php
    }
    
    function printPageSettingsView ($page = "") {
        
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
                    "menu"          => empty($page) ? $_GET['menu'] : $page->menuid,
                    "parent"        => empty($page) ? $_GET['parent'] : $page->parent,
                    "id"            => empty($page) ? "" : $page->id)); 
                ?>">

                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("admin.pages.config.name"); ?>
                </td><td>
                    <input type="text" name="pagename" value="<?php echo $page == null ? "" : $page->name; ?>" />
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("admin.pages.config.title"); ?>
                </td><td>
                    <input type="text" name="pagetitle" value="<?php echo $page == null ? "" : $page->title; ?>" />
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("admin.pages.config.keywords"); ?>
                </td><td>
                    <input type="text" name="pagekeywords" value="<?php echo $page == null ? "" : $page->keywords; ?>" />
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("admin.pages.config.description"); ?>
                </td><td>
                    <textarea rows="3" cols="5" name="pagedescription" ><?php echo $page == null ? "" : $page->description; ?></textarea>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("admin.pages.config.template"); ?>
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
                    <input type="checkbox" name="active" value="1" <?php echo ($page == null || $page->active) ? "checked='true'" : ""; ?> />
                    <?php echo parent::getTranslation("admin.pages.config.display"); ?>
                </td></tr><tr><td>
                </td><td>
                    <input type="checkbox" name="welcome" value="1" <?php echo ($page != null && $page->welcome) ? "checked='true'" : ""; ?> />
                    <?php echo parent::getTranslation("admin.pages.config.startpage"); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("admin.pages.config.roles"); ?> 
                </td><td>
                    <?php
                    InputFeilds::printMultiSelect("roleGroups",$allRoles,$pageRoles);
                    ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button class="btnSave" type="submit"><?php echo parent::getTranslation("admin.pages.config.save"); ?></button>
                    <button class="btnBack"><?php echo parent::getTranslation("admin.pages.config.cancel"); ?></button>
                </div>
                
            </form>
        </div>
        <script>
        $(".pageSettingsView button").button();
        </script>
        <?php
    }
    
    function printPageMenuView ($menuId, $parentId) {
        
        // get pages to be shown
        $pages = MenuModel::getPagesInAllLangs($menuId,$parentId,false,Context::getLang());
        // $parent = isset($_GET['parent']) ? $_GET['parent'] : null;
        
        ?>
        <div>
            <div class="alignLeft">
                <button class="newPageButton"><?php echo parent::getTranslation("admin.pages.menu.new"); ?></button>
            </div>
            <?php
            if (count($pages) > 0) {
                if (!empty($parent)) {

                    $parentPages = MenuModel::getPageParents($parent,Context::getLang());
                    ?>
                    <table><tr><td><td>
                    <a class="pagesPathLink" href="<?php echo parent::link(array("action"=>"edit","menu"=>$menuId,"parent"=>"")); ?>"><?php echo parent::getTranslation("admin.pages.menu.menu"); ?></a>
                    <?php
                    for ($i=count($parentPages)-1; $i>-1; $i--) {
                        if ($i - 1 < 0) $parentId = $parent;
                        else $parentId = $parentPages[$i-1]->parent;
                        ?>
                        <a class="pagesPathLink" href="<?php echo parent::link(array("action"=>"edit","menu"=>$menuId,"parent"=>$parentId)); ?>"><?php echo $parentPages[$i]->name; ?></a>
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
                        <td align="center"><?php echo parent::getTranslation("admin.pages.menu.id"); ?></td>
                        <td class="expand" align="center"><?php echo parent::getTranslation("admin.pages.menu.name"); ?></td>
                        <td align="center" colspan="5"><?php echo parent::getTranslation("admin.pages.menu.tools"); ?></td>
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
                            <td><img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("admin.pages.menu.confirm.delete"); ?>','<?php echo parent::link(array("action"=>"deletepage","menu"=>$page->menuid,"parent"=>$page->parent,"id"=>$page->id),false); ?>');" /></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                </table>
                <div class="alignLeft" style="margin-top:10px">
                    <button class="newPageButton"><?php echo parent::getTranslation("admin.pages.menu.new"); ?></button>
                </div>
                <?php
            }
            ?>
            <script>
            $(".newPageButton").each(function (index,object) {
                $(object).button().click(function () {
                    callUrl("<?php echo parent::link(array("action"=>"createPage","menu"=>$menuId,"parent"=>$parentId,"menuModuleId"=>isset($_GET['menuModuleId']) ? $_GET['menuModuleId'] : "")); ?>");
                });
            })
            </script>
        </div>
        <?php
    }
    
    function printPageTemplateView ($page) {
        $selectedTemplate = $page->template;
        $templates = TemplateModel::getTemplates(DomainsModel::getCurrentSite()->siteid);
        ?>
        <h3><?php echo parent::getTranslation("admin.pages.template.title"); ?></h3>
        <div class="templateBoxContainer">
            <?php
            foreach ($templates as $template) {
                $templatePreviedSrc = NavigationModel::createTemplatePreviewLink($template->id);
                $selectedClass = "";
                if ($selectedTemplate == $template->id) {
                    $selectedClass = "ui-selected";
                }
                ?>
                <div class="templatesToggelBox <?php echo $selectedClass; ?>">
                    <div class="templateToggelBoxDiv"></div>
                    <iframe class="templateToggelBoxIframe" src="<?php echo $templatePreviedSrc; ?>"></iframe>
                </div>
                <?php
            }
            ?>
            <div class="clear"></div>
        </div>
        <script>
        $(".templateBoxContainer").selectable({ 
            filter: ".templatesToggelBox",
            start: function () {
                $(this).each(function (index, object) {
                    $(object).removeClass("ui-selected");
                });
            }, stop: function() {
                var index = $(".templateBoxContainer .templatesToggelBox").index(
                        $(".templateBoxContainer .ui-selected"));
                ajaxRequest("<?php echo parent::ajaxLink(array("action"=>"selectTemplate","id"=>$page->id)) ?>", null, {"index":index});
            }
        });
        $(".templateToggelBoxDiv").click(function(){
            $(this).parent().click();
        })
        </script>
        <?php
    }
    
    function printPageContentView ($page) {
        
        ?>
        <h3><?php echo parent::getTranslation("admin.pages.modules.title"); ?></h3>
        <?php
        
        $areaNames = TemplateModel::getAreaNames($page);
        foreach ($areaNames as $areaName) {
            ?>
            <fieldset>
                <legend>
                    <?php echo $areaName; ?>
                    <a class="toolButtonSpacinng" href="<?php echo NavigationModel::createStaticPageLink("insertModule",array("action"=>"insertModule","selectedPage"=>$_SESSION['adminPageId'],"area"=>$areaName,"position"=>-1)); ?>">
                        <img src="resource/img/new.png" class="imageLink" alt="" title="<?php echo parent::getTranslation("admin.pages.module.new"); ?>" />
                    </a>
                </legend>
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
                                <img src="resource/img/moveup.png" alt="" onclick="callUrl('<?php echo NavigationModel::createPageLink($page->id,array("action"=>"moveup","id"=>$module->id),false); ?>');" />
                                <img src="resource/img/movedown.png" alt="" onclick="callUrl('<?php echo NavigationModel::createPageLink($page->id,array("action"=>"movedown","id"=>$module->id),false); ?>');" />
                                <img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("admin.pages.modules.delete.confirm"); ?>','<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"delete","id"=>$module->id),false); ?>');" />
                            </div>
                            <?php
                            $moduleClass = ModuleModel::getModuleClass($module);
                            ModuleController::renderModuleObject($moduleClass,false);
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
    
    function printRenameMenuView ($menuId) {
        $menu = MenuModel::getMenuInstance($menuId);
        ?>
        <div id="edit-menu-dialog" title="Edit Menu">
            <form method="post" id="edit-menu-dialog-form" action="<?php echo parent::link(array("action"=>"editMenu","id"=>$menuId)); ?>">
                <table class="formTable"><tr>
                    <td><?php echo parent::getTranslation("admin.pages.menu.label.name"); ?></td>
                    <td>
                        <?php
                        InputFeilds::printTextFeild("editMenuName",$menu->name);
                        ?>
                    </td>
                </tr></table>
            </form>
        </div>
        <script>
        $("#edit-menu-dialog").dialog({
            autoOpen: false, height: 300, width: 350, modal: true,
            buttons: {
                "Save": function() {
                    $("#edit-menu-dialog-form").submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });
        </script>
        <?php
    }
    
    function printCreateMenuView () {
        ?>
        <div id="new-menu-dialog" title="New Menu">
            <form method="post" id="new-menu-dialog-form" action="<?php echo parent::link(array("action"=>"newMenu")); ?>">
                <table class="formTable"><tr>
                    <td><?php echo parent::getTranslation("admin.pages.menu.label.name"); ?></td>
                    <td>
                        <?php
                        InputFeilds::printTextFeild("newMenuName");
                        ?>
                    </td>
                </tr></table>
            </form>
        </div>
        <script>
        $("#new-menu-dialog").dialog({
            autoOpen: false, height: 300, width: 350, modal: true,
            buttons: {
                "Save": function() {
                    $("#new-menu-dialog-form").submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });
        </script>
        <?php
    }
    
}
?>