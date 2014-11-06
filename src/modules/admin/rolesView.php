<?php

require_once 'core/plugin.php';

class RolesView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("admin.roles.edit")) {
            switch (parent::getAction()) {
                case "saveRoles":
                    $customRole = $_GET['group'];
                    RolesModel::clearCustomRoles($customRole);
                    $selectedModuleRoles = $_POST['roles'];
                    if (is_array($selectedModuleRoles)) {
                        RolesModel::addModuleRoleToCustomRole($selectedModuleRoles, $customRole);
                    }
                    parent::redirect();
                    break;
                case "createRole":
                    RolesModel::createCustomRole($_GET['rolename'], "0");
                    parent::redirect();
                    break;
                case "deleteRole":
                    RolesModel::deleteCustomRole($_GET['group']);
                    parent::redirect();
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        if (Context::hasRole("admin.roles.edit")) {
            switch (isset($_GET['action']) ? $_GET['action'] : null) {
                case "addRole":
                case "removeRole":
                    break;
                default:
                    $this->printMainTabs();
            }
        }
        
    }

    function getStyles () {
        return array("css/admin.css");
    }

    function getRoles () {
        return array("admin.roles.edit");
    }
    
    function printMainTabs () {
        ?>
        <div class="adminRolesTabs">
            <ul>
                <li><a href="#adminRoles"><?php echo parent::getTranslation("admin.roles.tab"); ?></a></li>
            </ul>
            <div id="adminRoles">
                <?php $this->printMainView(); ?>
            </div>
        </div>
        <script>
        $(".adminRolesTabs").tabs();
        </script>
        <?php
    }
    
    function printMainView () {
        $roleGroups = RolesModel::getCustomRoles();
        $allRoles = Common::toMap(RolesModel::getModuleRoles());
        $roleGroupIds = array_keys($roleGroups);
        $group = isset($_GET['group']) ? $_GET['group'] : current($roleGroupIds); 
        $pageRoles = RolesModel::getCustomRoleModuleRoles($group);
        ?>
	<div class="panel rolesPage">
            <h3><?php echo parent::getTranslation("admin.roles.title"); ?></h3>
            <p><?php echo parent::getTranslation("admin.roles.description"); ?></p>
            <form action="<?php echo parent::link(array("action"=>"saveRoles","group"=>$group)); ?>" method="post">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("admin.roles.label.roleGroup"); ?>
                </td><td>
                    <select id="rolename">
                            <?php
                            foreach ($roleGroups as $roleGroup) {
                                ?><option value="<?php echo $roleGroup->id; ?>" <?php if ($group == $roleGroup->id) echo "selected=\"true\""; ?>><?php echo $roleGroup->name; ?></option><?php
                            }
                            ?>
                        </select>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("admin.roles.label.roles"); ?>
                </td><td>
                    <?php
                    InputFeilds::printMultiSelect("roles", $allRoles, $pageRoles);
                    ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button id="saveRoles" type="submit"><?php echo parent::getTranslation("admin.roles.button.save"); ?></button>
                    <button id="createRole" class="nowrap"><?php echo parent::getTranslation("admin.roles.button.new"); ?></button>
                    <button id="deleteRole" class="nowrap"><?php echo parent::getTranslation("admin.roles.button.delete"); ?></button>
                </div>
            </form>
            <div id="dialog-form" title="Create Role">
                <p class="validateTips">
                    <?php echo parent::getTranslation("admin.roles.dialog.message"); ?>
                </p>
                <form action="">
                    <table class="formTable"><tr><td>
                        <?php echo parent::getTranslation("admin.roles.dialog.label"); ?>
                    </td><td>
                        <input type="text" name="rolename" id="rolename" class="expand" />
                    </td></tr></table>
                </form>
            </div>
            <script type="text/javascript">
            $(function() {
                $("#rolename").change(function(){
                    var url = "<?php echo parent::link(array(), false); ?>";
                    callUrl(url,{"group":$(this).val()});
                });
                $( "#dialog-form" ).dialog({
                    autoOpen: false, modal: true,
                    height: 300, width: 350,
                    buttons: {
                        "Create Role": function() {
                            $( this ).dialog( "close" );
                            callUrl("<?php echo parent::link(array("action"=>"createRole"),false); ?>",{"rolename":$("#rolename").val()});
                        },
                        "Cancel": function() {
                            $( this ).dialog( "close" );
                        }
                    }
                });
                $("#saveRoles").button();
                $( "#createRole" ).button().click(function(e) {
                    $( "#dialog-form" ).dialog( "open" );
                    e.preventDefault();
                });
                $( "#deleteRole" ).button().click(function() {
                    var url = "<?php echo parent::link(array("action"=>"deleteRole"),false); ?>";
                    callUrl(url,{"group":$("#rolegroup").val()});
                });
            });
            </script>
        </div>
        <?php
    }
}

?>