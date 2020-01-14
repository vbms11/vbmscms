<?php

require_once 'core/plugin.php';

class AdminTemplatesModule extends XModule {
    
    function onProcess () {
        
        if (Context::hasRole("template.edit")) {
            switch (parent::getAction()) {
                case "add":
                    $site = DomainsModel::getCurrentSite();
                    TemplateModel::addTemplate($site->siteid, $_GET['id']);
                    parent::redirect();
                    break;
                case "save":
                    TemplateModel::saveTemplate(parent::get("id"), parent::post("name"), parent::post("html"), parent::post("js"), parent::post("css"), parent::post("type"), parent::get("packId"));
                    parent::redirect(array("action"=>"editTemplate","id"=>parent::get("id")));
                    break;
                case "create":
                    $templateId = TemplateModel::createTemplate(parent::post("name"), null, null, null, parent::post("type"), parent::get("packId"));
                    parent::redirect(array("action"=>"editTemplate","id"=>$templateId));
                    break;
                case "remove":
                    $site = DomainsModel::getCurrentSite();
                    TemplateModel::removeTemplate($site->siteid, $_GET['id']);
                    parent::redirect();
                    break;
                case "createTemplatePack":
                    //if (Context::hasRole("template.createPack")) {
                    TemplateModel::createTemplatePack(parent::post("name"), parent::post("description"));
                    parent::redirect();
                    //}
                    break;
                case "deleteTemplatePack":
                    TemplateModel::deleteTemplatePack(parent::get("id"));
                    parent::redirect();
                    break;
                case "copyTemplatePack":
                    TemplateController::copyTemplatePack(parent::post("name"),parent::post("description"),parent::get("packId"));
                    parent::redirect();
                    break;
                case "switchTemplatePack":
                    TemplateController::switchTemplatePack(parent::get("packId"),Context::getSiteId());
                    parent::redirect();
                    break;
            }
        }
    }
    
    function onView () {
        
        
        switch (parent::getAction()) {
            
            case "editTemplate":
                if (Context::hasRole("template.edit")) {
                    $this->renderEditTemplateView(parent::get('id'));
                }
                break;
            case "listInstalledTemplate":
                
                break;
            
            case "previewInstalledTemplate":
                $this->renderPreviewInstalledTemplateView(parent::get('id'));
                break;
            
            case "edit":
            case "availabel":
                break;
            case "renderCopyTemplatePack":
                $this->renderCopyTemplatePack(parent::get("packId"));
                break;
            case "newTemplatePack":
                $this->renderNewTemplatePack();
                break;
            case "newTemplate":
                $this->renderNewTemplate(parent::get("packId"));
                break;
            default:
                if (Context::hasRole("template.view")) {
                    $this->renderMainView();
                }
        }
    }
    
    function getStyles () {
        return array("css/admin.css","css/templates.css");
    }
    
    function getRoles () {
        return array("template.edit","template.view");
    }
    
    function renderPreviewInstalledTemplateView ($templateId) {
        $template = TemplateModel::getTemplate($templateId);
        ?>
        <div class="panel">
            <div id="templatePreviewTabs">
                <ul>
                    <li><a href="#tabs-1">Preview</a></li>
                </ul>
                <div id="tabs-1">
                    <h3>Template Editor</h3>
                    <iframe src="<?php echo NavigationModel::createPreviewPageLink($templateId); ?>"></iframe>
                    <?php
                    $templateCssPath = Resource::createResourceLink("template/".$template->path, "template.css");
                    InputFeilds::printHtmlEditor("html", $template->html,$templateCssPath,array("action"=>"template","id"=>$template->id));
                    ?>
                </div>
            </div>
            <script>
            $("#templatePreviewTabs").tabs({
            });
            </script>
        </div>
        <?php
    }
    
