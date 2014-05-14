<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('core/plugin.php');
require_once 'core/model/usersModel.php';

class LoginModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
	    case "save":
		if (Context::hasRole("login.reset.edit")) {
			parent::param("from",$_POST['from']);
			parent::param("subject",$_POST['subject']);
			parent::param("emailText",$_POST['emailText']);
		}
		break;
            case "reset":
		$user = UsersModel::getUserByEmail($_POST['email']);
		if ($user != null) {
			$newPassword = Common::randHash(9);
			UsersModel::setPassword($newPassword);
			$emailText = parent::param("emailText");
			$emailText = str_replace("&tl;password&gt;",$newPassword,$emailText);
			EmailUtil::sendHtmlEmail($_POST['email'],parent::param("subject"),$emailText,parent::param("from"));
		}
                break;
            case "confirm":
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
	    case "edit":
		if (Context::hasRole("login.reset.edit")) {
			$this->printEditView();
		}
		break;
            default:
              	$this->printResetPasswordView();
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("login.reset.edit");
    }

    function printResetPasswordView () {
	?>
        <div class="panel resetPasswordPanel">
            <h1><?php echo parent::getTranslation("reset.title"); ?></h1>
            <p><?php echo parent::getTranslation("reset.description"); ?></p>
            <form method="post" action="<?php echo parent::link(array("action"=>"reset")); ?>">
            	<table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("reset.label.email"); ?>
           	</td><td>
                    <input type="textbox" name="<?php echo parent::alias("email"); ?>" />
         	</td></tr></table>
           	<hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("reset.botton.submit"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }

    function printEditView () {
        ?>
        <div class="panel resetPasswordPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <div>
                    Email sender
                </div>
                <div>
                    <?php InputFeilds::printTextFeild("from",parent::param("from")); ?>
                </div>
                <div>
                    Email subject
                </div>
                <div>
                    <?php InputFeilds::printTextFeild("subject",parent::param("subject")); ?>
                </div>
                <div>
                    Reset passwod email text. &tl;password&gt; is replaced with the password, 
                </div>
                <div>
                    InputFeilds::printHtmlEditor("resetConfirmText","<?php echo parent::param("resetConfirmText"); ?>");
                </div>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
}

?>