<?php

require_once('core/plugin.php');

class LogoutModule extends XModule {
    
    function onProcess () {

        switch (parent::getAction()) {
            case "edit":
                parent::focus();
                break;
            case "save":
                parent::param("success", parent::post("success") ? parent::post("success") : null);
                parent::blur();
                break;
            case "logout":
                UsersModel::logout();
                parent::blur();
                if (parent::param("success")) {
                    NavigationModel::redirectPage(parent::param("success"));
                }
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
	
        switch (parent::getAction()) {
            case "edit":
                $this->printEditView();
                break;
            case "logout":
                $this->printLogoutConfirmView();
                break;
            default:
                if (Context::isLoggedIn()) {
                    $this->printLogoutConfirmView();
                }
                break;
        }
    }

    function getRoles () {
        return array("login.edit");
    }
    
    function getStyles() {
        return array("css/login.css");
    }
    
    function printEditView () {
        ?>
        <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
            <table class="formTable"><tr>
                <td><?php echo parent::getTranslation("login.edit.success"); ?></td>
                <td><?php InputFeilds::printSelect("success",parent::param("success"), Common::toMap(PagesModel::getPages(Context::getLang()), "id", "name")); ?></td>
            </tr></table>
            <hr/>
            <div class="alignRight">
                <button class="jquiButton" type="submit"><?php echo parent::getTranslation("common.save"); ?></button>
            </div>
        </form>
        <?php
    }
    
    function printLoggedOutView () {
        ?>
        <div class="panel logoutPanel loggedOutPanel">
            <?php echo parent::getTranslation("login.logout.success"); ?>
        </div>
        <?php
    }
    
    function printLogoutConfirmView () {
        ?>
        <div class="panel">
            <form id="loginForm" name="loginForm" method="post" action="<?php echo parent::link(array("action"=>"logout")); ?>">
                <?php
                $user = Context::getUser();
                $text = parent::getTranslation("login.logout.confirm");
                $text = str_replace("%1%", $user->username, $text);
                echo $text;
                ?>
                <br/><br/>
                <hr/>
                <div style="text-align: right;">
                    <button type="submit" class="jquiButton" name="login"><?php echo parent::getTranslation("login.logout"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
}
