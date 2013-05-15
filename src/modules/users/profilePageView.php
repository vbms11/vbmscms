<?php

require_once('core/plugin.php');
require_once('core/model/usersModel.php');
require_once('core/ddm/dataView.php');


class ProfilePageView extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("users.profile") && Context::isLoggedIn()) {

            switch (parent::getAction()) {
                case "save":
                    if (Context::hasRole("user.info.edit")) {
                        parent::param("mode",$_POST["mode"]);
                    }
                    parent::blur();
                    parent::redirect();
                    break;
                case "edit":
                    if (Context::hasRole("user.info.edit")) {
                        parent::focus();
                    }
                    break;
                case "changePassword":
                    UsersModel::setPassword(Context::getUserId(), $_POST['password1'], $_POST['oldPassword'] );
                    parent::redirect();
                case "update":
                    parent::blur();
                    break;
                case "editAttribs":
                    DynamicDataView::processAction("userAttribs",
                        NavigationModel::createModuleLink(Context::getModuleId(), array("action"=>"edit","id"=>$_GET['id'])),
                        NavigationModel::createModuleLink(Context::getModuleId(), array("action"=>"editAttribs","id"=>$_GET['id'])));
                    parent::focus();
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        $this->getRequestVars();
        
        if (Context::hasRole("users.profile") && Context::isLoggedIn()) {

            switch (parent::getAction()) {
                case "edit":
                    if (Context::hasRole("user.info.edit")) {
                        $this->printEditView();
                    }
                    break;
                case "editAttribs":
                    if ((parent::param("mode") == self::modeCurrentUser && Context::getUserId() == Context::getSelectedUserId()) || Context::hasRole("user.info.admin")) {
                        DynamicDataView::editObject("userAttribs",$_GET['id'],Context::getUsername()." Attributes:",
                            parent::link(array(),false), parent::link(array("action"=>"editAttribs","id"=>$_GET['id']),false));
                    }
                    break;
                default:
                    $this->printMainView();
                    break;
            }
        }
    }

    /**
     * called when module is installed
     */
    function install () {

    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("users.info.edit","users.info.admin","users.info.owner");
    }
    
    function printEditView () {
        ?>
        <div class="panel usersInfoPanel">
            <table><tr><td>
                <?php echo parent::getTranslation("users.info.edit.mode"); ?>
            </td><td>
                <?php InputFeilds::printSelect("mode", parent::param("mode"), array("Current User" => self::modeCurrentUser, "Selected User" => self::modeSelectedUser)); ?>
            </td></tr><tr><td>
                
            </td><td>

            </td></tr></table>
        </div>
        <?php
    }
    
    function printMainView () {
        ?>
        <div class="panel usersInfoPanel">
            <?php
            $user = UsersModel::getUser(Context::getUserId());
            ?>
            <form id="usersInfo" method="post" action="">
                <div class="formActionsToolbar">
                    <button id="changePassword" type="button">Change Password</button>
                    <button id="editAttribs" type="button">Edit Attributes</button>
                </div>
                <h3>User Info:</h3>
                <?php DynamicDataView::displayObject("userAttribs",$user->objectid); ?>
            </form>
            
            <div id="changePasswordPanel" title="Change Password">
                <p class="validateTips">Please enter the users new password in both feilds then click ok.</p>
                <form method="post" action="<?php echo parent::link(array("action"=>"changePassword")); ?>">
                    <label for="oldPassword">Old Password:</label>
                    <input type="password" id="oldPassword" name="oldPassword" class="expand" class="text ui-widget-content ui-corner-all" />
                    <br/><br/>
                    <label for="password1">New Password:</label>
                    <input type="password" name="password1" class="expand" id="password1" class="text ui-widget-content ui-corner-all" />
                    <br/><br/>
                    <label for="password2">Confirm Password:</label>
                    <input type="password" name="password2" class="expand" id="password2" class="text ui-widget-content ui-corner-all" />
                </form>
            </div>
            
            <script type="text/javascript">
            $(function() {
                $("#changePassword").button().click(function() {
                    $("#changePasswordPanel").dialog("open");
                });
                $("#editAttribs").button().click(function () {
                    callUrl("<?php echo parent::link(array("action"=>"editAttribs","id"=>$user->objectid),false); ?>");
                });
                $("#changePasswordPanel").dialog({
                    autoOpen: false, height: 300, width: 350, modal: true,
                    show: "blind", hide: "explode",
                    buttons: {
                        "Ok": function() {
                            var pass1 = $("#password1").val();
                            var pass2 = $("#password2").val();
                            if (pass1 == pass2) {
                                ajaxRequest("",null,{"old":$("#oldPassword").val(),"new":pass1});
                                $(this).dialog("close");
                            } else {
                                // validation error
                            }
                        }, "Cancel": function() {
                            $(this).dialog("close");
                        }
                    }
                });
            });
            $(".usersInfoPanel button").each(function (index,object) {
                object.button();
            })
            </script>
        </div>
        <?php
    }
}

?>