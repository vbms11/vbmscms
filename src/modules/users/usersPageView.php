<?php
require_once('core/common.php');
require_once('core/plugin.php');
require_once('core/model/usersModel.php');

include_once('modules/forum/forumPageModel.php');
include_once('core/ddm/dataView.php');

class UsersPageView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        if (Context::hasRole("users.edit")) {

            switch (parent::getAction()) {
                case "create":
                    parent::clearMessages();
                    if (parent::post("submit")) {
                        $validationMessages = UsersModel::validate(null, parent::post("username"), parent::post("firstname"), parent::post("lastname"), parent::post("password"), parent::post("email"), parent::post("dob"));
                        if (count($validationMessages) == 0) {
                            $id = UsersModel::saveUser(null, parent::post("username"), parent::post("firstname"), parent::post("lastname"), parent::post("password"), parent::post("email"), parent::post("dob"));
                            if (parent::post("active") == "1") {
                                UsersModel::setUserActiveFlag($id, "1");
                            }
                            parent::redirect(array("action"=>"edit","id"=>$id));
                        } else {
                            parent::addMessages($validationMessages);
                        }
                    }
                    break;
                case "update":
                    parent::clearMessages();
                    if (parent::post("submit")) {
                        $validationMessages = UsersModel::validate(parent::get("id"), parent::post("username"), parent::post("firstname"), parent::post("lastname"), null, parent::post("email"), parent::post("dob"), parent::post("register"));
                        if (count($validationMessages) == 0) {
                            UsersModel::saveUser(parent::get("id"), parent::post("username"), parent::post("firstname"), parent::post("lastname"), null, parent::post("email"), parent::post("dob"), parent::post("register"));
                        } else {
                            parent::addMessages($validationMessages);
                        }
                        parent::redirect(array("action"=>"edit","id"=>parent::get("id")));
                    }
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "delete":
                    UsersModel::deleteUser(parent::get("id"));
                    parent::blur();
                    parent::redirect();
                    break;
                case "cancel":
                    parent::blur();
                    parent::redirect();
                    break;
                case "activateUser":
                    UsersModel::setUserActiveFlag(parent::get("id"), "1");
                    parent::redirect(array("action"=>"edit","id"=>parent::get("id")));
                    break;
                case "deactivateUser":
                    UsersModel::setUserActiveFlag(parent::get("id"), "0");
                    parent::redirect(array("action"=>"edit","id"=>parent::get("id")));
                    break;
                case "changePassword":
                    UsersModel::setPassword(parent::get("id"),parent::post("password1"));
                    parent::redirect(array("action"=>"edit","id"=>parent::get("id")));
                    break;
                case "saveRoles":
                    if (parent::post("userRoles") != null) {
                        RolesModel::deleteRoles(parent::get("user"));
                        foreach (parent::post("userRoles") as $role) {
                            RolesModel::saveRole(null, $role, parent::get("user"), $role);
                        }
                    }
                    parent::redirect(array("action"=>"edit","id"=>parent::get("user")));
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        if (Context::hasRole("users.edit")) {

            switch (parent::getAction()) {
                case "edit":
                    $this->printEditUserTabs(parent::get("id"));
                    break;
                case "create":
                    $this->printCreateUserTabs();
                    break;
                default:
                    $this->printMainTabs();
            }
        }
    }

    /**
     * called when module is installed
     */
    function install () {

    }

    /**
     * returns style sheets used by this module
     */
    function getStyles () {
        return array("css/users.css");
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("users.edit");
    }
    
    function printMainTabs () {
        ?>
        <div class="panel userPanel">
            <div id="usersTabs">
                <ul>
                    <li><a href="#userListTab"><?php echo parent::getTranslation("users.tab.list"); ?></a></li>
                </ul>
                <div id="userListTab">
                    <?php $this->printUserListView() ?>
                </div>
            </div>
        </div>
        <script>
        $("#usersTabs").tabs();
        </script>
        <?php
    }
    
    function printCreateUserTabs () {
        ?>
        <div class="panel userPanel">
            <div id="usersTabs">
                <ul>
                    <li><a href="#userListTab"><?php echo parent::getTranslation("users.tab.list"); ?></a></li>
                    <li><a href="#userCreateTab"><?php echo parent::getTranslation("users.tab.create"); ?></a></li>
                </ul>
                <div id="userListTab">
                    <?php $this->printUserListView(); ?>
                </div>
                <div id="userCreateTab">
                    <?php $this->printCreateUserView(); ?>
                </div>
            </div>
        </div>
        <script>
        $("#usersTabs").tabs({
            active: 1
        });
        </script>
        <?php
    }
    
