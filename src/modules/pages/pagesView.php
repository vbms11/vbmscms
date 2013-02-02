<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");

class PagesView extends XModule {

    public $action;
    public $pageType;
    public $parent;
    public $pageName;
    public $menu;
    public $id;
    public $levels;
    public $welcome;
    public $pagekeywords;
    public $pagetitle;
    public $active;
    public $template;
    public $description;
    public $module;
    public $selectedPage;
    public $area;
    public $position;

    function onProcess ()  {

        if (Context::hasRole("pages.editmenu")) {

            $this->getRequestVars();
            $pagesModel = new PagesModel();
            $templateModel = new TemplateModel();
            
            parent::focus();
            
            switch (parent::getAction()) {
                case "createpage":
                    if ($this->parent == '')
                        $this->parent = null;
                    $newPageId = PagesModel::createPage($this->pageName, $this->pageType, Context::getLang(),$this->welcome,$this->pagetitle,$this->pagekeywords,$this->template,null,$this->description);
                    MenuModel::createPageInMenu($newPageId, $this->menu, $this->parent, Context::getLang());
                    MenuModel::setPageActivateInMenu($newPageId, $this->active, Context::getLang());
                    parent::redirect(array("action"=>"editpage","menu"=>$this->menu,"parent"=>$this->parent,"id"=>$newPageId));
                    break;
                case "deletepage":
                    PagesModel::deletePage($this->id);
                    parent::redirect(array("menu"=>$this->menu,"parent"=>$this->parent));
                    break;
                case "savepage":
                    PagesModel::updatePage($this->id, $this->pageName, $this->pageType, Context::getLang(), $this->welcome, $this->pagetitle, $this->pagekeywords, $this->description, $this->template, null);
                    MenuModel::updatePageInMenu($this->id, $this->menu, $this->parent, Context::getLang());
                    MenuModel::setPageActivateInMenu($this->id, $this->active, Context::getLang());
                    parent::redirect(array("action"=>"editpage","menu"=>$this->menu,"parent"=>$this->parent,"id"=>$this->id));
                    break;
                case "moveup":
                    $pages = MenuModel::getPagesInAllLangs($this->menu,$this->parent,false,Context::getLang());
                    for ($i=0; $i<count($pages); $i++) {
                        if ($pages[$i]->id == $this->id) {
                            if ($i != 0) {
                                MenuModel::setPagePosition($pages[$i]->id,$pages[$i-1]->position,Context::getLang());
                                MenuModel::setPagePosition($pages[$i-1]->id,$pages[$i]->position,Context::getLang());
                                break;
                            }
                        }
                    }
                    parent::redirect(array("menu"=>$this->menu,"parent"=>$this->parent));
                    break;
                case "movedown":
                    $pages = MenuModel::getPagesInAllLangs($this->menu,$this->parent,false,Context::getLang());
                    for ($i=count($pages)-1; $i>-1; $i--) {
                        if ($pages[$i]->id == $this->id) {
                            if (count($pages)-1 > $i) {
                                MenuModel::setPagePosition($pages[$i]->id,$pages[$i+1]->position,Context::getLang());
                                MenuModel::setPagePosition($pages[$i+1]->id,$pages[$i]->position,Context::getLang());
                                break;
                            }
                        }
                    }
                    parent::redirect(array("menu"=>$this->menu,"parent"=>$this->parent));
                    break;
                case "saveRoles":
                    $roleGroups = $_POST['roleGroups'];
                    RolesModel::clearPageRoles($this->id);
                    if ($roleGroups != null) {
                        foreach ($roleGroups as $roleGroup) {
                            RolesModel::savePageRole($this->id, $roleGroup);
                        }
                    }
                    parent::redirect(array("action"=>"editpage","menu"=>$_GET['menu'],"parent"=>$_GET['parent'],"id"=>$_GET['id']));
                    break;
            }
        }

    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        if (Context::hasRole("pages.editmenu")) {

            $this->getRequestVars();

            switch (parent::getAction()) {
                case "newpage":
                    $this->printEditPage(parent::getId(), $this->menu, $this->parent, null);
                    break;
                case "editpage":
                    $this->printEditPage(parent::getId(), $this->menu, $this->parent, $this->id);
                    break;
                default:
                    break;
            }

            if (parent::getAction() == null) {
                $this->printListPages(parent::getId(), $this->menu, $this->parent);
            }
        }

        if (Context::hasRole("pages.edit")) {
            switch (parent::getAction()) {
                case "insertModule":
                    $this->printInsertModuleView(parent::getId(), $this->selectedPage, $this->area, $this->position);
                    break;
            }
        }
    }

    /**
     * called when module is installed
     */
    function install () {

    }

    /**
     * returns scripts used by this module
     */
    function getScripts () {

    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("pages.editmenu","pages.edit");
    }

    // module logic

