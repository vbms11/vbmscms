<?php

require_once('core/common.php');
require_once('core/plugin.php');
require_once('core/model/usersModel.php');
include_once('modules/forum/forumPageModel.php');
include_once('core/ddm/dataView.php');

class RegisterRoleModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("roles.register.edit")) {
                    parent::param("confirmRegister",    $_POST['confirmRegister']);
                    parent::param("confirmUnregister",  $_POST['confirmUnregister']);
                    parent::param("userRoles",          $_POST['userRoles']);
                    parent::param("clickToRegister",    $_POST['clickToRegister']);
                    parent::param("clickToUnregister",  $_POST['clickToUnregister']);
                    parent::param("notLoggedIn",        $_POST['notLoggedIn']);
                }
                break;
            case "register":
                if (count(parent::param("userRoles")) > 0) {
                    foreach (parent::param("userRoles") as $roleId) {
                        RolesModel::addCustomRoleToUser($roleId,Context::getUserId());
                    }
                    Context::reloadRoles();
                    parent::focus();
                }
                break;
            case "unregister":
                if (count(parent::param("userRoles")) > 0) {
                    foreach (parent::param("userRoles") as $roleId) {
                        RolesModel::removeCustomRoleFromUser($roleId,Context::getUserId());
                    }
                    Context::reloadRoles();
                    parent::focus();
                }
                break;
            case "registerUser":
                NavigationModel::addModuleNextAction(parent::getId(), array("action"=>"register"));
                NavigationModel::redirectStaticModule("register");
                break;
            case "loginUser":
                NavigationModel::addModuleNextAction(parent::getId(), array("action"=>"register"));
                NavigationModel::redirectStaticModule("login");
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("roles.register.edit")) {
                    $this->printEditView();
                }
                break;
            case "register":
                $this->printRegistrationFinnishedView();
                break;
            case "unregister":
                $this->printUnregisterFinnishedView();
                break;
            default:
                $this->printRegisterRoleView();
                break;
        }
    }
    
    function getRoles () {
        return array("roles.register.edit");
    }

    static function getTranslations () {
        return array(
            "en" => array(
                "register.role.unregister" => "Unregister",
                "register.role.register" => "Register",
                "register.role.login" => "Login",
                "register.role.create" => "Create User"
            ),
            "de" => array(
                "register.role.unregister" => "Unregister",
                "register.role.register" => "Registrieren",
                "register.role.login" => "Anmelden",
                "register.role.create" => "Benutzer erstellen"
            )
        );
    }

    function printEditView () {
        ?>
        <div class="panel registerRolePanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <div>User Roles: </div>
                <div>
                    <?php
                    $customRoles = Common::toMap(RolesModel::getCustomRoles(),"id","name");
                    InputFeilds::printMultiSelect("userRoles", $customRoles, Common::toMap(parent::param("userRoles")));
                    ?>
                </div>
                <div>Confirm registration message:</div>
                <div>
                    <?php InputFeilds::printHtmlEditor("confirmRegister",parent::param("confirmRegister")); ?>
                </div>
                <div>Confirm unregistration message:</div>
                <div>
                    <?php InputFeilds::printHtmlEditor("confirmUnregister",parent::param("confirmUnregister")); ?>
                </div>
                <div>Please click to register text:</div>
                <div>
                    <?php InputFeilds::printHtmlEditor("clickToRegister",parent::param("clickToRegister")); ?>
                </div>
                <div>Please click to unregister text:</div>
                <div>
                    <?php InputFeilds::printHtmlEditor("clickToUnregister",parent::param("clickToUnregister")); ?>
                </div>
                <div>Please loggin to register text:</div>
                <div>
                    <?php InputFeilds::printHtmlEditor("notLoggedIn",parent::param("notLoggedIn")); ?>
                </div>
                <hr/>
                <div class="alignRight">
                    <button type="submit">Save</button>
                </div>
            </form>
            <script type="text/javascript">
            $(".registerRolePanel .alignRight button").button();
            </script>
        </div>
        <?php
    }
    
    function printRegisterRoleView () {
        ?>
        <div class="panel registerRolePanel">
	    <?php
	    if (Context::isLoggedIn()) {
            $roles = array_values(is_array(parent::param("userRoles")) ? parent::param("userRoles") : array());
            $userRoles = array_values(Context::getRoleGroups());
            $hasRole = false;
            foreach ($roles as $role) {
                foreach ($userRoles as $userRole) {
                    if ($role == $userRole) {
                        $hasRole = true;
                    }
                }
            }
            if ($hasRole) {
                echo parent::param("clickToUnregister");
                ?>
                <button type="button" id="unregister"><?php echo parent::getTranslation("register.role.unregister"); ?></button>
                <script type="text/javascript">
                $(".registerRolePanel button").button();
                $("#unregister").click(function(){
                    callUrl("<?php echo parent::link(array("action"=>"unregister")); ?>");
                });
                </script>
                <?php
            } else {
                echo parent::param("clickToRegister");
                ?>
                <button type="button" id="register"><?php echo parent::getTranslation("register.role.register"); ?></button>
                <script type="text/javascript">
                $(".registerRolePanel button").button();
                $("#register").click(function(){
                    callUrl("<?php echo parent::link(array("action"=>"register")); ?>");
                });
                </script>
                <?php
            }
	    } else {
            echo parent::param("notLoggedIn");
            ?>
            <button type="button" id="login"><?php echo parent::getTranslation("register.role.login"); ?></button>
            <button type="button" id="register"><?php echo parent::getTranslation("register.role.create"); ?></button>
            <script type="text/javascript">
            $(".registerRolePanel button").button();
            $("#register").click(function(){
                callUrl("<?php echo parent::link(array("action"=>"registerUser")); ?>");
            });
            $("#login").click(function(){
                callUrl("<?php echo parent::link(array("action"=>"loginUser")); ?>");
            });
            </script>
            <?php
        }
	    ?>
        </div>
        <?php
    }

    function printRegistrationFinnishedView () {
        ?>
        <div class="panel registerRolePanel">
            <?php
            echo parent::param("confirmRegister");
            ?>
        </div>
        <?php
    }

    function printUnregisterFinnishedView () {
    	?>
        <div class="panel registerRolePanel">
            <?php
            echo parent::param("confirmUnregister");
            ?>
        </div>
        <?php
    }
}

?>