<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");

class AdminMenuModule extends XModule {

    function onProcess ()  {
        
        switch (parent::getAction()) {
            default:
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        $this->printMenuView();
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("admin.edit");
    }

    function printMenuView () {
        $menus = MenuModel::getMenuInstances();
        $pages = MenuModel::getPagesInMenu(Context::getSiteId(),false);
        Context::addRequiredScript("resource/js/jstree/jquery.jstree.js");
        ?>
        <div class="adminMenuAccordionDiv">
            <h3>Account</h3>
            <div>
                <div class="adminMenuAccountDiv">
                    <ul>
                        <li id="adminSites"><a href="">Sites</a></li>
                        <li id="adminDomains"><a href="">Domains</a></li>
                        <li id="adminPackage"><a href="">Package</a></li>
                        <li id="adminMessages"><a href="">Messages</a></li>
                    </ul>
                </div>
            </div>
            <h3>Pages</h3>
            <div>
                <div class="adminMenuPagesDiv">
                    <ul>
                    <?php
                    foreach ($menus as $menu) {
                        $liClass = count($pages[$menu->id]) > 0 ? "jstree-open" : "";
                        ?>
                        <li class="adminNodeEditorMenu <?php echo $liClass; ?>" id="<?php echo $menu->id; ?>">
                            <a href="#"><?php echo $menu->name ?></a>
                            <?php $this->printMenu($pages[$menu->id]); ?>
                        </li>
                        <?php
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <h3>Templates</h3>
            <div>
                <ul>
                    <li>List item one</li>
                    <li>List item two</li>
                    <li>List item three</li>
                </ul>
            </div>
            <h3>Modules</h3>
            <div>
                <ul>
                    <li>List item one</li>
                    <li>List item two</li>
                    <li>List item three</li>
                </ul>
            </div>
            <h3>Shop</h3>
            <div>
                <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
            </div>
            <h3>Statistics</h3>
            <div>
                <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
            </div>
        </div>
        <script>
        $(function() {
            <?php
            $activeIndex = 0;
            $selectedNode = null;
            switch (Context::isAdminMode()) {
                case "adminPages":
                    $activeIndex = 1;
                    $selectedNode = $_SESSION['adminPageId'];
            }
            ?>
            $(".adminMenuAccordionDiv").accordion({
                heightStyle: "fill",
                active : <?php echo $activeIndex; ?>
            });
            $(".adminMenuPagesDiv").jstree({ 
                "plugins" : ["themes","html_data","ui"] 
            }).bind("select_node.jstree", function (event, data) {
                if (data.rslt.obj.hasClass("adminNodeEditorMenu")) {
                    callUrl("<?php echo parent::staticLink("adminMenus", array("action"=>"editMenu"));?>&adminMenuId="+data.rslt.obj.attr("id"));
                } else if (data.rslt.obj.hasClass("adminNodeEditorPage")) {
                    callUrl("<?php echo parent::staticLink("adminPages", array("action"=>"editPage"));?>&adminPageId="+data.rslt.obj.attr("id"));
                }
            });
            $(".adminMenuAccountDiv").jstree({ 
                "plugins" : ["themes","html_data","ui"] 
            }).bind("select_node.jstree", function (event, data) {
                switch (data.rslt.obj.attr("id")) {
                    case "adminSites":
                        callUrl("<?php echo parent::staticLink("adminSites"); ?>");
                        break;
                    case "adminDomains":
                        callUrl("<?php echo parent::staticLink("adminDomains"); ?>");
                        break;
                    case "adminPackage":
                        callUrl("<?php echo parent::staticLink("adminPackage"); ?>");
                        break;
                    case "adminMessages":
                        callUrl("<?php echo parent::staticLink("adminMessages"); ?>");
                        break;
                }
            });
        });
        </script>
        <?php
    }
    
    function printMenu ($menu) {
        echo '<ul>';
        foreach ($menu as $page) {
            $liClass = isset($page->children) && count($page->children) > 0 ? "jstree-open " : "";
            $aClass = $page->page->id == $_SESSION['adminPageId'] ? "jstree-clicked" : "";
            ?>
            <li class="adminNodeEditorPage <?php echo $liClass; ?>" id="<?php echo $page->page->id; ?>">
                <a class="<?php echo $aClass; ?>" href="<?php echo parent::staticLink("adminPages", array("action"=>"editPage","adminPageId"=>$page->page->id)); ?>">
                    <?php echo $page->page->name; ?>
                </a>
            </li>
            <?php
            if (isset($page->children)) {
                $this->printMenu ($page->children);
            }
        }
        echo '</ul>';
    }
}
?>