    function getRequestVars () {

        $this->action = null; if (isset($_GET['action'])) $this->action = $_GET['action'];
        $this->pageType = null; if (isset($_POST['pagetype'])) $this->pageType = $_POST['pagetype'];
        $this->parent = null; if (isset($_GET['parent'])) $this->parent = $_GET['parent'];
        $this->pageName = null; if (isset($_POST['pagename'])) $this->pageName = $_POST['pagename'];
        $this->menu = null; if (isset($_GET['menu'])) $this->menu = $_GET['menu'];
        $this->id = null; if (isset($_GET['id'])) $this->id = $_GET['id'];
        $this->levels = null; if (isset($_GET['levels'])) $this->levels = $_GET['levels'];
        $this->welcome = null; if (isset($_POST['welcome'])) $this->welcome = $_POST['welcome'];
        $this->pagekeywords = null; if (isset($_POST['pagekeywords'])) $this->pagekeywords = $_POST['pagekeywords'];
        $this->pagetitle = null; if (isset($_POST['pagetitle'])) $this->pagetitle = $_POST['pagetitle'];
        $this->active = null; if (isset($_POST['active'])) $this->active = $_POST['active'];
        $this->template = null; if (isset($_POST['template'])) $this->template = $_POST['template'];
        $this->description = null; if (isset($_POST['pagedescription'])) $this->description = $_POST['pagedescription'];

        $this->selectedPage = null; if (isset($_GET['selectedPage'])) $this->selectedPage = $_GET['selectedPage'];
        $this->area = null; if (isset($_GET['area'])) $this->area = $_GET['area'];
        $this->position = null; if (isset($_GET['position'])) $this->position = $_GET['position'];

        if ($this->parent == '')
            $this->parent = null;
    }

    function printInsertModuleView($pageId, $selectedPage, $area, $position) {
        

        

    }

    function printEditPage ($pageId,$menu,$parent,$id) {

        $page;
        $action;
        
        $pageTypeModel = new ModuleModel();
        if ($id == null) {
            $page = new Page("","","","","","","","","","","","","");
            $action = "createpage";
        } else {
            $pagesModel = new PagesModel();
            $page = PagesModel::getPage($id, Context::getLang(), false);
            $action = "savepage";
        }

        $pageTypes = $pageTypeModel->getModulesInMenu();

        ?>
        <div class="panel">
            <?php
            if ($parent != null) {
                $parentPages = MenuModel::getPageParents($parent,Context::getLang());
                ?>
                <a class="pagesPathLink" href="<?php echo parent::link(array("menu"=>$menu,"parent"=>"")); ?>">Menu</a>
                <?php
                for ($i=count($parentPages)-1; $i>-1; $i--) {
                    if ($i - 1 < 0) $parentId = $parent;
                    else $parentId = $parentPages[$i-1]->parent;
                    ?>
                    <a class="pagesPathLink" href="<?php echo parent::link(array("menu"=>$menu,"parent"=>$parentId)); ?>"><?php echo $parentPages[$i]->name; ?></a>
                    <?php
                }
                ?>
                <br/><br/>
                <?php
            } else {
                ?>
                <a class="pagesPathLink" href="<?php echo parent::link(array("menu"=>$menu,"parent"=>"")); ?>">Back to Menu</a>
                <br/><br/>
                <?php
                
            }
            ?>
            <div id="accordion">
                <h3><a href="#section1">Page Configuration</a></h3>
                <div>
                    <?php
                    InfoMessages::printInfoMessage("Here you can create a new page in the menu! the titel of the site Here you can create a new page in the menu! ");
                    ?>
                    <br/>
                    <form method="post" action="<?php echo parent::link(array("action"=>$action,"menu"=>$menu,"parent"=>$parent,"id"=>$id)); ?>">

                        <table class="expand"><tr><td class="nowrap">
                            Name der Seite:
                        </td><td class="expand">
                            <input type="text" class="textbox" name="pagename" value="<?php echo $page->name; ?>" />
                        </td></tr><tr><td class="nowrap">
                            Titel der Seite:
                        </td><td class="expand">
                            <input type="text" class="textbox" name="pagetitle" value="<?php echo $page->title; ?>" />
                        </td></tr><tr><td class="nowrap">
                            Keywords:
                        </td><td class="expand">
                            <input type="text" class="textbox" name="pagekeywords" value="<?php echo $page->keywords; ?>" />
                        </td></tr><tr><td class="nowrap" valign="top">
                            Description:
                        </td><td class="expand">
                            <textarea class="expand" rows="3" cols="5" name="pagedescription" ><?php echo $page->description; ?></textarea>
                        </td></tr><tr><td>
                        </td><td class="expand">
                            <input type="checkbox" name="active" value="1" <?php if ($page->active) echo "checked='true'"; ?> />
                            Diese Seite im Men&uuml; in der aktiven Sprache anzeigen.
                        </td></tr><tr><td>
                        </td><td class="expand">
                            <input type="checkbox" name="welcome" value="1" <?php if ($page->welcome) echo "checked='true'"; ?> />
                            Diese Seite als Startseite festlegen.
                        </td></tr><tr><td class="nowrap">
                            Template
                        </td><td class="expand">
                            <?php
                            $valuesNames = array();
                            $site = DomainsModel::getCurrentSite();
                            foreach (TemplateModel::getTemplates($site->siteid) as $template) {
                                $valuesNames[$template->id] = $template->name;
                            }
                            echo InputFeilds::printSelect("template", $page != null ? $page->template : null, $valuesNames);
                            ?>
                        </td></tr><tr><td colspan="2" align="right">
                            <br/>
                            <hr/>
                            <input type="submit" value="Save" style="margin-left:6px;"/>
                            <button type="submit" onclick="history.back(); return false;">Abbrechen</button>
                        </td></tr></table>
                    </form>
                </div>
                <h3><a href="#section2">Configure page roles</a></h3>
                <div>
                    <form method="post" action="<?php echo parent::link(array("action"=>"saveRoles","menu"=>$menu,"parent"=>$parent,"id"=>$id)); ?>">
                        <?php
                        InfoMessages::printInfoMessage("Please select the role groups that are required to view this page");
                        $allRoles = array();
                        foreach (RolesModel::getCustomRoles() as $role) {
                            $allRoles[$role->id] = $role->name;
                        }
                        $pageRoles = array();
                        foreach (RolesModel::getPageRoles($page->id) as $role) {
                            $pageRoles[$role->roleid] = $role->roleid;
                        }
                        ?>
                        <br/>
                        <?php
                        InputFeilds::printMultiSelect("roleGroups",$allRoles,$pageRoles);
                        ?>
                        <br/>
                        <hr/>
                        <input type="submit" value="Save" />
                        <button type="submit" onclick="history.back(); return false;">Abbrechen</button>
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        $(function() {
            $( "#accordion" ).accordion({
                autoHeight: false,
                navigation: true
            });
        });
        </script>

        <?php
    }

