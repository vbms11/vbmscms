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
                    RolesModel::createCustomRole($_GET['rolename'], "");
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
                    $this->printMainView(parent::getId());
            }
        }
        
    }

    function getStyles () {
        return array("css/admin.css");
    }

    function getRoles () {
        return array("admin.roles.edit");
    }

    function printMainView ($pageId) {
        $roleGroups = RolesModel::getCustomRoles();
        $allRoles = Common::toMap(RolesModel::getModuleRoles());
        $roleGroupIds = array_keys($roleGroups);
        $group = isset($_GET['group']) ? $_GET['group'] : $roleGroupIds[0]; 
        $pageRoles = RolesModel::getCustomRoleModuleRoles($group);
        ?>
	<div class="panel rolesPage">
            <h3>Configure Role Groups</h3>
            <div>
                <form action="<?php echo parent::link(array("action"=>"saveRoles","group"=>$group)); ?>" method="post">
                    <?php
                    InfoMessages::printInfoMessage("Here you can determin which usergroups can do what!");
                    ?>
                    <br/>
                    <div>
                        <table width="100%"><tr><td class="expand" valign="bottom">
                            Select Role Group:<br/>
                            <select onchange="onSelectGroup();" class="expand text ui-widget-content ui-corner-all" id="rolegroup" name="rolegroup">
                                <?php
                                foreach ($roleGroups as $roleGroup) {
                                    ?><option value="<?php echo $roleGroup->id; ?>" <?php if ($group == $roleGroup->id) echo "selected=\"true\""; ?>><?php echo $roleGroup->name; ?></option><?php
                                }
                                ?>
                            </select>
                        </td><td>
                            <button id="createRole" class="nowrap">Create New Group</button>
                        </td><td>
                            <button id="deleteRole" class="nowrap">Delete Group</button>
                        </td></tr></table>
                    </div>
                    <br/>
                    <div>
                        <?php 
                        InputFeilds::printMultiSelect("roles", $allRoles, $pageRoles);
                        ?>
                    </div>
                    <br/><hr/>
                    <button type="submit">Save</button>
                </form>
                <div id="dialog-form" title="Create Role">
                    <p class="validateTips">Enter the name of the role.</p>
                    <form action="">
                        <label for="name">Name</label>
                        <input type="text" name="rolename" id="rolename" class="expand" />
                    </form>
                </div>
            </div>
            <script type="text/javascript">
            function onSelectGroup () {
                var url = "<?php echo parent::link(array(), false); ?>";
                callUrl(url,{"group":$("#rolegroup").val()});
            }
            $(function() {
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