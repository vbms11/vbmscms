<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");
require_once("modules/products/productsPageModel.php");

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
        Context::addRequiredScript("resource/js/jstree/jquery.jstree.js");
        ?>
        <div class="adminMenuAccordionDiv">
            <h3><?php echo parent::getTranslation("admin.menu.account"); ?></h3>
            <div>
                <?php
                $this->printAccountMenu();
                ?>
            </div>
            <h3><?php echo parent::getTranslation("admin.menu.pages"); ?></h3>
            <div>
                <?php
                $this->printPagesMenu();
                ?>
            </div>
            <h3><?php echo parent::getTranslation("admin.menu.templates"); ?></h3>
            <div>
                <?php
                $this->printTemplatesMenu();
                ?>
            </div>
            <h3><?php echo parent::getTranslation("admin.menu.modules"); ?></h3>
            <div>
                <ul>
                    <li>Installed</li>
                    <li>Avalibel</li>
                </ul>
            </div>
            <h3><?php echo parent::getTranslation("admin.menu.shop"); ?></h3>
            <div>
                <?php
                $this->printShopMenu();
                ?>
            </div>
            <h3><?php echo parent::getTranslation("admin.menu.statistics"); ?></h3>
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
                case "adminSites":
                case "adminDomains":
                case "adminPackage":
                case "adminMessages":
                    $activeIndex = 0;
                    break;
                case "adminPages":
                    $activeIndex = 1;
                    $selectedNode = $_SESSION['adminPageId'];
                    break;
                case "adminTemplates":
                    $activeIndex = 2;
                    break;
                case "adminModules":
                    $activeIndex = 3;
                    break;
                case "productGroups":
                    $activeIndex = 4;
                    break;
                case "adminStatistics":
                    $activeIndex = 5;
                    break;
            }
            ?>
            $(".adminMenuAccordionDiv").accordion({
                heightStyle: "fill",
                active : <?php echo $activeIndex; ?>
            });
        });
        </script>
        <?php
    }
    
    function printPagesMenu () {
        $menus = MenuModel::getMenuInstances();
        $pages = MenuModel::getPagesInMenu(Context::getSiteId(),false);
        ?>
        <div class="adminMenuPagesDiv">
            <ul>
            <?php
            foreach ($menus as $menu) {
                $liClass = count($pages[$menu->id]) > 0 ? "jstree-open" : "";
                ?>
                <li class="adminNodeEditorMenu <?php echo $liClass; ?>" id="menu_<?php echo $menu->id; ?>">
                    <a href="#"><?php echo $menu->name ?></a>
                    <?php 
                    if (isset($pages[$menu->id])) {
                        $this->printMenu($pages[$menu->id]); 
                    }
                    ?>
                </li>
                <?php
            }
            ?>
            </ul>
        </div>
        <script>
        $(function() {
            $(".adminMenuPagesDiv").jstree({ 
                "plugins" : ["themes","html_data","ui"] 
            }).bind("select_node.jstree", function (event, data) {
                if (data.rslt.obj.hasClass("adminNodeEditorMenu")) {
                    var id = data.rslt.obj.attr("id").substring(5);
                    callUrl("<?php echo parent::staticLink("adminMenus", array("action"=>"editMenu","setAdminMode"=>"adminMenus"));?>&adminMenuId="+id);
                } else if (data.rslt.obj.hasClass("adminNodeEditorPage")) {
                    var id = data.rslt.obj.attr("id").substring(5);
                    callUrl("<?php echo parent::staticLink("adminPages", array("action"=>"editPage","setAdminMode"=>"adminPages"));?>&adminPageId="+id);
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
            <li class="adminNodeEditorPage <?php echo $liClass; ?>" id="page_<?php echo $page->page->id; ?>">
                <a class="<?php echo $aClass; ?>" href="#">
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
    
    function printShopMenu () {
        $liGroupsClass = isset($_GET['adminGroupId']) || isset($_GET['adminProductId']) ? "jstree-open" : "";
        ?>
        <div class="adminMenuShopDiv">
            <ul>
                <li class="adminNodeEditorProductGroups <?php echo $liGroupsClass; ?>">
                    <a href="#"><?php echo parent::getTranslation("admin.menu.products"); ?></a>
                    <ul>
                        <?php 
                        $productGroups = ProductsPageModel::getGroups();
                        foreach ($productGroups as $productGroup) {
                            $liGroupClass = "";
                            $aGroupClass = "";
                            if (isset($_GET['adminGroupId']) && $_GET['adminGroupId'] == $productGroup->id) {
                                $liGroupClass = "jstree-open";
                                if (!isset($_GET['adminProductId'])) {
                                    $aGroupClass = "jstree-clicked";
                                }
                            }
                            ?>
                            <li class="adminNodeEditorProductGroup <?php echo $liGroupClass; ?>" id="productGroup_<?php echo $productGroup->id; ?>">
                                <a href="#" class="<?php echo $aGroupClass; ?>"><?php echo $productGroup->name; ?></a>
                                <?php
                                $this->printProducts($productGroup->id);
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
        <script>
        $(function() {
            // shop tree
            $(".adminMenuShopDiv").jstree({ 
                "plugins" : ["themes","html_data","ui"] 
            }).bind("select_node.jstree", function (event, data) {
                if (data.rslt.obj.hasClass("adminNodeEditorProductGroups")) {
                    callUrl("<?php echo parent::staticLink("productGroups", array("setAdminMode"=>"productGroups")); ?>");
                } else if (data.rslt.obj.hasClass("adminNodeEditorProductGroup")) {
                    var id = data.rslt.obj.attr("id").substring(13);
                    callUrl("<?php echo parent::staticLink("productGroups", array("setAdminMode"=>"productGroups")); ?>&adminGroupId="+id+"&parent="+id);
                } else if (data.rslt.obj.hasClass("adminNodeEditorProduct")) {
                    var id = data.rslt.obj.attr("id").substring(8);
                    var group = data.rslt.obj.parents("li.adminNodeEditorProductGroup").attr("id").substring(13);
                    callUrl("<?php echo parent::staticLink("productGroups", array("action"=>"editProduct","setAdminMode"=>"productGroups")); ?>&adminProductId="+id+"&adminGroupId="+group+"&id="+id+"&parent="+group);
                }
            });
        });
        </script>
        <?php
    }
    
    function printProducts ($productGroup) {
        $products = ProductsPageModel::getProducts($productGroup);
        if (!empty($products)) {
            echo '<ul>';
            foreach ($products as $product) {
                $liClass = "";
                $aClass = "";
                if (isset($_GET['adminProductId']) && $product->id == $_GET['adminProductId']) {
                     $aClass = "jstree-clicked";
                }
                ?>
                <li class="adminNodeEditorProduct <?php echo $liClass; ?>" id="product_<?php echo $product->id; ?>">
                    <a class="<?php echo $aClass; ?>" href="#">
                        <?php echo $product->titel; ?>
                    </a>
                </li>
                <?php
            }
            echo '</ul>';
        }
    }
    
    function printAccountMenu () {
        ?>
        <div class="adminMenuAccountDiv">
            <ul>
                <li id="adminSites"><a href=""><?php echo parent::getTranslation("admin.menu.account.sites"); ?></a></li>
                <li id="adminDomains"><a href=""><?php echo parent::getTranslation("admin.menu.account.domains"); ?></a></li>
                <li id="adminPackage"><a href=""><?php echo parent::getTranslation("admin.menu.account.package"); ?></a></li>
                <li id="adminMessages"><a href=""><?php echo parent::getTranslation("admin.menu.account.messages"); ?></a></li>
            </ul>
        </div>
        <script>
        $(function() {
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
    
    function printTemplatesMenu () {
        $siteTemplates = TemplateModel::getTemplates(Context::getSiteId());
        ?>
        <div class="adminMenuTemplatesDiv">
            <ul>
                <li><a href="#"><?php echo parent::getTranslation("admin.menu.template.installed"); ?></a>
                    <ul>
                    <?php
                    foreach ($siteTemplates as $siteTemplate) {
                        ?>
                        <li class="" id="template_<?php echo $siteTemplate->id; ?>">
                            <a href="#"><?php echo $siteTemplate->name; ?></a>
                        </li>
                        <?php
                    }
                    ?>
                    </ul>
                </li>
                <li><a href="#"><?php echo parent::getTranslation("admin.menu.template.customize"); ?></a></li>
                <li><a href="#"><?php echo parent::getTranslation("admin.menu.template.available"); ?></a></li>
            </ul>
        </div>
        <script>
        $(function() {
            $(".adminMenuTemplatesDiv").jstree({ 
                "plugins" : ["themes","html_data","ui"] 
            }).bind("select_node.jstree", function (event, data) {
                data.rslt.obj.attr("id");
            });
        });
        </script>
        <?php
    }
}
?>