    function printListPages ($pageId, $menu, $parent) {

        // list pages
        $level = 0;
        $pagesModel = new PagesModel();
        if ($parent == '')
            $parent = null;
        $pages = MenuModel::getPagesInAllLangs($menu,$parent,false,Context::getLang());
        if ($parent == null)
            $level = 1;
        
        ?>
        <div class="panel">
            <?php
            
            InfoMessages::printInfoMessage("Here you can edit the menu");
            echo "<br/>";
            if ($parent != null) {
                $parentPages = MenuModel::getPageParents($parent,Context::getLang());
                $level += count($parentPages) + 1;
                ?>
            
            <a class="pagesPathLink" href="<?php echo parent::link(array("menu"=>$menu,"parent"=>"")); ?>">Menu</a>
                <?php
                for ($i=count($parentPages)-1; $i>-1; $i--) {
                    if ($i - 1 < 0) $parentId = $parent;
                    else $parentId = $parentPages[$i-1]->parent;
                    ?>
                    <a class="pagesPathLink" href="<?php echo parent::link(array("menu"=>$menu,"parent"=>$parentId)); ?>"><?php echo $parentPages[$i]->name; ?></a>
                    <?php
                }
                ?>
                <br/><br/>
                <?php
            }
            ?>
            <a href="<?php echo parent::link(array("action"=>"newpage","menu"=>$menu,"parent"=>$parent)); ?>">Neue Seite erstellen</a>
            <br/><br/>

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
                            //if ($level < $_SESSION['levels']) {
                                ?>
                                <a href="<?php echo parent::link(array("menu"=>$menu,"parent"=>$pages[$i]->id)); ?>"><?php echo $name; ?></a>
                                <?php
                            //} else {
                            //    echo $name;
                            //}
                            ?>
                        </td>
                        <td class="resultTableCell"><a href="<?php echo NavigationModel::createPageLink($pages[$i]->id,array())?>"><img src="resource/img/view.png" class="imageLink" alt="" /></a></td>
                        <td class="resultTableCell"><a href="<?php echo parent::link(array("action"=>"editpage","menu"=>$menu,"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/preferences.png" class="imageLink" alt="" /></a></td>
                        <td class="resultTableCell"><a href="<?php echo parent::link(array("action"=>"movedown","menu"=>$menu,"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/movedown.png" class="imageLink" alt="" /></a></td>
                        <td class="resultTableCell"><a href="<?php echo parent::link(array("action"=>"moveup","menu"=>$menu,"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/moveup.png" class="imageLink" alt="" /></a></td>
                        <td class="resultTableCell"><img src="resource/img/delete.png" class="imageLink" alt="" onclick="doIfConfirm('Wollen Sie wirklich diese Seite l&ouml;schen?','<?php echo parent::link(array("action"=>"deletepage","menu"=>$menu,"parent"=>$parent,"id"=>$pages[$i]->id),false); ?>');" /></td>
                    </tr>
                    <?php
                }
                ?>
                </table>
                <br/>
                <a href="<?php echo parent::link(array("action"=>"newpage","menu"=>$menu,"parent"=>$parent)); ?>">Neue Seite erstellen</a>
                <?php
            }
            ?>
        </div>
        <?php
    }
    
}
?>