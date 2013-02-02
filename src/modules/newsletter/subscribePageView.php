<?php

require_once 'core/common.php';
require_once 'core/plugin.php';
require_once 'modules/newsletter/listsPageModel.php';
require_once 'modules/newsletter/subscribePageModel.php';
require_once 'core/util/tinyMce.php';

class SubscribePageView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        if (Context::hasRole("newsletter.subscribe.edit")) {

            switch (parent::getAction()) {
                case "update":
			parent::param('emailtext',$_POST['emailtext']);
			parent::param('emailsent',$_POST['emailsent']);
			parent::param('confirmed',$_POST['confirmed']);
			parent::param('customroles',$_POST['customroles']);
			parent::param('expiredays', $_POST['expiredays']);
			parent::param('subject', $_POST['subject']);
			parent::param('from', $_POST['from']);
			parent::param('subaction', $_POST['subaction']);
			parent::blur();
			parent::redirect();
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "cancel":
                    parent::blur();
                    break;
            }
        }

        switch (parent::getAction()) {
	    case "unsubscribe":
		
            case "subscribe":
		$emailId = NewsletterSubscribeModel::subscribe($_POST['email'],$_POST['name'],parent::param('customroles'));
		ConfirmModel::sendConfirmation ($_POST['email'], parent::param("subject"), parent::param("emailtext"), parent::param("from"), parent::getId(), array("action"=>"confirm","emailid"=>$emailId), parent::param("expiredays"));
                parent::redirect(array("action"=>"subscribed"));
                break;
            case "confirm":
		NewsletterSubscribeModel::confirmSubscribe($_GET['emailid']);
                parent::redirect(array("action"=>"confirmed"));
                break;
            case "confirmed":
                parent::focus();
                break;
            case "subscribed":
                parent::focus();
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("newsletter.subscribe.edit")) {
                    $this->printEditView(parent::getId());
                    break;
                }
            case "confirmed":
                $this->printConfirmedView(parent::getId());
                break;
            case "subscribed":
                $this->printSubscribeView(parent::getId());
                break;
            default:
                $this->printMainView(parent::getId());
        }
    }


    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("newsletter.subscribe.edit");
    }

    function printMainView ($pageId) {
        ?>
        <div class="panel">
            <?php
	    if (parent::param('subaction') == 0) {
  	    	?>
	    	<form method="post" action="<?php parent::link(array("action"=>"subscribe")); ?>">
                	<table width="100%"><tr><td>
                    	Name:
                	</td><td class="expand">
                    	<input type="text" name="name" class="textbox"/>
                	</td></tr><tr><td>
                    	Email:
                	</td><td class="expand">
                    	<input type="text" name="email" class="textbox"/>
                	</td></tr>
                	<tr><td></td><td class="expand" align="right">
                    	<button class="btnSubscribe" type="submit" class="button">Abschicken</button>
                	</td></tr></table>
            	</form>
	    	<?php
	    } else {
		?>
	    	<form method="post" action="<?php parent::link(array("action"=>"unsubscribe")); ?>">
                	<table width="100%"><tr><td>
                    	Email:
                	</td><td class="expand">
                    	<input type="text" name="email" class="textbox"/>
                	</td></tr>
                	<tr><td></td><td class="expand" align="right">
                    	<button class="btnSubscribe" type="submit" class="button">Abschicken</button>
                	</td></tr></table>
            	</form>
	    	<?php
	    }
	    ?>
            <script>
            $(".btnSubscribe").each(function(index,object){
		$(object).button();
            });
            </script>
        </div>
        <?php
    }

    function printEditView ($pageId) {
        
        InfoMessages::printInfoMessage("newsletter.subscribe.edit");
        ?>
        <br/>
        <div class="panel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                
		<div class="formFeildLine">
                    <b>Settings</b>
                </div>
                <br/>
		<table width="100%"><tr>
		<td class="contract nowrap">Email Subject: </td>
		<td class="expand"><?php InputFeilds::printTextFeild("subject",parent::param('subject'),"expand"); ?></td>
		</tr><tr>
		<td class="contract nowrap">Email Sender: </td>
		<td class="expand"><?php InputFeilds::printTextFeild("from",parent::param('from'),"expand"); ?></td>
		</tr><tr>
		<td class="contract nowrap">Expire days: </td>
		<td class="expand"><?php InputFeilds::printTextFeild("expiredays",parent::param('expiredays'),"expand"); ?></td>
		</tr><tr>
		<td class="contract nowrap">Action: </td>
		<td class="expand"><?php InputFeilds::printSelect("subaction",parent::param('subaction'),array("0"=>"Subscribe","1"=>"Unsubscribe")); ?></td>
		</tr></table>
		<br/>
		<div class="formFeildLine">
                    <b>Emailgruppe</b>
                </div>
                <br/>
                <div class="formFeild">
                    <?php
			InputFeilds::printMultiSelect("customroles",EmailListModel::getEmailGroups(),Common::toMap(parent::param("customroles")));
                    ?>
                </div>
                <br/>
                <div class="formFeildLine">
                    <b>Diese Seite der Sende-Best&auml;tigung mit dem Editor &auml;ndern</b>
                </div>
                <br/>
                <div class="formFeild">
                    <?php
			InputFeilds::printHtmlEditor("emailsent", parent::param("emailsent"));
                    ?>
                </div>
                <br/>
                <div class="formFeildLine">
                    <b>Diese Seite der Email-Best&auml;tigung mit dem Editor &auml;ndern</b>
                </div>
                <br/>
                <div class="formFeild">
                    <?php
                    InputFeilds::printHtmlEditor("emailtext", parent::param("emailtext"));
                    ?>
                </div>
                <br/>
                <div class="formFeildLine">
                    <b>Diese Seite der erfolgreich Abgemeldeten mit dem Editor &auml;ndern</b>
                </div>
                <br/>
                <div class="formFeild">
                    <?php
                    InputFeilds::printHtmlEditor("confirmed", parent::param("confirmed"));
                    ?>
                </div>
                <hr noshade/>
                <div class="formFeildButtons" align="right">
                    <button type="submit">Speichern</button>
                    <button type="button" onclick="history.back();">Abbrechen</button>
                </div>
		<script>
		$(".formFeildButtons button").each(function(index,object){
			$(object).button();
		});
		</script>
            </form>
        </div>
        <?php
    }

    function printSubscribeView($pageId) {
        ?>
        <div class="panel">
            <?php echo parent::param("emailsent"); ?>
        </div>
        <?php
    }

    function printConfirmedView($pageId) {
        ?>
        <div class="panel">
            <?php echo parent::prama("confirmed"); ?>
        </div>
        <?php
    }
}

?>