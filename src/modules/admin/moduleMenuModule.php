<?php

require_once 'core/plugin.php';

class ModuleMenuModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            
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
                $this->renderMainView();
        }
    }
    
    function getRoles () {
        return array("modules.insert");
    }
    
    function getScripts() {
        return array("js/moduleMenu.js");
    }
    
    function getStyles() {
        return array("css/moduleMenu.css");
    }
    
    function renderMainView () {
        
        $categorys = ModuleModel::getModuleCategorys();
        $modules = ModuleModel::getModulesInMenu();
        
        ?>
        <div class="panel moduleMenuPanel">
            
            <?php
            foreach ($categorys as $category) {

                ?>
                <div class="moduleMenuCategory">
                    <img src="<?php echo $category->icon; ?>" alt="<?php echo $category->description; ?>" />
                    <?php echo $category->name; ?>
                </div>
                <div class="moduleMenuGroup hide">
                <?php
                
                foreach ($modules as $module) {
                    if ($module->category == $category->id) {
                        ?>
                        <div class="moduleMenuItem">
                            <div class="moduleName"><?php echo $module->name; ?></div>
                            <div class="moduleDescription"><?php echo $module->description; ?></div>
                        </div>
                        <?php
                    }
                }
                ?>
                </div>
                <?php
            }
            ?>
        </div>
        <script type="text/javascript">
        showModuleMenu();
        </script>
        <?php
    }
    
}

?>