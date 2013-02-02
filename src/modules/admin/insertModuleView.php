<?php

require_once 'core/plugin.php';

class InsertModuleView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "insertModule":
                parent::focus();
                break;
            case "doInsertModule":
                if (Context::hasRole("modules.insert")) {
                    $newModuleId = TemplateModel::insertTemplateModule($_GET["selectedPage"], $_GET["area"], $_POST["module"], $_GET["position"]);
                    parent::blur();
                    parent::redirect($newModuleId, array("action"=>"edit"));
                    break;
                }
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            
            default:
                $this->renderMainView();
        }
    }
    
    function getRoles () {
        return array("modules.insert");
    }
    
    function renderMainView() {
        
        ?>
        <div class="panel">

            <?php
            InfoMessages::printInfoMessage("insertModule.info");
            ?>

            <br/>
            <form method="post" action="<?php echo parent::link(array("action"=>"doInsertModule","selectedPage"=>$_GET["selectedPage"], "area"=>$_GET["area"], "position"=>$_GET["position"])); ?>">

                <table class="expand"><tr><td class="nowrap">
                    Category:
                </td><td class="expand">
                    <?php
                    $categorys = Common::toMap(ModuleModel::getModuleCategorys(), "id", "name");
                    InputFeilds::printSelect("category", null, $categorys);
                    ?>
                </td></tr><tr><td class="nowrap">
                    Module:
                </td><td class="expand">
                    <?php
                    $modulesInMenu = ModuleModel::getModulesInMenu();
                    $modules = Common::toMap($modulesInMenu, "id", "name");
                    InputFeilds::printSelect("module", null, $modules);
                    ?>
                </td></tr></table><hr/>
		<div class="alignRight">
		    <button type="submit">Save</button>
                    <button type="button" onclick="history.back(); return false;">Abbrechen</button>
		</div>

                <script>
		$('.alignRight button').each(function (index,object) {
			$(object).button();
		});
                $('#category').change(function () {
                    $('#module').empty();
                    $.each(modules[$('#category').val()], function(val, text) {
                        $('#module').append(
                            $('<option></option>').val(val).html(text)
                        );
                    });

                })
                <?php 
                echo "var modules = {";
                $first = true;
                foreach ($categorys as $ckey => $cvalue) {
                    if (!$first) {
                        echo ",";
                    }
                    $first = false;
                    echo "'".Common::htmlEscape($ckey)."' : {";
                    $firstm = true;
                    foreach ($modulesInMenu as $module) {
                        if ($module->category == $ckey) {
                            if (!$firstm) {
                                echo ",";
                            }
                            $firstm = false;
                            echo "'".Common::htmlEscape($module->id)."' : '".Common::htmlEscape($module->name)."'";
                        }
                    }
                    echo "}".PHP_EOL;
                }
                echo "};";
                ?>
                
                </script>
                
            </form>
        </div>
        <?php
    }
    
}

?>