    function printEditUserTabs ($id) {
        ?>
        <div class="panel userPanel">
            <div id="usersTabs">
                <ul>
                    <li><a href="#userListTab"><?php echo parent::getTranslation("users.tab.list"); ?></a></li>
                    <li><a href="#userEditTab"><?php echo parent::getTranslation("users.tab.edit"); ?></a></li>
                </ul>
                <div id="userListTab">
                    <?php $this->printUserListView(); ?>
                </div>
                <div id="userEditTab">
                    <?php $this->printEditUserView($id); ?>
                </div>
            </div>
        </div>
        <script>
        $("#usersTabs").tabs({
            active: 1
        });
        </script>
        <?php
    }
    
    function printUserListView () {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        ?>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="userList"></table>
        <hr/>
        <div class="alignRight">
            <button id="btnAdd" class="jquiButton"><?php echo parent::getTranslation("users.button.create"); ?></button>
            <button id="btnEdit" class="jquiButton"><?php echo parent::getTranslation("users.button.edit"); ?></button>
            <button id="btnDelete" class="jquiButton"><?php echo parent::getTranslation("users.button.delete"); ?></button>
        </div>
        
        <script type="text/javascript">
        <?php
        $users = UsersModel::getUsers();
	$arUsers = array();
        foreach ($users as $user) {
            $arUsers[] = "['".Common::htmlEscape($user->id)."','".Common::htmlEscape($user->username)."','".Common::htmlEscape($user->firstname)."','".Common::htmlEscape($user->lastname)."','".Common::htmlEscape($user->email)."','".Common::htmlEscape($user->active)."']";
        }
        echo "var ar_columns = [{'sTitle':'ID'},{'sTitle':'Username'},{'sTitle':'Firstname'},{'sTitle':'Lastname'},{'sTitle':'Email'},{'sTitle':'Active'}];".PHP_EOL;
	echo "var ar_users = [".implode(",",$arUsers)."];".PHP_EOL;
        ?>
    	var oTable = $('#userList').dataTable({
        	"sScrollY": 300,
                "sScrollX": "100%",
                "sScrollXInner": "110%",
                "bScrollCollapse": true,
                "bPaginate": false,
                "bJQueryUI": true,
                "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                "aaData": ar_users,
                "aoColumns": ar_columns
  	});
       	oTable.click(function(event) {
            $(oTable.fnSettings().aoData).each(function (){
                    $(this.nTr).removeClass('row_selected');
            });
            $(event.target.parentNode).addClass('row_selected');
       	});
      	$("#btnDelete").click(function () {
            callUrl("<?php echo parent::link(array("action"=>"delete"),false); ?>",{"id":getSelectedRow(oTable)[0].childNodes[0].innerHTML});
        });
        $("#btnEdit").click(function () {
            callUrl("<?php echo parent::link(array("action"=>"edit"),false); ?>",{"id":getSelectedRow(oTable)[0].childNodes[0].innerHTML});
        });
        $("#btnAdd").click(function () {
            callUrl("<?php echo parent::link(array("action"=>"create"),false); ?>");
       	});
        </script>
        <?php
    }
    
