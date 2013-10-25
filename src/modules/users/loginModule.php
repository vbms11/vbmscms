<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'core/common.php';
require_once('core/plugin.php');
require_once 'core/model/usersModel.php';

class LoginModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            case "edit":
                parent::focus();
                break;
            case "login":
                if (UsersModel::login($_POST['username'],$_POST['password'])) {
                    parent::focus();
                    // NavigationModel::redirectModule(parent::getId(), array("action"=>"welcome"));
                    if (NavigationModel::hasNextAction()) {
                        NavigationModel::redirectNextAction();
                    } else {
                        NavigationModel::redirect();
                    }
                } else {
                    parent::focus();
                    parent::redirect(array("action"=>"bad"));
                }
                exit;
                break;
            case "logout":
                parent::focus();
                UsersModel::logout();
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "logout":
                $this->printLoggedOutView();
                break;
            case "welcome":
                $this->printLoggedInView();
                break;
            case "bad":
                $this->printBadView();
                break;
            case "forgot":
                $this->printForgotView();
                break;
            default:
                if (Context::isLoggedIn()) {
                    $this->printLogoutConfirmView();
                } else {
                    $this->printLoginView();
                }
                break;
        }
    }

    function getRoles () {
        return array("login.edit");
    }

    static function getTranslations () {
        return array(
            "en" => array(
                "login.email"           => "Enter your email address:",
                "login.reset"           => "Reset Password",
                "login.cancel"          => "Cancel",
                "login.invalid"         => "Username / Password invalid.",
                "login.success"         => "Welcome %1% your login was successful",
                "login.logout.success"  => "You are logged out!",
                "login.logout.confirm"  => "Are you sure you want to logout user %1%?",
                "login.logout"          => "Logout",
                "login.login"           => "Login, I am already customer",
                "login.username"        => "Username:",
                "login.password"        => "Password:",
                "login.register"        => "Register, I am a new customer"
            ),
            "de" => array(
                "login.email"           => "Geben sie eine Emailadresse ein:",
                "login.reset"           => "Passwort zurücksetzen",
                "login.cancel"          => "Abbrechen",
                "login.invalid"         => "Benutzername oder Kennwort falsch.",
                "login.success"         => "Willkommen %1% Sie haben sich erfolgreich angemeldet",
                "login.logout.success"  => "Sie sind abgemeldet!",
                "login.logout.confirm"  => "Sind sie sicher dass Sie sich als Benutzer %1% abmelden wollen?",
                "login.logout"          => "Abmelden",
                "login.login"           => "Anmelden, ich bin schon Kunde",
                "login.username"        => "Benutzername:",
                "login.password"        => "Passwort:",
                "login.register"        => "Registrieren, ich bin ein neuer Kunde"
            ));
    }

    function printForgotView () {
        ?>
        <div class="panel loginPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"login")); ?>">
            	<table width="100%"><tr><td class="contract nowrap">
                    <?php echo parent::getTranslation("login.email"); ?>
                </td><td class="expand">
                    <input class="textbox" type="textbox" name="email" />
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" id="reset"><?php echo parent::getTranslation("login.reset"); ?></button>
                    <button type="button" id="register" onclick="callUrl('<?php echo parent::link(); ?>');"><?php echo parent::getTranslation("login.cancel"); ?></button>
                </div>
            </form>
            <script>
            $(".loginPanel button").button();
            </script>
        </div>
        <?php
    }

    function printBadView () {
        ?>
        <div class="panel loginPanel loginFailPanel">
            <?php echo parent::getTranslation("login.invalid"); ?>
        </div>
        <?php
    }

    function printLoggedInView () {
        ?>
        <div class="panel loginPanel loginSuccessPanel">
            <?php
            $text = parent::getTranslation("login.success");
            $text = str_replace("%1%", Context::getUsername(), $text);
            echo $text;
            ?>
        </div>
        <?php
    }

    function printLoggedOutView () {
        ?>
        <div class="panel loginPanel loginLogoutPanel">
            <?php echo parent::getTranslation("login.logout.success"); ?>
        </div>
        <?php
    }
    
    function printLogoutConfirmView () {
        ?>
        <div class="panel">
            <form id="loginForm" name="loginForm" method="post" action="<?php echo parent::link(array("action"=>"logout")); ?>">
                <?php
                $text = parent::getTranslation("login.logout.confirm");
                $text = str_replace("%1%", Context::getUsername(), $text);
                echo $text;
                ?>
                <br/><br/>
                <hr/>
                <div style="text-align: right;">
                    <button type="submit" name="login"><?php echo parent::getTranslation("login.logout"); ?></button>
                    <button type="button" onclick="callUrl('<?php echo NavigationModel::createPageLink(); ?>');" name="cancel"><?php echo parent::getTranslation("login.cancel"); ?></button>
                </div>
            </form>
            <script>
            $("#loginForm button").button();
            </script>
        </div>
        <?php
    }
    
    function printLoginView () {
        ?>
        <div class="panel loginPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"login")); ?>">
                <table width="100%"><tr><td class="contract">
                    <?php echo parent::getTranslation("login.username"); ?>
                </td><td class="expand">
                    <input class="textbox" type="textbox" name="username" />
                </td></tr><tr><td class="contract">
                    <?php echo parent::getTranslation("login.password"); ?>
                </td><td class="expand">
                    <input class="textbox" type="password" name="password" />
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" id="login"><?php echo parent::getTranslation("login.login"); ?></button>
                    <button type="button" id="register" onclick="callUrl('<?php echo parent::staticLink("register"); ?>');"><?php echo parent::getTranslation("login.register"); ?></button>
                    <button type="button" id="forgot" onclick="callUrl('<?php echo parent::link(array("action"=>"forgot")); ?>');"><?php echo parent::getTranslation("login.reset"); ?></button>
                </div>
            </form>
            <script>
            $(".loginPanel button").button();
            </script>
        </div>
        <?php
    }
}

?>