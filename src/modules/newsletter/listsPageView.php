<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'core/common.php';
require_once('core/plugin.php');
include_once 'modules/newsletter/listsPageModel.php';
include_once 'core/util/tinyMce.php';

class ListsPageView extends XModule {

    public $action;
    public $emailgroup;
    public $name;
    public $email;
    public $id;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        $this->getRequestVars();
        $listsModel = new EmailListModel();

        if (Context::hasRole("newsletter.emails.edit")) {

            switch (parent::getAction()) {
                case "savegroup":
                    $newGroupId = $listsModel->createEmailGroup($this->name);
		    parent::redirect(array("emailgroup"=>$newGroupId));
                    break;
                case "deletegroup":
                    $listsModel->deleteEmailGroup($this->emailgroup);
                    parent::redirect();
                    parent::blur();
                    break;
                case "newemail":
                    $listsModel->createInListByEmail($this->email, $this->emailgroup, $this->name);
                    parent::redirect(array("emailgroup"=>$this->emailgroup));
                    break;
                case "saveemail":
                    $listsModel->updateEmail($this->id, $this->email, $this->emailgroup, $this->name);
                    parent::redirect(array("emailgroup"=>$this->emailgroup));
                    break;
                case "delete":
                    $listsModel->deleteFromList($this->id);
                    parent::redirect(array("emailgroup"=>$this->emailgroup));
                    break;
                case "doimport":
                    $lines = explode("\n", $this->email);
                    for ($i=0; $i<count($lines); $i++) {
                        $lines[$i] = trim($lines[$i]);
                        if ($lines[$i] == "")
                            continue;
                        $parts = explode(",",$lines[$i]);
                        $name = trim($parts[0]);
                        $email = trim($parts[1]);
                        if ($name != "" && $email != "")
                            $listsModel->createInListByEmail($email, $this->emailgroup, $name);
                    }
                    parent::blur();
                    break;
                case "newgroup":
                    parent::focus();
                    break;
                case "new":
                    parent::focus();
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "import":
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

        if (Context::hasRole("newsletter.emails.edit")) {

            switch (parent::getAction()) {
                case "newgroup":
                    $this->printEditGroupView();
                    break;
                case "new":
                    $this->printEditView(null);
                    break;
                case "edit":
                    $this->printEditView($this->id);
                    break;
                case "import":
                    $this->printImportView($this->emailgroup);
                    break;
                default:
                    $this->printMainView();
            }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("newsletter.emails.edit");
    }


    function getRequestVars () {
        $this->action = null; if (isset($_GET['action'])) $this->action = $_GET['action'];
        $this->name = null; if (isset($_POST['name'])) $this->name = $_POST['name'];
        $this->email = null; if (isset($_POST['email'])) $this->email = $_POST['email'];
        $this->id = null; if (isset($_GET['id'])) $this->id = $_GET['id'];
        $this->emailgroup = null;
        if (isset($_GET['emailgroup'])) {
            $this->emailgroup = $_GET['emailgroup'];
        } else if (isset($_POST['emailgroup'])) {
            $this->emailgroup = $_POST['emailgroup'];
        }
    }

    function printMainView () {
    	?>
	<div id="emaillisttabs">
		<ul>
			<li><a href="#emailList-1">Email Lists</a></li>
			<li><a href="#emailList-2">Import List</a></li>
		</ul>
		<div id="emailList-1">
			<?php $this->printEmailListsView(); ?>
		</div>
		<div id="emailList-2">
			<?php $this->printImportView(); ?>
		</div>
	</div>
	<script>
	$("#emaillisttabs").tabs();
	</script>
	<?php
    }

    function printImportView () {
        ?>
        <div class="panel">
            <form name="articleForm" method="post" action="<?php echo parent::link(array("action"=>"doimport")); ?>">
                <div class="formFeildLine">
                    <b>Bitte f&uuml;gen Sie hier die Emails ein! Im Format: Name, Email - neue Zeile!</b>
                </div>
                <br/>
                <div class="formFeild">
                    <?php InputFeilds::printTextArea("email","","expand",4); ?>
                </div>
		<br/>
		<div class="formFeildLine">
                    <b>Please select the groups in whitch to import the email list</b>
                </div>
                <br/>
                <div class="formFeild">
                	<?php 
			InputFeilds::printMultiSelect("customroles",EmailListModel::getEmailGroups(),array());
			?>
                </div>
                <hr/>
                <div class="formFeildButtons" align="right">
                    <button type="submit">Speichern</button>
                    <button type="button" onclick="history.back(); return false;">Abbrechen</button>
                </div>
		<script>
		$(".formFeildButtons button").each(function(index,object){
			$(object).button();
		})
		</script>
            </form>
        </div>
        <?php
    }

    function printEmailListsView () {

        $emailGroups = EmailListModel::getEmailGroups();
	$emailGroupIds = array_keys($emailGroups);
        $emailGroup = $emailGroups[$emailGroupIds[0]];
	if (isset($_GET['emailgroup'])) {
		$emailGroup = $emailGroups[$_GET['emailgroup']];
	}
	
	InfoMessages::printInfoMessage("emailList.main");
            
      	// toolbar for email lists
        ?>
        <br/>
        <table width="100%"><tr><td>
        	Emailgruppe:
        </td><td class="expand">
                <select name="emailgroup" class="expand" onchange="callUrl(this.value);">
                    <?php
                    foreach ($emailGroups as $groupId => $groupName) {
                        ?>
                    	<option value="<?php echo parent::link(array("emailgroup"=>$groupId)); ?>" <?php if ($groupId == $this->emailgroup) echo "selected='true'"; ?>><?php echo Common::htmlEscape($groupName); ?></option>
                        <?php
                    }
                    ?>
                </select>
    	</td></tr></table>
	<hr/>
	<br/>
	<script>
        <?php
	
        echo "var ar_columns = [{'sTitle':'ID'},{'sTitle':'Name'},{'sTitle':'Email'},{'sTitle':'Confirmed'}];".PHP_EOL;
        // print table data
        echo "var ar_users = [";
        $users = EmailListModel::getEmailList($emailGroup);
        foreach ($users as $user) {
            if (!$b_first)
                echo ",";
            echo "['".Common::htmlEscape($user->id)."','".Common::htmlEscape($user->name)."','".Common::htmlEscape($user->email)."','".Common::htmlEscape($user->confirmed)."']".PHP_EOL;
            $b_first = false;
        }
        echo "];".PHP_EOL;
        ?>
        oTable = $('#usersTable').dataTable({
                    "sScrollY": "200px",
                    "bScrollCollapse": true,
                    "bPaginate": false,
                    "bJQueryUI": true,
                    "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                    "aaData": data,
                    "aoColumns": ar_columns
                });
                // if ( oTable.length > 0 ) {
                //     oTable.fnAdjustColumnSizing();
                // }
                oTable.click(function(event) {
                    $(oTable.fnSettings().aoData).each(function (){
                        $(this.nTr).removeClass('row_selected');
                    });
                    $(event.target.parentNode).addClass('row_selected');
                });
                $(".btnImport").click(function () {
                    var url = "<?php echo parent::link(array("action"=>"import"),false); ?>";
                    // url = url.replace(/selectedTab/g,selectedTab);
                    callUrl(url);
                });
                $(".btnExport").click(function () {
                    var url = "<?php echo parent::link(array("action"=>"export"),false); ?>";
                    // url = url.replace(/selectedTab/g,selectedTab);
                    callUrl(url);
                });
        </script>
        <?php
    }

    function printEditView ($pageId, $id) {

        $listsModel = new EmailListModel();
        if ($id != null) {
            $email = $listsModel->getEmail($id);
            $formAction = "saveemail";
        } else {
            $email = new Email("","",$this->emailgroup,"");
            $formAction = "newemail";
        }
        $emailGroups = $listsModel->getEmailGroups();

        ?>
        <div class="panel">
            <form method="post" action="index.php?<?php echo "page=$pageId&amp;action=$formAction&amp;id=$id"; ?>">
                <table class="expand"><tr>
                <td class="nowrap">Name: </td>
                <td class="expand"><input class="textbox" type="text" name="name" value="<?php echo $email->name ?>" /></td>
                </tr><tr>
                <td class="nowrap">Email Address: </td>
                <td class="expand"><input class="textbox" type="text" name="email" value="<?php echo $email->email ?>" /></td>
                </tr><tr>
                <td class="nowrap">Emailgruppe: </td>
                <td class="expand">
                    <select class="textbox" name="emailgroup">
                        <?php
                        for ($i=0; $i<count($emailGroups); $i++) {
                            ?>
                            <option value="<?php echo $emailGroups[$i]->id ?>" <?php if ($emailGroups[$i]->id == $email->emailgroup) echo "selected='true'"; ?>><?php echo $emailGroups[$i]->name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                </tr></table>
                <hr/>
                <div class="formFeildButtons" align="right">
                    <button type="submit" class="button">Speichern</button>
                    <button type="submit" class="button" style="margin-left:6px;" onclick="history.back(); return false;">Abbrechen</button>
                </div>
            </form>
        </div>
        <?php
    }
}

?>