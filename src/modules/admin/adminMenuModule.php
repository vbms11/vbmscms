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
                <?php
                $this->printModulesMenu();
                ?>
            </div>
            <h3><?php echo parent::getTranslation("admin.menu.shop"); ?></h3>
            <div>
                <?php
                $this->printShopMenu();
                ?>
            </div>
            <h3><?php echo parent::getTranslation("admin.menu.statistics"); ?></h3>
            <div>
                <?php
                $this->printStatisticsMenu();
                ?>
            </div>
        </div>
        <script>
        $(function() {
            <?php
            $activeIndex = 0;
            switch (Context::isAdminMode()) {
                case "adminSites":
                case "adminDomains":
                case "adminPackage":
                case "adminMessages":
                case "adminNewsletter":
                    $activeIndex = 0;
                    break;
                case "adminPages":
                case "adminMenus":
                    $activeIndex = 1;
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
                case "statistics":
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
                $liClass = "";
                if (isset($pages[$menu->id]) && count($pages[$menu->id]) > 0) {
                    $liClass = "jstree-open";
                }
                $aClass = "";
                if (isset($_GET['adminMenuId']) && $_GET['adminMenuId'] == $menu->id) {
                    $aClass = "jstree-clicked";
                }
                ?>
                <li class="adminNodeEditorMenu <?php echo $liClass; ?>" id="menu_<?php echo $menu->id; ?>">
                    <a href="#" class="<?php echo $aClass; ?>"><?php echo $menu->name ?></a>
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
                    callUrl("<?php echo parent::staticLink("adminMenus", array("action"=>"showEditMenu","setAdminMode"=>"adminMenus"));?>&adminMenuId="+id);
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
            $aClass = "";
            if ($page->page->id == $_SESSION['adminPageId'] && !isset($_GET['adminMenuId'])) {
                 $aClass = "jstree-clicked";
            }
            ?>
            <li class="adminNodeEditorPage <?php echo $liClass; ?>" id="page_<?php echo $page->page->id; ?>">
                <a class="<?php echo $aClass; ?>" href="#">
                    <?php echo $page->page->name; ?>
                </a>
                <?php
                if (isset($page->children)) {
                    $this->printMenu($page->children);
                }
                ?>
            </li>
            <?php
        }
        echo '</ul>';
    }
    
    function printModulesMenu () {
        $installedModules = ModuleModel::getModulesInMenu();
        $availableModules = ModuleModel::getAvailableModules();
        $installedModulesOpen = false;
        foreach ($installedModules as $module) {
            if (parent::get('adminModuleId') == $module->id) {
                $installedModulesOpen = true;
            }
        }
        $availableModulesOpen = false;
        foreach ($availableModules as $module) {
            if (parent::get('adminModuleId') == $module->id) {
                $availableModulesOpen = true;
            }
        }
        ?>
        <div class="adminMenuModulesDiv">
            <ul>
                <li class="<?php if ($installedModulesOpen) { echo "jstree-open"; } ?>">
                    <a href="#"><?php echo parent::getTranslation("admin.menu.modules.installed"); ?></a>
                    <ul>
                        <?php
                        foreach ($installedModules as $module) {
                            $aClass = "";
                            if (parent::get('adminModuleId') == $module->id) {
                                $aClass = "jstree-clicked";
                            }
                            ?>
                            <li id="module_<?php echo $module->id; ?>" class="adminNodeEditorModule">
                                <a href="#" class="<?php echo $aClass; ?>">
                                    <?php echo $module->name; ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <li class="<?php if ($availableModulesOpen) { echo "jstree-open"; } ?>">
                    <a href="#"><?php echo parent::getTranslation("admin.menu.template.available"); ?></a>
                    <ul>
                        <?php
                        foreach ($availableModules as $module) {
                            $aClass = "";
                            if (parent::get('adminModuleId') == $module->id) {
                                $aClass = "jstree-clicked";
                            }
                            ?>
                            <li id="module_<?php echo $module->id; ?>" class="adminNodeEditorModule">
                                <a href="#" class="<?php echo $aClass; ?>">
                                    <?php echo $module->name; ?>
                                </a>
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
            $(".adminMenuModulesDiv").jstree({ 
                "plugins" : ["themes","html_data","ui"] 
            }).bind("select_node.jstree", function (event, data) {
                if (data.rslt.obj.hasClass("adminNodeEditorModule")) {
                    var id = data.rslt.obj.attr("id").substring(7);
                    callUrl("<?php echo parent::staticLink("adminModules", array("action"=>"editModule","setAdminMode"=>"adminModules")); ?>&adminModuleId="+id+"&id="+id);
                }
            });
        });
        </script>
        <?php
    }
    
    function printStatisticsMenu () {
        $statisticMode = parent::get("adminStatisticMode");
        ?>
        <div class="adminMenuStatisticsDiv">
            <ul>
                <li id="adminStatisticsDay"><a class = "<?php if ($statisticMode == "day") { echo "jstree-clicked"; } ?>" href=""><?php echo parent::getTranslation("admin.menu.statistics.day"); ?></a></li>
                <li id="adminStatisticsWeek"><a class = "<?php if ($statisticMode == "week") { echo "jstree-clicked"; } ?>" href=""><?php echo parent::getTranslation("admin.menu.statistics.week"); ?></a></li>
                <li id="adminStatisticsMonth"><a class = "<?php if ($statisticMode == "month") { echo "jstree-clicked"; } ?>" href=""><?php echo parent::getTranslation("admin.menu.statistics.month"); ?></a></li>
                <li id="adminStatisticsYear"><a class = "<?php if ($statisticMode == "year") { echo "jstree-clicked"; } ?>" href=""><?php echo parent::getTranslation("admin.menu.statistics.year"); ?></a></li>
            </ul>
        </div>
        <script>
        $(function() {
            $(".adminMenuStatisticsDiv").jstree({ 
                "plugins" : ["themes","html_data","ui"] 
            }).bind("select_node.jstree", function (event, data) {
                switch (data.rslt.obj.attr("id")) {
                    case "adminStatisticsDay":
                        callUrl("<?php echo parent::staticLink("statistics",array("action"=>"day","setAdminMode"=>"statistics","adminStatisticMode"=>"day")); ?>");
                        break;
                    case "adminStatisticsWeek":
                        callUrl("<?php echo parent::staticLink("statistics",array("action"=>"week","setAdminMode"=>"statistics","adminStatisticMode"=>"week")); ?>");
                        break;
                    case "adminStatisticsMonth":
                        callUrl("<?php echo parent::staticLink("statistics",array("action"=>"month","setAdminMode"=>"statistics","adminStatisticMode"=>"month")); ?>");
                        break;
                    case "adminStatisticsYear":
                        callUrl("<?php echo parent::staticLink("statistics",array("action"=>"year","setAdminMode"=>"statistics","adminStatisticMode"=>"year")); ?>");
                        break;
                }
            });
        });
        </script>
        <?php
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
        $countNewMessages = VirtualDataModel::getCountViewed('0');
        ?>
        <div class="adminMenuAccountDiv">
            <ul>
                <li id="adminSites"><a href=""><?php echo parent::getTranslation("admin.menu.account.sites"); ?></a></li>
                <li id="adminDomains"><a href=""><?php echo parent::getTranslation("admin.menu.account.domains"); ?></a></li>
                <li id="adminPackage"><a href=""><?php echo parent::getTranslation("admin.menu.account.package"); ?></a></li>
                <li id="adminMessages"><a href=""><?php echo parent::getTranslation("admin.menu.account.messages"); ?> (<?php echo $countNewMessages; ?>)</a></li>
                <li id="adminForms"><a href=""><?php echo parent::getTranslation("admin.menu.account.forms"); ?></a></li>
                <li id="adminNewsletter"><a href=""><?php echo parent::getTranslation("admin.menu.account.newsletter"); ?></a></li>
                <li id="adminTranslations"><a href=""><?php echo parent::getTranslation("admin.menu.account.translations"); ?></a></li>
                <li id="adminUsers"><a href=""><?php echo parent::getTranslation("admin.menu.account.users"); ?></a></li>
                <li id="adminRoles"><a href=""><?php echo parent::getTranslation("admin.menu.account.roles"); ?></a></li>
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
                    case "adminForms":
                        callUrl("<?php echo parent::staticLink("configTables"); ?>");
                        break;
                    case "adminNewsletter":
                        callUrl("<?php echo parent::staticLink("adminNewsletter"); ?>");
                        break;
                    case "adminTranslations":
                        callUrl("<?php echo parent::staticLink("adminTranslations"); ?>");
                        break;
                    case "adminUsers":
                        callUrl("<?php echo parent::staticLink("adminUsers"); ?>");
                        break;
                    case "adminRoles":
                        callUrl("<?php echo parent::staticLink("adminRoles"); ?>");
                        break;
                }
            });
        });
        </script>
        <?php
    }
    
    function printTemplatesMenu () {
        $siteTemplates = TemplateModel::getTemplates(Context::getSiteId());
        $siteTemplatesOpen = false;
        foreach ($siteTemplates as $siteTemplate) {
            if (parent::get('adminTemplateId') == $siteTemplate->id) {
                $siteTemplatesOpen = true;
            }
        }
        ?>
        <div class="adminMenuTemplatesDiv">
            <ul>
                <li class="<?php if ($siteTemplatesOpen) { echo "jstree-open"; } ?>">
                    <a href="#"><?php echo parent::getTranslation("admin.menu.template.installed"); ?></a>
                    <ul>
                    <?php
                    foreach ($siteTemplates as $siteTemplate) {
                        $aClass = "";
                        if (parent::get('adminTemplateId') == $siteTemplate->id) {
                             $aClass = "jstree-clicked";
                        }
                        ?>
                        <li class="adminNodeEditorTemplate" id="template_<?php echo $siteTemplate->id; ?>">
                            <a href="#" class="<?php echo $aClass; ?>"><?php echo $siteTemplate->name; ?></a>
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
                if (data.rslt.obj.hasClass("adminNodeEditorTemplate")) {
                    var templateId = data.rslt.obj.attr("id").substring(9);
                    callUrl("<?php echo parent::staticLink("adminTemplates",array("action"=>"editTemplate")); ?>&adminTemplateId="+templateId+"&id="+templateId);
                }
            });
        });
        </script>
        <?php
    }
}
?>