    function renderEditTemplateView ($templateId = null) {
        
        Context::addRequiredScript("resource/js/elfinder/js/elfinder.min.js");
        Context::addRequiredStyle("resource/js/elfinder/css/elfinder.min.css");
        
        $template = TemplateModel::getTemplate($templateId);
        ?>
        <div class="panel">
            <form id="<?php echo parent::alias("templatesForm"); ?>" action="<?php echo parent::link(array("action"=>"save","id"=>$templateId)); ?>" method="post">
                <div id="tabs">
                    <ul>
                        <li><a href="#tabs-2">Editor</a></li>
                        <li><a href="#tabs-3">Styles</a></li>
                        <li><a href="#tabs-4">Scripts</a></li>
                        <li><a href="#tabs-5">Files</a></li>
                        <li><a href="#tabs-1">Info</a></li>
                    </ul>
                    <div id="tabs-2">
                        <h3>Template Editor</h3>
                        <?php
                        $templateCssPath = Resource::createResourceLink("template/".$template->path, "template.css");
                        InputFeilds::printHtmlEditor("html", $template->html,$templateCssPath."?rand=".rand(),array("action"=>"template","id"=>$template->id));
                        ?>
                    </div>
                    <div id="tabs-3">
                        <h3>Template Styles</h3>
                        <?php
                        InputFeilds::printTextArea("css", $template->css,"expand",20);
                        ?>
                    </div>
                    <div id="tabs-4">
                        <h3>Template Scripts</h3>
                        <?php
                        InputFeilds::printTextArea("js",$template->js,"expand",20);
                        ?>
                    </div>
                    <div id="tabs-5">
                        <h3>Template Files</h3>
                        <div id="myelfinder" ></div>
                        <script>
                        $('#myelfinder').elfinder({
                            url : '<?php echo NavigationModel::createServiceLink("fileSystem", array("action"=>"template","id"=>$template->id)); ?>',
                            lang : 'en',
                            docked: true
                        });
                        $('#myelfinder').elfinder("open");
                        </script>
                    </div>
                    <div id="tabs-1">
                        <h3>Template Info</h3>
                        <table><tr><td>
                            Name:
                        </td><td>
                            <?php InputFeilds::printTextFeild("name", $template->name); ?>
                        </td></tr><tr><td>
                            Type:
                        </td><td>
                            <?php InputFeilds::printSelect("type", $template->type, TemplateModel::getTemplateTypes()); ?>
                        </td></tr></table>
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
    
    function renderNewTemplate ($packId) {
        ?>
        <div class="panel createTemplatePackPanel">
            <h3><?php echo parent::getTranslation("template.create.title"); ?></h3>
            <p><?php echo parent::getTranslation("template.create.instructions"); ?></p>
            <form method="post" action="<?php echo parent::link(array("action"=>"create","packId"=>$packId)); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("template.create.name"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextFeild("name"); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("template.create.type"); ?>
                </td><td>
                    <?php echo InputFeilds::printSelect("type",null,TemplateModel::getTemplateTypes()); ?>
                </td></tr>
                </table>
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton" type="submit"><?php echo parent::getTranslation("template.create.submit"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function renderCopyTemplatePack ($packId) {
        ?>
        <div class="panel createTemplatePackPanel">
            <h3><?php echo parent::getTranslation("template.copy.title"); ?></h3>
            <p><?php echo parent::getTranslation("template.copy.instructions"); ?></p>
            <form method="post" action="<?php echo parent::link(array("action"=>"copyTemplatePack","packId"=>$packId)); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("template.copy.name"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextFeild("name"); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("template.copy.description"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextArea("description"); ?>
                </td></tr>
                </table>
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton" type="submit"><?php echo parent::getTranslation("template.copy.submit"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function renderNewTemplatePack () {
        ?>
        <div class="panel createTemplatePackPanel">
            <h3><?php echo parent::getTranslation("template.pack.title"); ?></h3>
            <p><?php echo parent::getTranslation("template.pack.instructions"); ?></p>
            <form method="post" action="<?php echo parent::link(array("action"=>"createTemplatePack")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("template.pack.name"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextFeild("name"); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("template.pack.description"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextArea("description"); ?>
                </td></tr>
                </table>
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton" type="submit"><?php echo parent::getTranslation("template.pack.submit"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function renderMainView() {
        
        $templatePacks = TemplateModel::getTemplatePacks();
        ?>
        <div class="panel templatePacksPanel">
            
            <div>
                <h3>Template Packs:</h3>
                <p>Here is a list of template packs that you can use on your website. Click use template pack to select.</p>
                <div class="templatePackToolbar">
                    <a class="jquiButton" href="<?php echo parent::link(array("action"=>"newTemplatePack")); ?>">Create Template Pack</a>
                </div>
            </div>
            <div>
                <?php
                foreach ($templatePacks as $pos => $templatePack) {
                    ?>
                    <div class="templatePack">
                        <div class="templatePackHeader">
                            <div class="templateSetTools">
                                <a href="<?php echo parent::link(array("action"=>"switchTemplatePack","packId"=>$templatePack->id)); ?>">Use Template</a>
                                <a href="<?php echo parent::link(array("action"=>"renderCopyTemplatePack","packId"=>$templatePack->id)); ?>">Copy Template</a>
                                <a href="<?php echo parent::link(array("action"=>"newTemplate","packId"=>$templatePack->id)); ?>">Create Template</a>
                                <a href="<?php echo parent::link(array("action"=>"deleteTemplatePack","id"=>$templatePack->id)); ?>">Delete Template Pack</a>
                            </div>
                            <h3>
                                <?php echo htmlspecialchars($templatePack->name); ?>    
                            </h3>
                        </div>
                        <div class="templatePackBody">
                            <?php
                            $templates = TemplateModel::getTemplatesByPack($templatePack->id);
                            foreach ($templates as $tPos => $template) {
                                $previewLink = NavigationModel::createTemplatePreviewLink($template->id);
                                
                                ?>
                                <div class="templatePreviewContainer">
                                    <div class="templatePreviewTitle">
                                        <?php echo htmlspecialchars($template->name); ?>
                                    </div>
                                    <div class="templatePreviewBody">
                                        <iframe class="templatePreviewIframe" src="<?php echo $previewLink; ?>"></iframe>
                                    </div>
                                    <div class="templatePreviewTools">
                                        <a href="<?php echo parent::link(array("action"=>"editTemplate","id"=>$template->id)); ?>" ><img src="resource/img/preferences.png" alt="" /></a>
                                        <a onclick='doIfConfirm("<?php echo parent::getTranslation("template.deleteConfigMessage"); ?>","<?php echo parent::link(array("action"=>"editTemplate","id"=>$template->id)); ?>");'><img src="resource/img/delete.png" alt="" /></a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <?php
    }
    
}

?>