    function printCreateUserView () {
        ?>
        <form method="post" action="<?php echo parent::link(array("action"=>"create")); ?>">
            <table class="formTable"><tr><td>
                <?php echo parent::getTranslation("users.attrib.username"); ?>
            </td><td>
                <?php 
                InputFeilds::printTextFeild(parent::alias("username"),parent::post("username")); 
                $message = parent::getMessage("username");
                if (!empty($message)) {
                    echo '<span class="validateTips">'.$message.'</span>';
                }
                ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("users.attrib.firstname"); ?>
            </td><td>
                <?php InputFeilds::printTextFeild(parent::alias("firstname"),parent::post("firstname")); 
                $message = parent::getMessage("firstname");
                if (!empty($message)) {
                    echo '<span class="validateTips">'.$message.'</span>';
                }
                ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("users.attrib.lastname"); ?>
            </td><td>
                <?php InputFeilds::printTextFeild(parent::alias("lastname"),parent::post("lastname")); 
                $message = parent::getMessage("lastname");
                if (!empty($message)) {
                    echo '<span class="validateTips">'.$message.'</span>';
                }
                ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("users.attrib.email"); ?>
            </td><td>
                <?php InputFeilds::printTextFeild(parent::alias("email"),parent::post("email")); 
                $message = parent::getMessage("email");
                if (!empty($message)) {
                    echo '<span class="validateTips">'.$message.'</span>';
                }
                ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("users.attrib.password"); ?>
            </td><td>
                <?php InputFeilds::printPasswordFeild(parent::alias("password")); 
                $message = parent::getMessage("password");
                if (!empty($message)) {
                    echo '<span class="validateTips">'.$message.'</span>';
                }
                ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("users.attrib.dob"); ?>
            </td><td>
                <?php InputFeilds::printDataPicker(parent::alias("dob"),parent::post("dob")); 
                $message = parent::getMessage("dob");
                if (!empty($message)) {
                    echo '<span class="validateTips">'.$message.'</span>';
                }
                ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("users.attrib.active"); ?>
            </td><td>
                <?php InputFeilds::printCheckbox(parent::alias("active"),parent::post("active")); 
                $message = parent::getMessage("active");
                if (!empty($message)) {
                    echo '<span class="validateTips">'.$message.'</span>';
                }
                ?>
            </td></tr></table>
            <hr/>
            <div class="alignRight">
                <button id="btnCreate" name="submit" value="1" type="submit" class="jquiButton"><?php echo parent::getTranslation("users.create.button.save"); ?></button>
                <button id="btnCancel" type="button" class="jquiButton"><?php echo parent::getTranslation("users.create.button.cancel"); ?></button>
            </div>
        </form>
        <script>
        $("#btnCancel").click(function(){
            callUrl("<?php echo parent::link(); ?>");
        });
        </script>
        <?php
    }
    
