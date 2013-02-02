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

        if (Context::hasRole("pages.edit")) {
            $this->printEditPage();
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
        $menu = isset($_GET["menu"]) ? $_GET["menu"] : "";
        $parent = isset($_GET["parent"]) ? $_GET["parent"] : "";
        $page = null;
        if ($id != "") {
            $page = PagesModel::getPage($id, Context::getLang(), false);
        }
        
        ?>
        <div class="panel">
            <div class="pageConfigBackBtn">
                <?php
                if (!Common::isEmpty($menu)) {
                    ?>
                    <button onclick="callUrl('<?php echo NavigationModel::createStaticPageLink("menu",array("action"=>"edit","menu"=>$menu,"parent"=>$parent)); ?>');">Back to Menu</button>
                    <?php
                }
                ?>
		<button onclick="callUrl('<?php echo NavigationModel::createPageLink($id); ?>');">Back to Page</button>
            </div>
            <hr/>
            <div id="accordion">
                <h3><a href="#section1">Page Configuration</a></h3>
                <div>
                    <?php
                    // InfoMessages::printInfoMessage("Here you can create a new page in the menu! the titel of the site Here you can create a new page in the menu! ");
                    ?>
                    <br/>
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
                    </form>
                </div>
                
                <h3><a href="#section2">Configure Page Roles</a></h3>
                <div>
                    <form method="post" action="<?php echo parent::link(array("action"=>"saveRoles","menu"=>$menu,"parent"=>$parent,"id"=>$id)); ?>">
                        <?php
                        InfoMessages::printInfoMessage("Please select the role groups that are required to view this page");
                        $allRoles = Common::toMap(RolesModel::getCustomRoles(),"id","name");
                        $pageRoles = Common::toMap(RolesModel::getPageRoles($page->id),"roleid","roleid");
                        ?>
                        <br/>
                        <?php
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
                
                <h3><a href="#section3">Configure Page Modules</a></h3>
                <div>

		<?php
		$areaNames = TemplateModel::getAreaNames($page);
		?>
		<div id="tabs">
			<ul>
			<?php
			foreach ($areaNames as $areaName) {
				?>
				<li><a href="#tabs_<?php echo $areaName; ?>"><?php echo $areaName; ?></a></li>
				<?php
			}
			?>
			</ul>
			<?php
			foreach ($areaNames as $areaName) {
				
				$modules = TemplateModel::getAreaModules($page->id, $areaName);
				?>
				<div id="tabs_<?php echo $areaName; ?>">
					<table width="100%"><tr>
					<td>ID</td>
					<td>Type</td>
					<td colspan='2'>Tools</td></tr>
					<?php
					foreach ($modules as $module) {
						?>
						<tr>
						<td><?php echo $module->id; ?></td>
						<td><?php echo $module->modulename; ?></td>
						<td><img src="resource/img/preferences.png" class="imageLink" onclick="callUrl('<?php echo NavigationModel::createModuleLink($module->id,array("action"=>"edit"),false); ?>');" /></td>
						<td><img src="resource/img/delete.png" class="imageLink" alt="" onclick="doIfConfirm('Wollen Sie wirklich dieses Modul l&ouml;schen?','<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"delete","id"=>$module->id),false); ?>');" /></td>
						</tr>
					<?php
					}
					?>
					</table>
				</div>
				<?php
				
			}
			?>
			</div>
			
                    <div class="alignRight">
                        <button class="btnSave" type="submit">Save</button>
                        <button class="btnBack">Abbrechen</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script type="text/javascript">
	$("#tabs").tabs();
        $(".btnSave").each(function (i,o) {
            $(o).button();
        });
        $(".btnBack").each(function (i,o) {
            $(o).button().click(function (e) {
                history.back();
                e.preventDefault();
            });
        });
        $("#accordion").accordion({
            autoHeight: false,
            navigation: true
        });
        $(".pageConfigBackBtn button").button();
        </script>
        <?php
    }
    
}
?>