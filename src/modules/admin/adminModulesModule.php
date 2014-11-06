<?php

require_once 'core/plugin.php';

class AdminModulesModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "add":
                $site = DomainsModel::getCurrentSite();
                ModuleModel::addModule($site->siteid, $_GET['id']);
                break;
            case "remove":
                $site = DomainsModel::getCurrentSite();
                ModuleModel::removeModule($site->siteid, $_GET['id']);
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "editModule":
                $this->renderEditModuleTabs();
                break;
            default:
                $this->renderMainView();
        }
    }
    
    function renderEditModuleTabs () {
        ?>
        <div id="adminModulesTabs">
            <ul>
                <li><a href="#moduleConfigTab"><?php echo parent::getTranslation("admin.modules.tab.config"); ?></a></li>
                <li><a href="#moduleAttribsTab"><?php echo parent::getTranslation("admin.modules.tab.attribs"); ?></a></li>
            </ul>
            <div id="moduleConfigTab">
                <?php $this->renderModuleConfigView(); ?>
            </div>
            <div id="moduleAttribsTab">
                <?php $this->renderModuleAttributesView(); ?>
            </div>
        </div>
        <script>
        $("#adminModulesTabs").tabs();
        </script>
        <?php
    }
    
    function renderModuleConfigView () {
        $theModule = ModuleModel::getModule(parent::get("adminModuleId"));
        $theModule->typeid = $theModule->id;
        $theModule->id = null;
        $theModule->modulename = $theModule->name;
        $theModule->name = null;
        $theModule->position = null;
        $moduleObject = ModuleModel::getModuleClass($theModule);
        ModuleController::renderModule($moduleObject);
    }
    
    function renderModuleAttributesView () {
        
    }
    
    function renderMainView() {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        ?>
        <div class="panel modulesPanel">
            <div>
                <div class="adminTableToolbar">
                    <button id="btnAddModule">Add</button>
                    <button id="btnRemoveModule">Remove</button>
                </div>
                <h3>Modules:</h3>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="modules"></table>
            </div>
        </div>
        <div id="selectModuleDialog" title="Add Template">
            <?php 
            InfoMessages::printInfoMessage("templates.add.select");
            echo "<br/>";
            $modules = array();
            $allModules = ModuleModel::getModules();
            foreach ($allModules as $module) {
                $modules[$module->id] = $module->name;
            }
            InputFeilds::printSelect("module", null, $modules);
            ?>
        </div>
        <script type="text/javascript">
        var modules = [
            <?php
            $modules = ModuleModel::getModules();
            $first = true;
            foreach ($modules as $module) {
                if (!$first)
                    echo ",";
                echo "['".Common::htmlEscape($module->id)."','".Common::htmlEscape($module->name)."','".Common::htmlEscape($module->include)."','".Common::htmlEscape($module->interface)."']";
                $first = false;
            }
            ?>
        ];
        $(function() {
            var oTableModule = $('#modules').dataTable({
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 40, -1], [10, 20, 40, "All"]],
                "aaData": modules,
                "aoColumns": [
                    {'sTitle':'ID'},
                    {'sTitle':'Name'},
                    {'sTitle':'Path'},
                    {'sTitle':'Interface'}]
            });
            $("#modules tbody").click(function(event) {
                $(oTableModule.fnSettings().aoData).each(function (){
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
            });
            $("#selectModuleDialog").dialog({
                autoOpen: false,
                show: "blind",
                hide: "explode",
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
            // the button actions
            $("#btnAddModule").click(function () {
                $("#selectModuleDialog").dialog("open");
            });
            $("#btnRemoveModule").click(function () {
                callUrl("<?php echo parent::link(array("action"=>"remove"),false) ?>",{"id":getSelectedRow(oTableModule)[0].childNodes[0].innerHTML});
            });
        });
        </script>
        <?php
    }
    
}

?>