    function printEditUserView ($id) {
        $user = UsersModel::getUser($id);
        ?>
        <div id="userAccordion">

            <h3><a href="#"><?php echo parent::getTranslation("user.edit.title.attributes"); ?></a></h3>
            <div>
                <form method="post" action="<?php echo parent::link(array("action"=>"update","id"=>$id)); ?>">
                    <table class="formTable"><tr><td>
                        <?php echo parent::getTranslation("users.attrib.username"); ?>
                    </td><td>
                        <?php 
                        InputFeilds::printTextFeild(parent::alias("username"),parent::post("username") == null ? $user->username : parent::post("username")); 
                        $message = parent::getMessage("username");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.firstname"); ?>
                    </td><td>
                        <?php InputFeilds::printTextFeild(parent::alias("firstname"),parent::post("firstname") == null ? $user->firstname : parent::post("firstname")); 
                        $message = parent::getMessage("firstname");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.lastname"); ?>
                    </td><td>
                        <?php InputFeilds::printTextFeild(parent::alias("lastname"),parent::post("lastname") == null ? $user->lastname : parent::post("lastname")); 
                        $message = parent::getMessage("lastname");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.email"); ?>
                    </td><td>
                        <?php InputFeilds::printTextFeild(parent::alias("email"),parent::post("email") == null ? $user->email : parent::post("email")); 
                        $message = parent::getMessage("email");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.dob"); ?>
                    </td><td>
                        <?php InputFeilds::printDataPicker(parent::alias("dob"),parent::post("dob") == null ? $user->birthdate : parent::post("dob")); 
                        $message = parent::getMessage("dob");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.active"); ?>
                    </td><td>
                        <?php InputFeilds::printCheckbox(parent::alias("active"),parent::post("active") == null ? $user->active : parent::post("active")); 
                        $message = parent::getMessage("active");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                    </td></tr></table>
                    <hr/>
                    <div class="alignRight">
                        <button type="submit" class="jquiButton" name="submit" value="1"><?php echo parent::getTranslation("common.save"); ?></button>
                        <button type="button" class="jquiButton" id="cancelButton"><?php echo parent::getTranslation("common.cancel"); ?></button>
                        <button type="button" class="jquiButton" id="changePasswordButton"><?php echo parent::getTranslation("users.edit.changePassword"); ?></button>
                    </div>
                </form>
            </div>


            <h3><a href="#"><?php echo parent::getTranslation("user.edit.title.status"); ?></a></h3>
            <div>
                <table width="100%"><tr>
                <td valign="top" style="padding-right:100px;"><img src="resource/img/icons/Statistics.png" alt=""/></td>
                <td class="expand">
                    <div style="float:left;">
                        <?php
                        if ($user->active) {
                            echo '<img src="resource/img/icons/Tick.png" alt=""/>';
                        } else {
                            echo '<img src="resource/img/icons/Block.png" alt=""/>';
                        }
                        ?>
                    </div>
                    <div style="float:left; margin: 20px 20px">
                        <?php
                        if ($user->active) {
                            echo parent::getTranslation("user.edit.status.active");
                            ?>
                            <br/>
                            <button class="jquiButton" style="float:right;" onclick="callUrl('<?php echo parent::ajaxLink(array("action"=>"deactivateUser","id"=>parent::get("id")),false); ?>');">
                                <?php echo parent::getTranslation("user.edit.status.deactivate"); ?>
                            </button>
                            <?php
                        } else {
                            echo parent::getTranslation("user.edit.status.inactive");
                            ?>
                            <button class="jquiButton" style="float:right;" onclick="callUrl('<?php echo parent::ajaxLink(array("action"=>"activateUser","id"=>parent::get("id")),false); ?>');">
                                <?php echo parent::getTranslation("user.edit.status.activate"); ?>
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </td></tr></table>
            </div>

            <h3><a href="#"><?php echo parent::getTranslation("user.edit.title.roles"); ?></a></h3>
            <div>
                <form action="<?php echo parent::link(array("action"=>"saveRoles","user"=>$user->id)); ?>" method="post">
                    <?php
                    $allRoles = RolesModel::getCustomRoles();
                    $userRoles = RolesModel::getUserCustomRoles($user->id);
                    // print user roles selection
                    if ($allRoles != null && count($allRoles) != 0) {
                        $allRolesArray = Common::toMap($allRoles, "id", "name");
                        $rolesSelection = Common::toMap($userRoles, "roleid","roleid");
                        InputFeilds::printMultiSelect("userRoles", $allRolesArray, $rolesSelection);
                    }
                    ?>
                    <hr/>
                    <div class="alignRight">
                        <button class="jquiButton" id="saveRole" type="submit"><?php echo parent::getTranslation("user.edit.button.role.save"); ?></button>
                    </div>
                </form>
            </div>

        </div>
        
        <div id="dialog-form-password" title="<?php echo parent::getTranslation("user.edit.password.title"); ?>">
            <p class="validateTips"><?php echo parent::getTranslation("user.edit.password.message"); ?></p>
            <form id="passwordForm" method="post" action="<?php echo parent::link(array("action"=>"changePassword","id"=>$user->id)); ?>">
                <label for="password1"><?php echo parent::getTranslation("user.edit.password.password1"); ?></label>
                <input type="password" name="password1" class="expand" id="password1" class="text ui-widget-content ui-corner-all" />
                <br/><br/>
                <label for="password2"><?php echo parent::getTranslation("user.edit.password.password2"); ?></label>
                <input type="password" name="password2" class="expand" id="password2" class="text ui-widget-content ui-corner-all" />
            </form>
        </div>
        
        <script type="text/javascript">
        $("#userAccordion").accordion({
            navigation: true,
            heightStyle: "content",
            icons : {
                header: "ui-icon-circle-arrow-e",
                headerSelected: "ui-icon-circle-arrow-s"
            }
        });
        $("#cancelButton").click(function () {
            callUrl("<?php echo parent::link(array("action"=>"cancel")); ?>");
        });
        $("#changePasswordButton").click(function () {
            $("#dialog-form-password").dialog('open');
        });
        $("#dialog-form-password").dialog({
            autoOpen: false, height: 300, width: 350, modal: true,
            buttons: {
                "Ok": function(e) {
                    var pass1 = $( "#password1" ).val();
		    var pass2 = $( "#password2" ).val();
                    if (pass1 === pass2) {
                        $("#passwordForm").submit();
                    } else {
                        // validation error
			alert("<?php echo parent::getTranslation("user.edit.password.fail"); ?>");
			e.preventDefault();
                    }
                }, "Cancel": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        </script>
            
        </div>
        <?php
    }
}



?>