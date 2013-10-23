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

        $this->getRequestVars();

        if (Context::hasRole("users.edit")) {

            switch (parent::getAction()) {
                case "create":
                    $userObjectId = DynamicDataView::createObject("userAttribs");
                    $user = UsersModel::getUserByObjectId($userObjectId);
                    parent::redirect(array("action"=>"edit","id"=>$user->id));
                    break;
                case "updateUser":
                    UsersModel::saveUser($_POST['id'], $_POST['userName'], $_POST['firstName'], $_POST['lastName'], null, $_POST['email'], $_POST['birthDate'], null);
                    parent::redirect(array("action"=>"edit","id"=>$this->id));
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "delete":
                    UsersModel::deleteUser($_GET['id']);
                    parent::blur();
                    parent::redirect();
                    break;
                case "cancel":
                    parent::blur();
                    parent::redirect();
                    break;
                case "editAttribs":
                    DynamicDataView::processAction("userAttribs",
                        parent::link(array("action"=>"edit","id"=>$this->id),false),
                        parent::link(array("action"=>"editAttribs","id"=>$this->id),false));
                    parent::focus();
                    break;
                case "configAttribs":
                    DynamicDataView::processAction("userAttribs",
                        parent::link(array("action"=>"edit","id"=>$this->id),false),
                        parent::link(array("action"=>"configAttribs","id"=>$this->id),false));
                    parent::focus();
                    break;
                case "search":
                    DynamicDataView::processAction("userAttribs",
                        parent::link(array("action"=>"edit","id"=>$this->id),false),
                        parent::link(array("action"=>"searchAttribs","id"=>$this->id),false));
                    parent::focus();
                    break;
                case "activateUser":
                    UsersModel::setUserActiveFlag($this->id, "1");
                    parent::redirect(array("action"=>"edit","id"=>$this->id));
                    break;
                case "deactivateUser":
                    UsersModel::setUserActiveFlag($this->id, "0");
                    parent::redirect(array("action"=>"edit","id"=>$this->id));
                    break;
                case "changePassword":
                    UsersModel::setPassword($this->id,$_POST['password1']);
                    parent::redirect(array("action"=>"edit","id"=>$this->id));
                    break;
                case "export":
                    if (isset($_GET['selectedTab'])) {
                        switch ($_GET['selectedTab']) {
                            case "0":
                                $_SESSION['dataView.query'] = new DMQuery("userAttribs",DMCriteria::equals("1", "active"));
                                break;
                            case "1":
                                $_SESSION['dataView.query'] = new DMQuery("userAttribs",DMCriteria::addAnd(array(
                                    DMCriteria::equals("0", "active"),
                                    DMCriteria::equals("1", "registered")
                                )));
                                break;
                            case "2":
                                $_SESSION['dataView.query'] = new DMQuery("userAttribs",DMCriteria::addAnd(array(
                                    DMCriteria::equals("0", "active"),
                                    DMCriteria::equals("0", "registered")
                                )));
                                break;
                            case "3":
                                $_SESSION['dataView.query'] = new DMQuery("userAttribs",DMCriteria::all());
                                break;
                        }
                    }
                    
                    DynamicDataView::processAction("userAttribs",
                        parent::link(array(),false),
                        parent::link(array("action"=>"export","id"=>$this->id),false));
                    parent::focus();
                    break;
                case "import":
                    DynamicDataView::processAction("userAttribs",
                        parent::link(array(),false),
                        parent::link(array("action"=>"import","id"=>$this->id),false));
                    parent::focus();
                    break;
                case "getData":
                    $users = null;
                    switch ($_GET['dataType']) {
                        case "active":
                            $users = UsersModel::getUsers(true,true);
                            break;
                        case "inactive":
                            $users = UsersModel::getUsers(true,false);
                            break;
                        case "unregistered":
                            $users = UsersModel::getUsers(false);
                            break;
                        case "all":
                            $users = UsersModel::getUsers();
                            break;
                    }
                    break;
                case "saveRoles":
                    if (isset($_POST['userRoles'])) {
                        RolesModel::deleteRoles($_GET['user']);
                        foreach ($_POST['userRoles'] as $role) {
                            RolesModel::saveRole(null, $role, $_GET['user'], $role);
                        }
                    }
                    parent::redirect(array("action"=>"edit","id"=>$_GET['user']));
                    break;
                case "generateUsers":
                    $returnCsv = "";
                    $defaultroles = isset($_POST["userRoles"]) ? $_POST["userRoles"] : null;
                    parent::param("defaultroles",$defaultroles);
                    for ($i=0; $i<$_POST['numUsers']; $i++) {
                        $username = "user".UsersModel::getMaxUserId();
                        $password = Common::randHash(10);
                        $returnCsv .= "$username,$password\r\n";
                        $userId = UsersModel::saveUser(null, $username, "", "", $password, "", "", null);
                        UsersModel::setUserActiveFlag($userId, "1");
                        if (!Common::isEmpty($defaultroles)) {
                            foreach ($defaultroles as $defaultrole) {
                                RolesModel::saveRole(-1, $defaultrole, $userId, $defaultrole);
                            }
                        }
                    }
                    header("Expires: 0");
                    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
                    header("cache-control: no-store, no-cache, must-revalidate");
                    header("Pragma: no-cache");
                    header("content-type: application/csv-tab-delimited-table");
                    header("content-length: 9999");//.strlen($returnCsv)
                    header("content-disposition: attachment; filename=newusers".Common::rand().".csv");
                    Context::returnValue($returnCsv);
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        $this->getRequestVars();
        
        if (Context::hasRole("users.edit")) {

            switch (parent::getAction()) {
                case "edit":
                    if ($this->id != null) {
                        $this->printEditUserView(parent::getId(),$this->id);
                    } else {
                        $this->printMainView(parent::getId());
                    }
                    break;
                case "search":
                    $this->printSearchView(parent::getId());
                    break;
                case "editAttribs":
                    $this->printEditAttribsView($_GET['object']);
                    break;
                case "configAttribs":
                    $this->printConfigAttribsView($_GET['object']);
                    break;
                case "export":
                    DynamicDataView::renderExport(parent::link(array()), parent::link(array("action"=>"export","id"=>$this->id)), "userAttribs");
                    break;
                case "import":
                    DynamicDataView::renderImport(parent::link(array()), parent::link(array("action"=>"import","id"=>$this->id)), "userAttribs");
                    break;
                case null:
                    $this->printMainView(parent::getId());
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


    function getRequestVars () {
        $this->action = null; if (isset($_GET['action'])) $this->action = $_GET['action'];
        $this->id = null; if (isset($_GET['id'])) $this->id = $_GET['id'];
    }

    function printEditAttribsView ($objectId) {
        DynamicDataView::editObject("userAttribs",$objectId,"User Attributes:",
            parent::link(array("action"=>"edit","id"=>$this->id),false),
            parent::link(array("action"=>"editAttribs","id"=>$this->id),false));
    }
    
    function printConfigAttribsView ($objectId) {
        DynamicDataView::configureObject("userAttribs",
            parent::link(array("action"=>"edit","id"=>$this->id),false),
            parent::link(array("action"=>"configAttribs","id"=>$this->id,"object"=>$objectId),false));
    }

    function printMainView ($moduleId) {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        ?>
        <div class="panel">
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-0">User List</a></li>
                    <li><a href="#tabs-1">Create Users</a></li>
                </ul>
                <div id="tabs-0">
                    <div class="alignRight">
                        <button class="btnImport">Import</button>
                        <button class="btnExport">Export</button>
                        <button class="btnAdd">Add User</button>
                        <button class="btnEdit">Edit User</button>
                        <button class="btnDelete">Delete User</button>
                    </div>
		    <hr/>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="userList"></table>
                </div>
                <div id="tabs-1">
                    <form action="<?php echo parent::link(array("action"=>"generateUsers")); ?>" method="post" >
                        <h3>Create many users:</h3>
                        <table><tr><td>
                            Number of users to generate
                        </td><td>
                            <?php
                            InputFeilds::printTextFeild("numUsers", "");
                            ?>
                        </td></tr><tr><td>
                            Select initial user roles
                        </td><td>
                            <?php
                            InputFeilds::printMultiSelect("userRoles", Common::toMap(RolesModel::getCustomRoles(),"id","name"), parent::param("defaultroles"));
                            ?>
                        </td></tr></table>
                        <br/>
                        <input type="submit" value="Generate"/>
                    </form>
                </div>
            </div>
        </div>

        <div id="registerUserDialog" title="Register User">
            <p class="validateTips">Please fill out these attributes, they are the minimum datafeilds that are required to register a user.</p>
            <form method="post" id="registerUserForm" action="<?php echo parent::link( array("action"=>"create")); ?>">
                <?php DynamicDataView::renderCreateObject("userAttribs", parent::link(),parent::link()); ?>
            </form>
        </div>

        <script type="text/javascript">
	
	$("#tabs").tabs();
	
	// users table
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
        
	$("#tabs-0 button").each(function (index, object) {
		$(object).button();
	});
      	$("#tabs-0 .btnDelete").click(function () {
        	callUrl("<?php echo parent::link(array("action"=>"delete"),false); ?>",{"id":getSelectedRow(oTable)[0].childNodes[0].innerHTML});
        });
        $("#tabs-0 .btnEdit").click(function () {
        	callUrl("<?php echo parent::link(array("action"=>"edit"),false); ?>",{"id":getSelectedRow(oTable)[0].childNodes[0].innerHTML});
        });
        $("#tabs-0 .btnAdd").click(function () {
        	$("#registerUserDialog").dialog("open");
       	});
        $("#tabs-0 .btnImport").click(function () {
        	callUrl("<?php echo parent::link(array("action"=>"import"),false); ?>");
       	});
        $("#tabs-0 .btnExport").click(function () {
        	callUrl("<?php echo parent::link(array("action"=>"export"),false); ?>");
     	});
	
        // regist user dialog
        $("#registerUserDialog").dialog({
            autoOpen: false, height:350, width:450, modal: true,
            buttons: {
                "Ok": function() {
                    $("#registerUserForm").submit();
                }, "Cancel": function() {
                    $( this ).dialog("close");
                }
            }
        });
        $( "#birthDate" ).datepicker();
        $( "#birthDate" ).datepicker("option", "showAnim", "blind");
        $( "#birthDate" ).datepicker({changeMonth: true, changeYear: true});
        </script>
        <?php
    }
    
    function printEditUserView ($moduleId,$id) {
        $user = UsersModel::getUser($id);
        ?>
        <div class="panel">
            
            <div id="accordion">
            
                <h3><a href="#">User Attributes:</a></h3>
                <div>
                    
                    <?php
                    InfoMessages::printInfoMessage("Here are the main user details");
                    ?>
                    <br/>
                    <div style="text-align:right;">
                        <input type="submit" onclick="$('#dialog-form-password').dialog('open'); return false;" value="Change Password" />
                        <a href="<?php echo parent::link(array("action"=>"editAttribs","id"=>$user->id,"object"=>$user->objectid)); ?>">Edit User Attributes</a> |
                        <a href="<?php echo parent::link(array("action"=>"configAttribs","id"=>$user->id,"object"=>$user->objectid)); ?>">Configure Attributes</a>
                    </div>
                    <br/>
                    <?php
                    DynamicDataView::displayObject("userAttribs", $user->objectid);
                    ?>
                    <br/>
                </div>


                <h3><a href="#">User Status:</a></h3>
                <div>
                    <?php
                    InfoMessages::printInfoMessage("Here you can change the users status for example if he is allowed to login with his account.");
                    ?>
                    <br/>
                    <table width="100%"><tr>
                        <td rowspan="2" valign="top" style="padding-right:100px;"><img src="resource/img/icons/Statistics.png" alt=""/></td>
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
                                    echo 'This user is active<br/>
                                        <button style="float:right;" onclick="callUrl(\''.NavigationModel::createModuleAjaxLink($moduleId,array("action"=>"deactivateUser","id"=>$this->id),false).'\');">Click to deactivate the user</button>';
                                } else {
                                    echo 'This user is not active<br/>
                                        <button style="float:right;"  onclick="callUrl(\''.NavigationModel::createModuleAjaxLink($moduleId,array("action"=>"activateUser","id"=>$this->id),false).'\');">Click to activate the user</button>';
                                }
                                ?>
                            </div>
                        </td></tr><tr><td>

                        </td></tr>
                    </tr></table>
                    <br/>
                </div>


                <h3><a href="#">User Roles:</a></h3>
                <div>
                    <form action="<?php echo parent::link(array("action"=>"saveRoles","user"=>$user->id)); ?>" method="post">
                        <?php
                        InfoMessages::printInfoMessage("Here you can edit the users roles in the system by assigning him a role group that you can configure in the roles adminstration module.");

                        $allRoles = RolesModel::getCustomRoles();
                        $userRoles = RolesModel::getUserCustomRoles($user->id);
                        ?>
                        <br/>

                        <?php 
                        // print user roles selection
                        if ($allRoles != null && count($allRoles) != 0) {
                            $allRolesArray = Common::toMap($allRoles, "id", "name");
                            $rolesSelection = Common::toMap($userRoles, "roleid","roleid");
                            InputFeilds::printMultiSelect("userRoles", $allRolesArray, $rolesSelection);
                        }
                        ?>

                        <br/><hr/>
                        <div>
                            <button id="createRole">Create a new Role</button>
                            <button id="saveRole" type="submit">Save</button>
                        </div>
                    </form>
                    
                    <br/>
                </div>
                
            </div>
        </div>
        
        <div id="dialog-form-roles" title="Create Role">
            <p class="validateTips">Enter the name of the role.</p>
            <form>
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
            </form>
        </div>
        
        <div id="dialog-form-password" title="Change Password">
            <p class="validateTips">Please enter the users new password in both feilds then click ok.</p>
            <form id="passwordForm" method="post" action="<?php echo parent::link(array("action"=>"changePassword","id"=>$user->id)); ?>">
                <label for="password1">Password:</label>
                <input type="password" name="password1" class="expand" id="password1" class="text ui-widget-content ui-corner-all" />
                <br/><br/>
                <label for="password2">Password:</label>
                <input type="password" name="password2" class="expand" id="password2" class="text ui-widget-content ui-corner-all" />
            </form>
        </div>
        
        <script type="text/javascript">
        $("#accordion").accordion({
            collapsible: true,
            icons : {
                header: "ui-icon-circle-arrow-e",
                headerSelected: "ui-icon-circle-arrow-s"
            }
        });

        $( "#dialog-form-roles" ).dialog({
            autoOpen: false, height: 300, width: 350, modal: true,
            buttons: {
                "Create Role": function() {
                    $( "#rolesAll" ).append( "<li class='ui-state-default'>"+$( "#name" ).val()+"</li>" );
                    $( "#rolesAll, #rolesAllowed" ).sortable({
                        connectWith: ".connectedSortable"
                    }).disableSelection();
                    $( this ).dialog( "close" );
                }, "Cancel": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        $( "#createRole" ).button().click(function() {
            $( "#dialog-form" ).dialog( "open" );
        });
        $( "#saveRole" ).button();
        $( "#accordion" ).accordion({
            autoHeight: false,
            navigation: true
        });
        $( "#dialog-form-password" ).dialog({
            autoOpen: false, height: 300, width: 350, modal: true,
            buttons: {
                "Ok": function(e) {
                    var pass1 = $( "#password1" ).val();
		    var pass2 = $( "#password2" ).val();
                    if (pass1 == pass2) {
                        $("#passwordForm").submit();
                    } else {
                        // validation error
			alert("passwords do not match!");
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