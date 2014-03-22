<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('core/plugin.php');
require_once('core/model/usersModel.php');
require_once('core/lib/facebook/facebook.php');
require_once('core/lib/openid/openid.php');

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
                parent::blur();
                break;
            case "facebookLogin":
                $site = Context::getSite();
                $facebook = new Facebook(array(
                    'appId'  => $site->facebookappid,
                    'secret' => $site->facebooksecret,
                ));
                $user = $facebook->getUser();
                if ($user) {
                    try {
                        $user_profile = $facebook->api('/me');
                        $userByEmail = UsersModel::getUserByEmail($user_profile['email']);
                        if (!empty($userByEmail) && empty($userByEmail->facebookid)) {
                            UsersModel::setFacebookId($user_profile['id']);
                        }
                        $user = UsersModel::loginWithFacebookId($user_profile['id']);
                        if ($user) {
                            if ($user->email != $user_profile['email'] || 
                                $user->firstname != $user_profile['first_name'] || 
                                $user->lastname != $user_profile['last_name'] || 
                                (($user->gender == "1" && $user_profile['gender'] != "male") ||
                                ($user->gender == "0" && $user_profile['gender'] != "female"))) {
                                UsersModel::saveUser($user->id, $user->username, $user_profile['first_name'], $user_profile['last_name'], null, $user_profile['email'], Common::toUiDate($user->birthdate));
                            }
                            parent::redirect(array("action"=>"welcome"));
                        } else {
                            $_SESSION['register.user'] = $user_profile;
                            NavigationModel::redirectStaticModule("register",array("type"=>"facebook"));
                        }
                    } catch (FacebookApiException $e) {
                        error_log($e);
                        $user = null;
                        parent::focus();
                        parent::redirect(array("action"=>"bad"));
                    }
                } else {
                    parent::focus();
                    NavigationModel::redirect($facebook->getLoginUrl(),false);
                }
                break;
            case "googleLogin":
                try {
                    $site = Context::getSite();
                    $openid = new LightOpenID($site->url);
                    if(!$openid->mode) {
                        $openid->identity = 'https://www.google.com/accounts/o8/id';
                        $openid->required = array(
                            'contact/email' , 
                            'namePerson/first' , 
                            'namePerson/last' , 
                            'pref/language' , 
                            'contact/country/home'
                        );
                        NavigationModel::redirect($openid->authUrl(),false);
                    } elseif($openid->mode == 'cancel') {
                        parent::redirect();
                    } else {
                        if ($openid->validate()) {
                            $openIdAttributes = $openid->getAttributes();
                            $user = UsersModel::loginWithEmail($openIdAttributes['contact/email']);
                            if ($user) {
                                if ($user->firstname != $openIdAttributes['namePerson/first'] || 
                                    $user->lastname != $openIdAttributes['namePerson/last']) {
                                    UsersModel::saveUser($user->id, $user->username, $openIdAttributes['namePerson/first'], $openIdAttributes['namePerson/last'], null, $user->email, Common::toUiDate($user->birthdate));
                                }
                                parent::redirect(array("action"=>"welcome"));
                            } else {
                                $_SESSION['register.user'] = $openIdAttributes;
                                NavigationModel::redirectStaticModule("register",array("type"=>"google"));
                            }
                        } else {
                            parent::redirect();
                        }
                    }
                } catch(ErrorException $e) {
                    echo $e->getMessage();
                }
                break;
            case "twitterLogin":
                break;
            case "login":
                if (UsersModel::login($_POST['username'],$_POST['password'])) {
                    parent::focus();
                    if (NavigationModel::hasNextAction()) {
                        NavigationModel::redirectNextAction();
                    } else {
                        parent::redirect(array("action"=>"welcome"));
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
            case "edit":
                $this->printEditView();
                break;
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
    
    function getStyles() {
        return array("css/login.css");
    }
    
    function printEditView () {
        
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
            $user = Context::getUser();
            $text = parent::getTranslation("login.success");
            $text = str_replace("%1%", $user->username, $text);
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
                $user = Context::getUser();
                $text = parent::getTranslation("login.logout.confirm");
                $text = str_replace("%1%", $user->username, $text);
                echo $text;
                ?>
                <br/><br/>
                <hr/>
                <div style="text-align: right;">
                    <button type="submit" class="jquiButton" name="login"><?php echo parent::getTranslation("login.logout"); ?></button>
                    <button type="button" class="jquiButton" onclick="callUrl('<?php echo NavigationModel::createPageLink(); ?>');" name="cancel"><?php echo parent::getTranslation("login.cancel"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function printLoginView () {
        ?>
        <div class="panel loginPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"login")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("login.openId"); ?>
                </td><td>
                    <a class="googleLoginButton" href="<?php echo parent::link(array("action"=>"googleLogin"),true,true); ?>"></a>
                    <a class="facebookLoginButton" href="<?php echo parent::link(array("action"=>"facebookLogin"),true,true); ?>"></a>
                </td></tr><tr><td>
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
                    <button type="button" class="jquiButton" id="register" onclick="callUrl('<?php echo parent::staticLink("register"); ?>');"><?php echo parent::getTranslation("login.register"); ?></button>
                    <button type="button" class="jquiButton" id="forgot" onclick="callUrl('<?php echo parent::link(array("action"=>"forgot")); ?>');"><?php echo parent::getTranslation("login.reset"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
}

?>