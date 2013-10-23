<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('core/common.php');
require_once('core/plugin.php');
require_once('core/model/usersModel.php');
require_once('modules/forum/forumPageModel.php');


class MessagePageView extends XModule {

    function onProcess () {
        
        switch ($this->getAction()) {
            case "delete":
                ForumPageModel::deletePm($_GET['message']);
                setFocusedArea(null);
                NavigationModel::redirectPage(Context::getPageId());
                break;
            case "send":
                $userNameEnd = stripos($_POST['dstuser'], "-");
                if ($userNameEnd == -1) {
                    $userName = $_POST['dstuser'];
                } else {
                    $userName = trim(substr($_POST['dstuser'], 0, $userNameEnd-1));
                }
                $user = UsersModel::getUserByUserName($userName);
                ForumPageModel::savePm(Context::getUserId(), $user->id, $_POST['subject'], $_POST['message']);
                setFocusedArea(null);
                NavigationModel::redirectPage(Context::getPageId());
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        if (Context::hasRole(array("message.inbox"))) {
            switch ($this->getAction()) {
                case "new":
                    $this->printCreateMessageView();
                    break;
                default:
                    $this->printMainView();
            }
        }
    }
    
    function getRoles () {
        return array("message.inbox");
    }
    
    function getStyles () {
        return array("css/message.css");
    }

    function printMainView () {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        $message = null;
        if (isset($_GET['message']))
            $message = ForumPageModel::getPm($_GET['message']);
        ?>
        <div class="panel viewMessagePanel">
            <div>
                <div style="float:right;">
                    <button id="btnNew" onclick="callUrl('<?php echo NavigationModel::createModuleLink($this->getId(), array("action"=>"new"), false); ?>');">New Message</button>
                    <button id="btnDelete">Delete Message</button>
                </div>
                <h3>Messages:</h3>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="messages"></table>
                <hr/>
            </div>
            <?php
            if ($message != null) {
                ?>
                <div class="messageDiv">
                    <div class="messageTitleDiv">
                        <div style="float:right;">
                            <button id="btnReply">Reply</button>
                        </div>
                        From: <?php echo $message->srcusername; ?> - 
                        To: <?php echo $message->dstusername; ?> | 
                        Date: <?php echo $message->senddate; ?> 
                        <br/>
                        Title: <b><?php echo $message->subject; ?></b>
                    </div>
                    <div class="messageTextDiv">
                        <?php echo nl2br($message->message); ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <script type="text/javascript">
        var userMessages = [
            <?php
            $messages = ForumPageModel::getPms(Context::getUserId());
            $first = true;
            foreach ($messages as $message) {
                if (!$first)
                    echo ",";
                echo "['".Common::htmlEscape($message->id)."','".Common::htmlEscape($message->srcusername)."','".Common::htmlEscape($message->subject)."','".Common::htmlEscape($message->senddate)."']";
                $first = false;
            }
            ?>
        ];
        $(function() {
            var oTable = $('#messages').dataTable({
                "bScrollCollapse": false,
                "sScrollY": 200,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 40, -1], [10, 20, 40, "All"]],
                "aaData": userMessages,
                "aoColumns": [
                    {'sTitle':'ID','bVisible': true},
                    {'sTitle':'From',"sClass": "contract"},
                    {'sTitle':'Subject',"sClass": "expand",'fnRender': function(obj) {
                        return "<a onclick=\"callUrl(\'<?php echo parent::link(); ?>\',{\'message\' : \'"+obj.aData[0]+"\'});\">"+obj.aData[obj.iDataColumn]+"</a>";
                    }},
                    {'sTitle':'Date',"sClass": "contract"}]
            });
            $("#messages tbody").click(function(event) {
                $(oTable.fnSettings().aoData).each(function (){
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
            });
            $("#btnDelete").click(function(event) {
                var emailId = getSelectedRow(oTable)[0].childNodes[0].innerHTML;
                callUrl('<?php echo NavigationModel::createModuleLink($this->getId(), array("action"=>"delete"), false); ?>',{"message" : emailId});
            });
            $("#btnReply").click(function(event) {
                callUrl('<?php echo NavigationModel::createModuleLink($this->getId(), array("action"=>"new"), false); ?>',{"message" : "<?php echo $message->id; ?>"});
            });
        });
        </script>
        <?php
    }
    
    function printCreateMessageView () {
        ?>
        <style>
	.ui-autocomplete {
		max-height: 150px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 100px;
	}
	</style>
        <div class="panel createMessagePanel">
            <?php
            InfoMessages::printInfoMessage("Fill out the form and click send. an additional email will be delivered to the email address of the receiver!");
            ?>
            <h3>Create Private Message:</h3>
            <form name="createMessageForm" method="post" action="<?php echo parent::link(array("action"=>"send")); ?>">
                Destination User:<br/>
                <input type="textbox" class="expand" name="dstuser" id="dstuser"/>
                <br/><br/>
                Message title:<br/>
                <input class="expand" name="subject" type="textbox"/>
                <br/><br/>
                Message Content:<br/>
                <textarea class="expand" name="message" cols="4" rows="4"></textarea>
                <br/><hr/>
                <div align="right">
                    <input type="submit" value="Send Message"/> 
                    <input type="button" value="Cancel" onclick="history.back();"/>
                </div>
            </form>
            <?php
            if (isset($_GET['message'])) {
                $message = ForumPageModel::getPm($_GET['message']);
                ?>
                <h3>Original Message:</h3>
                <div class="messageDiv">
                    <div class="messageTitleDiv">
                        From: <?php echo $message->srcusername; ?> - 
                        To: <?php echo $message->dstusername; ?> | 
                        Date: <?php echo $message->senddate; ?> 
                        <br/>
                        Title: <b><?php echo $message->subject; ?></b>
                    </div>
                    <div class="messageTextDiv">
                        <?php echo nl2br($message->message); ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <script type="text/javascript">
        var ar_users = [
            <?php
            $users = UsersModel::getUsers();
            $b_first = true;
            foreach ($users as $user) {
                if ($user->active) {
                    if (!$b_first)
                        echo ",";
                    echo "'".$user->username." - ".$user->firstname." ".$user->lastname."'";
                    $b_first = false;
                }
            }
            ?>
        ];
        $(function() {
            $( "#dstuser" ).autocomplete({
                source: ar_users
            });
        });
        </script>
        <?php
    }
    
}

?>