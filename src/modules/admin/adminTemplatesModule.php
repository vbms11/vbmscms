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
                    $site = DomainsModel::getCurrentSite();
                    // echo $_GET["id"]." - ".$_POST['name']." - ".$_POST['include']." - ".$_POST['interface']." - ".$_POST['html']." - ".$_POST['js']." - ".$_POST['css'];
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
            
            case "editTemplate":
                if (Context::hasRole("template.edit")) {
                    $this->renderEditTemplateView($_GET['id']);
                }
                break;
            case "listInstalledTemplate":
                
                break;
            
            case "previewInstalledTemplate":
                $this->renderPreviewInstalledTemplateView($_GET['id']);
                break;
            
            case "edit":
            case "availabel":
                break;
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
    
    function renderPreviewInstalledTemplateView ($templateId) {
        ?>
        <div class="panel">
            <div id="templatePreviewTabs">
                <ul>
                    <li><a href="#tabs-1">Preview</a></li>
                </ul>
                <div id="tabs-1">
                    <h3>Template Editor</h3>
                    <iframe src="<?php NavigationModel::createPreviewPageLink($templateId); ?>">
                    
                    
                    </iframe>

                    <?php
                    $templateCssPath = ResourcesModel::createResourceLink("template/".Common::hash($templateId,false,false), "template.css");
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
        
        $actionName = "";
        if ($templateId != null) {
            $template = TemplateModel::getTemplate($templateId);
            $actionName = "save";
        }
        // edit
        ?>
        <div class="panel">
            <form id="<?php echo parent::alias("templatesForm"); ?>" action="<?php echo parent::link(array("action"=>$actionName,"id"=>$templateId)); ?>" method="post">
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
                        $templateCssPath = ResourcesModel::createResourceLink("template/".Common::hash($templateId,false,false), "template.css");
                        InputFeilds::printHtmlEditor("html", $template->html,$templateCssPath,array("action"=>"template","id"=>$template->id));
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
                            docked: true,
                            dialog : { width : 900, modal : true, title : 'elFinder - file manager for web' },
                            closeOnEditorCallback : true
                        })
                        $('#myelfinder').elfinder("open");
                        </script>
                    </div>
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
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        ?>
        <div class="panel templatesPanel">
            <div>
                <div class="adminTableToolbar">
                    <button id="btnCreateTemplate">Create</button>
                    <button id="btnEditTemplate">Edit</button>
                    <button id="btnAddTemplate">Add</button>
                    <button id="btnRemoveTemplate">Remove</button>
                </div>
                <h3>Templates:</h3>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="templates"></table>
            </div>
        </div>
        <div id="selectTemplateDialog" title="Add Template">
            <?php 
            InfoMessages::printInfoMessage("templates.add.select");
            echo "<br/>";
            $templates = array();
            $allTemplates = TemplateModel::getTemplates();
            foreach ($allTemplates as $template) {
                $templates[$template->id] = $template->name;
            }
            InputFeilds::printSelect("template", null, $templates);
            ?>
        </div>
        <div id="newTemplateDialog" title="New Template">
            <form action="<?php echo parent::link(array("action"=>"create")); ?>" method="post" id="newTemplateDialogForm">
                <p>Create a new template by filling out the following feilds then click on 'Edit Template'</p>
                <table><tr><td>
                    Template Name:
                </td><td>
                    <?php InputFeilds::printTextFeild("name"); ?>    
                </td></tr><tr><td>
                     Template Path:
                </td><td>
                    <?php InputFeilds::printTextFeild("include"); ?>
                </td></tr><tr><td>
                    Template Inpterface:
                </td><td>
                    <?php InputFeilds::printTextFeild("interface"); ?>
                </td></tr></table>
            </form>
        </div>
        <script type="text/javascript">
        var userMessages = [
            <?php
            $site = DomainsModel::getCurrentSite();
            $messages = TemplateModel::getTemplates($site->siteid);
            $first = true;
            foreach ($messages as $message) {
                if (!$first)
                    echo ",";
                echo "['".Common::htmlEscape($message->id)."','".Common::htmlEscape($message->name)."','".Common::htmlEscape($message->template)."','".Common::htmlEscape($message->interface)."']";
                $first = false;
            }
            ?>
        ];
        
        var oTableTemplate = $('#templates').dataTable({
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 40, -1], [10, 20, 40, "All"]],
            "aaData": userMessages,
            "aoColumns": [
                {'sTitle':'ID'},
                {'sTitle':'Name'},
                {'sTitle':'Path'},
                {'sTitle':'Interface'}]
        });
        $("#templates tbody").click(function(event) {
            $(oTableTemplate.fnSettings().aoData).each(function (){
                $(this.nTr).removeClass('row_selected');
            });
            $(event.target.parentNode).addClass('row_selected');
        });
        $("#selectTemplateDialog").dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode",
            modal: true,
            buttons: {
                "Add": function() {
                    $(this).dialog("close");
                    callUrl("<?php echo NavigationModel::createModuleLink(parent::getId(), array("action"=>"add"),false); ?>",{"id":$("#template").val()});
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });
        $("#newTemplateDialog").dialog({
            autoOpen: false,
            show: "blind",
            hide: "explode",
            height: 300,
            width: 400,
            modal: true,
            buttons: {
                "Edit Template": function() {
                    $(this).dialog("close");
                    $("#newTemplateDialogForm").submit();
                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });
        // the button actions
        $("#btnAddTemplate").button().click(function () {
            $("#selectTemplateDialog").dialog("open");
        });
        $("#btnRemoveTemplate").button().click(function () {
            callUrl("<?php echo parent::link(array("action"=>"remove"),false) ?>",{"id":getSelectedRow(oTableTemplate)[0].childNodes[0].innerHTML});
        });
        $("#btnCreateTemplate").button().click(function () {
            $("#newTemplateDialog").dialog("open");
        });
        $("#btnEditTemplate").button().click(function () {
            callUrl("<?php echo parent::link(array("action"=>"editTemplate"),false) ?>",{"id":getSelectedRow(oTableTemplate)[0].childNodes[0].innerHTML});
        });
        </script>
        <?php
    }
    
}

?>