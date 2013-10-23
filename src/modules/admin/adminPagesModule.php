<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");

class PageConfigModule extends XModule {

    function onProcess ()  {

        if (Context::hasRole("pages.editmenu")) {
            
            switch (parent::getAction()) {
                case "savepage":
                    if (Common::isEmpty($_GET['id'])) {
                        if (Common::isEmpty($_GET['parent']))
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
                    parent::focus();
                    parent::redirect(array("id"=>$_GET['id'],"menu"=>isset($_GET["menu"]) ? $_GET["menu"] : "","parent"=>isset($_GET["parent"]) ? $_GET["parent"] : ""));
                    break;
                case "saveRoles":
                    $roleGroups = $_POST['roleGroups'];
                    RolesModel::clearPageRoles($_GET['id']);
                    if ($roleGroups != null && count($roleGroups) > 0) {
                        foreach ($roleGroups as $roleGroup) {
                            RolesModel::savePageRole($_GET['id'], $roleGroup);
                        }
                    }
                    parent::focus();
                    parent::redirect(array("id"=>$_GET['id'],"menu"=>isset($_GET["menu"]) ? $_GET["menu"] : "","parent"=>isset($_GET["parent"]) ? $_GET["parent"] : ""));
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            default:
                if (Context::hasRole("pages.edit")) {
                    $this->printEditPage();
                }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("pages.editmenu","pages.edit");
    }

    function printEditPage () {
        
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $page = null;
        if ($id != "") {
            $page = PagesModel::getPage($id, Context::getLang(), false);
        }
        
        ?>
        <div id="adminPagesTabs">
            <ul>
                <li><a href="#tabs-1">Content</a></li>
                <li><a href="#tabs-2">Template</a></li>
                <li><a href="#tabs-3">Menu</a></li>
                <li><a href="#tabs-4">Settings</a></li>
            </ul>
            <div id="tabs-1">
                <?php $this->printPageContentView($page); ?>
            </div>
            <div id="tabs-2">
                <?php $this->printPageTemplateView($page); ?>
            </div>
            <div id="tabs-3">
                <?php $this->printPageMenuView($page); ?>
            </div>
            <div id="tabs-4">
                <?php $this->printPageSettingsView($page); ?>
            </div>
        </div>
        <?php
        
    }
    
    function printPageSettingsView ($page) {
        ?>
        <h3><a href="#section1">Page Configuration</a></h3>
        <div>
            <form method="post" action="<?php echo parent::link(array("action"=>"savepage","menu"=>$menu,"parent"=>$parent,"id"=>$id)); ?>">

                <table class="expand"><tr><td class="nowrap">
                    Name der Seite:
                </td><td class="expand">
                    <input type="text" class="textbox" name="pagename" value="<?php echo $page == null ? "" : $page->name; ?>" />
                </td></tr><tr><td class="nowrap">
                    Titel der Seite:
                </td><td class="expand">
                    <input type="text" class="textbox" name="pagetitle" value="<?php echo $page == null ? "" : $page->title; ?>" />
                </td></tr><tr><td class="nowrap">
                    Keywords:
                </td><td class="expand">
                    <input type="text" class="textbox" name="pagekeywords" value="<?php echo $page == null ? "" : $page->keywords; ?>" />
                </td></tr><tr><td class="nowrap" valign="top">
                    Description:
                </td><td class="expand">
                    <textarea class="expand" rows="3" cols="5" name="pagedescription" ><?php echo $page == null ? "" : $page->description; ?></textarea>
                </td></tr><tr><td>
                </td><td class="expand">
                    <input type="checkbox" name="active" value="1" <?php echo ($page != null && $page->active) ? "checked='true'" : ""; ?> />
                    Diese Seite im Men&uuml; in der aktiven Sprache anzeigen.
                </td></tr><tr><td>
                </td><td class="expand">
                    <input type="checkbox" name="welcome" value="1" <?php echo ($page != null && $page->welcome) ? "checked='true'" : ""; ?> />
                    Diese Seite als Startseite festlegen.
                </td></tr><tr><td class="nowrap">
                    Template
                </td><td class="expand">
                    <?php
                    $valuesNames = Common::toMap(TemplateModel::getTemplates(DomainsModel::getCurrentSite()->siteid),"id","name");
                    InputFeilds::printSelect("template", $page != null ? $page->template : null, $valuesNames);
                    ?>
                </td></tr><tr><td colspan="2" align="right">
                    <br/>
                    <hr/>
                    <button class="btnSave" type="submit">Save</button>
                    <button class="btnBack">Abbrechen</button>
                </td></tr></table>
            </div>
        
            <h3>Configure Page Roles</h3>
            <div>
                <?php
                InfoMessages::printInfoMessage("Please select the role groups that are required to view this page");
                $allRoles = Common::toMap(RolesModel::getCustomRoles(),"id","name");
                $pageRoles = Common::toMap(RolesModel::getPageRoles($page->id),"roleid","roleid");
                InputFeilds::printMultiSelect("roleGroups",$allRoles,$pageRoles);
                ?>
                <br/>
                <hr/>
                <div class="alignRight">
                    <button class="btnSave" type="submit">Save</button>
                    <button class="btnBack">Abbrechen</button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function printPageMenuView ($page) {
        
        // get pages to be shown
        $pages = MenuModel::getPagesInAllLangs($page->menuid,$page->id,false,Context::getLang());
        
        ?>
        <h3><a href="#section1">Configure Menu Pages</a></h3>
        <div>                    
            <div class="alignLeft">
                <button class="newPageButton">Neue Seite erstellen</button>
            </td>
            <?php
            if (count($pages) > 0) {
                ?>
                <table class="resultTable expand" cellspacing="0" border="0"><tr>
                    <td class="resultTableCell resultTableHeader" align="center">id</td>
                    <td class="resultTableCell resultTableHeader expand" align="center">Name</td>
                    <td class="resultTableCell resultTableHeader" align="center" colspan="5">Tools</td>
                </tr>
                <?php
                for ($i=0; $i<count($pages); $i++) {
                    ?>
                    <tr>
                        <td class="resultTableCell"><?php echo $pages[$i]->id; ?></td>
                        <td class="resultTableCell expand" align="center">
                            <?php
                            $name = ($pages[$i]->name == "") ? "Bitte Name vergeben" : $pages[$i]->name;
                            ?>
                            <a href="<?php echo parent::link(array("action"=>"edit","menu"=>parent::param("selectedMenu"),"parent"=>$pages[$i]->id)); ?>"><?php echo $name; ?></a>
                        </td>
                        <td class="resultTableCell"><a href="<?php echo NavigationModel::createPageLink($pages[$i]->id,array()); ?>"><img src="resource/img/view.png" class="imageLink" alt="" /></a></td>
                        <td class="resultTableCell"><a href="<?php echo NavigationModel::createStaticPageLink("pageConfig",array("menu"=>parent::param("selectedMenu"),"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/preferences.png" class="imageLink" alt="" /></a></td>
                        <td class="resultTableCell"><a href="<?php echo parent::link(array("action"=>"movedown","menu"=>parent::param("selectedMenu"),"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/movedown.png" class="imageLink" alt="" /></a></td>
                        <td class="resultTableCell"><a href="<?php echo parent::link(array("action"=>"moveup","menu"=>parent::param("selectedMenu"),"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/moveup.png" class="imageLink" alt="" /></a></td>
                        <td class="resultTableCell"><img src="resource/img/delete.png" class="imageLink" alt="" onclick="doIfConfirm('Wollen Sie wirklich diese Seite l&ouml;schen?','<?php echo parent::link(array("action"=>"deletepage","menu"=>parent::param("selectedMenu"),"parent"=>$parent,"id"=>$pages[$i]->id),false); ?>');" /></td>
                    </tr>
                    <?php
                }
                ?>
                </table>
                <div class="alignLeft">
                    <button class="newPageButton">Neue Seite erstellen</button>
                </div>
                <?php
            }
            ?>
            <script>
            $(".newPageButton").each(function (index,object) {
                $(object).button().click(function () {
                    callUrl("<?php echo NavigationModel::createStaticPageLink("pageConfig",array("menu"=>parent::param("selectedMenu"),"parent"=>$parent)); ?>");
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
    
    function printPageContentView ($pageId) {
        
        ?>
        <h3>Configure Page Modules</h3>
        <?php
        
        $areaNames = TemplateModel::getAreaNames($page);
        foreach ($areaNames as $areaName) {
            ?>
            <fieldset title="<?php echo $areaName; ?>">
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
                            ModuleModel::renderModuleObject($module);
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