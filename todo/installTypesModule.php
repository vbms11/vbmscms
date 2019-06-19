<?php

require_once 'core/plugin.php';
require_once 'core/model/backupModel.php';
require_once 'core/model/fileSystemModel.php';

class InstallTypesModule extends XModule {
    
    function onProcess() {
        
        switch (parent::getAction()) {
            case "edit":
                parent::blur();
                parent::redirect();
            case "create":
                if (Context::hasRole("installType.manage")) {
                    $name = parent::post("name");
                    $filename = FileSystemModel::escapeFileName($name);
                    $valid = !InstallerController::doseInstallTypeFileExist($filename);
                    if ($valid) {
                        InstallerController::createInstallType($filename,$name,parent::post("description"));
                        parent::redirect();
                    } else {
                        parent::setMessages(array("name"=>"an install type with this name is already exists!"));
                    }
                }
                break;
            case "delete":
                if (Context::hasRole("installType.manage")) {
                    InstallerController::deleteInstallType($_GET['filename']);
                }
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                break;
            case "create":
            case "createView":
                if (Context::hasRole("installType.manage")) {
                    $this->renderCreateView();
                }
                break;
            default:
                if (Context::hasRole("installType.manage")) {
                    $this->renderMainView();
                }
            }
    }
    
    function getRoles () {
        return array("installType.manage");
    }
    
    function renderMainView () {
        
        $installTypes = InstallerController::getInstallTypes();
        ?>
        <div class="panel">
            <h3><?php echo parent::getTranslation("installType.heading"); ?></h3>
            <h3><?php echo parent::getTranslation("installType.description"); ?></h3>
            <table class="resultTable" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <td class="contract" align="center"><?php echo parent::getTranslation("installTypes.name"); ?></td>
                        <td class="expand" align="center"><?php echo parent::getTranslation("installTypes.description"); ?></td>
                        <td class="contract" align="center"><?php echo parent::getTranslation("installTypes.tools"); ?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($installTypes as $installType) {
                        ?>
                        <tr>
                            <td>
                                <?php echo htmlentities($installType->name); ?>
                            </td>
                            <td>
                                <?php echo htmlentities($installType->description); ?>
                            </td>
                            <td><a href="<?php echo parent::link(array("action"=>"delete","filename"=>$installType->filename)); ?>">Delete</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="alignLeft" style="margin-top:10px">
                <button id="createInstallType"><?php echo parent::getTranslation("installTypes.create"); ?></button>
            </div>
            
            <script>
            $("#createInstallType").click(function(event) {
                callUrl('<?php echo parent::link(array("action"=>"createView")); ?>');
            });
            </script>
        </div>
        <?php
    }
    
    function renderCreateView () {
        
        ?>
        <div class="createInstallTypeDialog">
            <h3><?php echo parent::getTranslation("installType.create.heading"); ?></h3>
            <p><?php echo parent::getTranslation("installType.create.description"); ?></p>
            <form action="<?php echo parent::link(array("action"=>"create")); ?>" method="post">
            	<table class="formTable"><tr>
                    <td><?php echo parent::getTranslation("installType.create.label.name"); ?></td>
                    <td><input name="name" type="text" value="<?php if (!empty(parent::post("name"))) echo parent::post("description"); ?>" placeholder="<?php echo parent::getTranslation("installType.create.placeholder.description"); ?>" /></td>
                    <?php
                    $message = parent::getMessage("name");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </tr><tr>
                    <td><?php echo parent::getTranslation("installType.create.label.description"); ?></td>
                    <td><textarea name="description" placeholder="<?php echo parent::getTranslation("installType.create.placeholder.description"); ?>"><?php if (!empty(parent::post("description"))) echo parent::post("description"); ?></textarea></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                <button type="submit"><?php echo parent::getTranslation("installType.create.button.submit"); ?></button>
                <button type="button" id="cancelCreate"><?php echo parent::getTranslation("installType.create.button.cancel"); ?></button>
            </form>
            <script>
            $("#cancelCreate").click(function(event) {
                callUrl('<?php echo parent::link(); ?>');
            });
            </script>
        </div>
        <?php
    }
}

?>