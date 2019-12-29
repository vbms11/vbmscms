<?php

require_once('core/plugin.php');

class LoginModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            case "edit":
                parent::focus();
                break;
            case "save":
                parent::param("register", parent::post("register") == "1" ? true : false);
                parent::param("reset", parent::post("reset") == "1" ? true : false);
                parent::param("success", parent::post("success"));
                parent::blur();
                break;
            case "register":
                unset($_SESSION['register.user']);
                NavigationModel::redirectStaticModule("register");	
                break;
            case "login":
                if (UsersModel::login($_POST['username'],$_POST['password'])) {
                    //parent::focus();
                    if (NavigationModel::hasNextAction()) {
                        NavigationModel::redirectNextAction();
                    } else {
                        //NavigationModel::redirectStaticModule("userProfile",array("userId"=>Context::getUserId()));
                        NavigationModel::redirectPage(parent::param("success"));
                    }
                } else {
                    parent::redirect(array("action"=>"bad"));
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
            case "welcome":
                $this->printLoggedInView();
                break;
            case "forgot":
                if (parent::param("reset")) {
                    $this->printForgotView();
                }
                break;
            case "bad":
                $this->printBadView();
            default:
                if (!Context::isLoggedIn()) {
                    $this->printLoginView();
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
                <td><?php echo parent::getTranslation("login.edit.register"); ?></td>
                <td><?php InputFeilds::printCheckbox("register"); ?></td>
            </tr><tr>
                <td><?php echo parent::getTranslation("login.edit.reset"); ?></td>
                <td><?php InputFeilds::printCheckbox("reset"); ?></td>
            </tr><tr>
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
                    <button type="submit" class="jquiButton" id="reset"><?php echo parent::getTranslation("login.reset"); ?></button>
                    <button type="button" class="jquiButton" id="register" onclick="callUrl('<?php echo parent::link(); ?>');"><?php echo parent::getTranslation("login.cancel"); ?></button>
                </div>
            </form>
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
            $user = Context::getUser();
            $text = parent::getTranslation("login.success");
            $text = str_replace("%1%", $user->username, $text);
            echo $text;
            ?>
        </div>
        <?php
    }
    
    function printLoginView () {
        ?>
        <div class="panel loginPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"login")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("login.username"); ?>
                </td><td>
                    <input type="text" class="expand" name="username" />
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("login.password"); ?>
                </td><td>
                    <input type="password" class="expand" name="password" />
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton" id="login"><?php echo parent::getTranslation("login.login"); ?></button>
                    <?php
                    if (parent::param("register")) {
                        ?>
                        <button type="button" class="jquiButton" id="register" onclick="callUrl('<?php echo parent::link(array("action"=>"register")); ?>');"><?php echo parent::getTranslation("login.register"); ?></button>
                        <?php
                    }
                    if (parent::param("reset")) {
                        ?>
                        <button type="button" class="jquiButton" id="forgot" onclick="callUrl('<?php echo parent::link(array("action"=>"forgot")); ?>');"><?php echo parent::getTranslation("login.reset"); ?></button>
                        <?php
                    }
                    ?>
                </div>
            </form>
        </div>
        <?php
    }
}
