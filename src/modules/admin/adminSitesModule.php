<?php

require_once 'core/plugin.php';
include_once 'core/model/cmsCustomerModel.php';
include_once 'core/model/sitesModel.php';

class AdminSitesModule extends XModule {
    
    function onProcess () {
        
        if (Context::hasRole("template.edit")) {
            switch (parent::getAction()) {
                case "add":
                    $site = DomainsModel::getCurrentSite();
                    TemplateModel::addTemplate($site->siteid, $_GET['id']);
                    parent::redirect();
                    break;
                case "save":
                    $site = DomainsModel::getCurrentSite();
                    TemplateModel::saveTemplate($_GET['id'], $_POST['name'], $_POST['include'], $_POST['interface'], $_POST['html'], $_POST['js'], $_POST['css']);
                    parent::redirect();
                    break;
                case "create":
                    $templateId = TemplateModel::createTemplate($_POST['name'], $_POST['include'], $_POST['interface']);
                    parent::redirect(array("action"=>"editTemplate","id"=>$templateId));
                    break;
                case "remove":
                    $site = DomainsModel::getCurrentSite();
                    TemplateModel::removeTemplate($site->siteid, $_GET['id']);
                    parent::redirect();
                    break;
            }
        }
    }
    
    function onView () {
        
        
        switch (parent::getAction()) {
            
            case "editSite":
                if (Context::hasRole("site.edit")) {
                    $this->renderEditSiteView(parent::get('id'));
                }
                break;
            case "edit":
            default:
                if (Context::hasRole("template.view")) {
                    $this->renderMainView();
                }
        }
    }
    
    function getStyles () {
        return array("css/admin.css");
    }
    
    function getRoles () {
        return array("template.edit","template.view");
    }
    
    function renderEditSiteView ($siteId = null) {
        
        ?>
        <div class="panel">
            
            <script>
            $("#tabs").tabs({
                collapsible: true
            });
            $("#btnSubmit").button(function(){
                $("#<?php echo parent::alias("templatesForm"); ?>").submit();
            });
            $("#btnCacnel").button(function(){
                history.back();
            });
            </script>
        </div>
        <?php
    }
    
    function renderMainView() {
        ?>
        <div class="panel adminSitesPanel">
            <div class="adminSitesTabs">
                <ul>
                    <li><a href="#adminSitesTab"><?php echo parent::getTranslation("admin.sites.tab.label"); ?></a></li>
                </ul>
                <div id="adminSitesTab">
                    
                    <h3><?php echo parent::getTranslation("admin.sites.title"); ?></h3>
                    
                    <?php
                    $customer = CmsCustomerModel::getCmsCustomer(Context::getUserId());
                    $sites = SiteModel::byCmscustomerid($customer->id);

                    if (!empty($sites)) {
                        
                        ?>
                        <table class="resultTable" cellspacing="0">
                        <thead><tr>
                            <td>ID</td>
                            <td class="expand">Name</td>
                            <td colspan="2">Tools</td>
                        </tr></thead>
                        <tbody>
                        <?php
                        
                        foreach ($sites as $site) {
                            ?>
                            <tr>
                                <td><?php echo $site->id; ?></td>
                                <td><?php echo $site->name; ?></td>
                                <td><a>Edit</a></td>
                                <td><a>Delete</a></td>
                            </tr>
                            <?php
                        }
                        
                        ?>
                        </tbody></table>
                        <?php
                    }

                    ?>
                    
                    <hr/>
                    <div class="alignRight">
                        <button class="btnCreateSite"><?php echo parent::getTranslation("admin.sites.create"); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".adminSitesTabs").tabs();
        $(".btnCreateSite").each(function (index,object) {
            $(object).button().click(function () {
                callUrl("<?php echo parent::link(); ?>");
            });
        });
        </script>
        <?php
    }
    
}

?>