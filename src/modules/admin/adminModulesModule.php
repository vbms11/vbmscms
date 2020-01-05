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
            case "saveModule":
                ModuleModel::saveModule(parent::get("id"), parent::post("name"), parent::post("description"), parent::post("inmenu") ? "1" : "0", parent::post("category"));
                parent::redirect();
                break;
            case "saveCategorys":
                $categorys = parent::post("category");
                foreach (ModuleModel::getModules() as $module) {
                    if (!isset($categorys[$module->id]))
                        continue;
                    $category = $categorys[$module->id];
                    if (!empty($category)) {
                        ModuleModel::setModuleCategory($module->id,$category);
                    }
                }
                parent::redirect();
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
                <li><a href="#moduleTranslationsTab"><?php echo parent::getTranslation("admin.modules.tab.translations"); ?></a></li>
                <li><a href="#moduleAttribsTab"><?php echo parent::getTranslation("admin.modules.tab.attribs"); ?></a></li>
                <li><a href="#moduleConfigTab"><?php echo parent::getTranslation("admin.modules.tab.config"); ?></a></li>
            </ul>
            <div id="moduleAttribsTab">
                <?php $this->renderModuleAttributes(); ?>
            </div>
            <div id="moduleConfigTab">
                <?php $this->renderModuleConfigView(); ?>
            </div>
            <div id="moduleTranslationsTab">
                <?php $this->renderModuleTranslationsView(); ?>
            </div>
        </div>
        <script>
        $("#adminModulesTabs").tabs();
        </script>
        <?php
    }
    
    function renderModuleAttributes () {
        $module = ModuleModel::getModule(parent::get("id"));
        $categorys = ModuleModel::getModuleCategorys();
        ?>
        <form method="post" action="<?php echo parent::link(array("action"=>"saveModule","id"=>parent::get("id"))); ?>">
            <table class="formTable">
                <tr>
                    <td><?php echo parent::getTranslation("module.name"); ?></td>
                    <td><?php echo InputFeilds::printTextFeild("name", $module->name); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("module.description"); ?></td>
                    <td><?php echo InputFeilds::printTextFeild("description", $module->description); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("module.category"); ?></td>
                    <td><?php echo InputFeilds::printSelect("category", $module->category, Common::toMap($categorys,"id","name")); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("module.inmenu"); ?></td>
                    <td><?php echo InputFeilds::printCheckbox("inmenu", $module->inmenu); ?></td>
                </tr>
            </table>
            <hr/>
            <div class="alignRight">
                <button type="submit"><?php echo parent::getTranslation("module.save"); ?></button>
            </div>
        </form>
        <?php
    }
    
    function renderModuleConfigView () {
        /*
        $theModule = ModuleModel::getModule(parent::get("adminModuleId"));
        $theModule->typeid = $theModule->id;
        $theModule->id = null;
        $theModule->modulename = $theModule->name;
        $theModule->name = null;
        $theModule->position = null;
        $moduleObject = ModuleModel::getModuleClass($theModule);
        ModuleController::renderModule($moduleObject);
         
         */
    }
    
    function renderModuleTranslationsView () {
        
    }
    
    function renderMainView() {
        $modules = ModuleModel::getModules();
        $categorys = ModuleModel::getModuleCategorys();
        $categorys = Common::toMap($categorys,"id","name");
        
        
        ?>
        <div class="panel modulesPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"saveCategorys")); ?>">
            <table>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>System Name</td>
                        <td>Include</td>
                        <td>Category</td>
                        <td>Interface</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modules as $module) {
                        ?>
                        <tr>
                            <td><?php echo $module->id; ?></td>
                            <td><?php echo $module->name; ?></td>
                            <td><?php echo $module->sysname; ?></td>
                            <td><?php echo $module->include; ?></td>
                            <td>
                            
                            <?php InputFeilds::printSelect("category[".$module->id."]", $module->category, $categorys); ?>
                            </td>
                            <td><?php echo $module->interface; ?></td>
                            <td><a href="<?php echo parent::link(array("action"=>"editModule","id"=>$module->id)); ?>">Edit</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
                <button type="submit">Save All</button>
            </form>
        </div>
        <?php
    }
    
}

?>