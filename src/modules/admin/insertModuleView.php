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
                    $newModuleId = TemplateModel::insertTemplateModule(parent::get("selectedPage"), parent::get("area"), parent::post("module"), parent::get("position"));
                    parent::blur();
                    parent::redirect($newModuleId, array("action"=>"edit"));
                    break;
                }
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            
            default:
                $this->renderMainTabs();
        }
    }
    
    function getRoles () {
        return array("modules.insert");
    }
    
    function renderMainTabs () {
        ?>
        <div class="panel insertModulePanel">
            <div class="insertModuleTabs">
                <ul>
                    <li><a href="#insertModuleTab"><?php echo parent::getTranslation("insertModule.tab.insert"); ?></a></li>
                </ul>
                <div id="insertModuleTab">
                    <?php $this->renderMainView(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".insertModuleTabs").tabs();
        </script>
        <?php
    }
    
    function renderMainView () {
        ?>
        <h1><?php echo parent::getTranslation("insertModule.insert.title"); ?></h1>
        <form method="post" action="<?php echo parent::link(array("action"=>"doInsertModule","selectedPage"=>parent::get("selectedPage"), "area"=>parent::get("area"), "position"=>parent::get("position"))); ?>">

            <table class="formTable"><tr><td>
                <?php echo parent::getTranslation("insertModule.insert.category"); ?>
            </td><td>
                <?php
                $categorys = Common::toMap(ModuleModel::getModuleCategorys(), "id", "name");
                InputFeilds::printSelect("category", null, $categorys);
                ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("insertModule.insert.module"); ?>
            </td><td>
                <?php
                $modulesInMenu = ModuleModel::getModulesInMenu();
                $modules = Common::toMap($modulesInMenu, "id", "name");
                InputFeilds::printSelect("module", null, $modules);
                ?>
            </td></tr></table>
            
            <hr/>
            <div class="alignRight">
                <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                <button type="button" class="jquiButton" onclick="history.back(); return false;"><?php echo parent::getTranslation("common.cancel"); ?></button>
            </div>

            <script>
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
        <?php
    }
    
}

?>