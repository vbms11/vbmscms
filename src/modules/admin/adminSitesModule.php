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
                    $this->renderEditSiteView($_GET['id']);
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
        $actionName = "";
        if ($siteId != null) {
            $template = TemplateModel::getTemplate(siteId);
            $actionName = "save";
        }
        // edit
        ?>
        <div class="panel">
            <form id="<?php echo parent::alias("templatesForm"); ?>" action="<?php echo parent::link(array("action"=>$actionName,"id"=>$templateId)); ?>" method="post">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-1">Info</a></li>
                        <li><a href="#tabs-2">Editor</a></li>
                        <li><a href="#tabs-3">Styles</a></li>
                        <li><a href="#tabs-4">Scripts</a></li>
                        <li><a href="#tabs-5">Files</a></li>
                    </ul>
                    <div id="tabs-1">
                        <h3>Template Info</h3>
                        <table><tr><td>
                            Template Name:
                        </td><td>
                            <?php InputFeilds::printTextFeild("name", $template->name); ?>    
                        </td></tr><tr><td>
                             Template Path:
                        </td><td>
                            <?php InputFeilds::printTextFeild("include", $template->template); ?>
                        </td></tr><tr><td>
                            Template Inpterface:
                        </td><td>
                            <?php InputFeilds::printTextFeild("interface", $template->interface); ?>
                        </td></tr></table>
                    </div>
                    <div id="tabs-2">
                        <h3>Template Editor</h3>
                        <?php
                        $templateCssPath = ResourcesModel::createResourceLink("template/".Common::hash($templateId,false,false), "template.css");
                        InputFeilds::printHtmlEditor("html", $template->html,$templateCssPath,array("action"=>"template","id"=>$template->id));
                        ?>
                    </div>
                    <div id="tabs-3">
                        <h3>Template Styles</h3>
                        <?php
                        InputFeilds::printTextArea("css", $template->css,"expand",10);
                        ?>
                    </div>
                    <div id="tabs-4">
                        <h3>Template Scripts</h3>
                        <?php
                        InputFeilds::printTextArea("js",$template->js,"expand",10);
                        ?>
                    </div>
                    <div id="tabs-5">
                        <h3>Template Files</h3>
                        <div id="myelfinder" ></div>
                        <script>
                        $('#myelfinder').elfinder({
                            url : '<?php echo NavigationModel::createServiceLink("fileSystem", array("action"=>"template","id"=>$template->id)); ?>',
                            lang : 'en',
                            docked: true,
                            dialog : { width : 900, modal : true, title : 'elFinder - file manager for web' },
                            closeOnEditorCallback : true
                        })
                        $('#myelfinder').elfinder("open");
                        </script>
                    </div>
                </div>
                <hr/>
                <div class="alignRight">
                    <button id="btnSubmit" type='submit'>Save</button>
                    <button id="btnCacnel">Cancel</button>
                </div>
            </form>
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
                    <li><a href="#adminSitesTab">Sites</a></li>
                </ul>
                <div id="adminSitesTab">

                    <div class="alignRight">
                        <button id="btnCreateTemplate"><?php echo parent::getTranslation("admin.sites.create"); ?></button>
                    </div>

                    <?php
                    $customer = CmsCustomerModel::getCmsCustomer(Context::getUserId());
                    $sites = SiteModel::byCmscustomerid($customer->id);

                    if (!empty($sites)) {
                        
                        ?>
                        <table class="resultTable">
                        <thead><tr>
                            <td>ID</td>
                            <td>Name</td>
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
                        <div class="alignRight">
                            <button id="btnCreateTemplate"><?php echo parent::getTranslation("admin.sites.create"); ?></button>
                        </div>
                        <?php
                    }

                    ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        
        </script>
        <?php
    }
    
}

?>