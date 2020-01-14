<?php

require_once('core/plugin.php');
require_once('core/lib/facebook/facebook.php');
// require_once('core/lib/openid/openid.php');
require_once("core/lib/Google/src/Google/Client.php");

class LoginNetworksModule extends XModule {

    const network_facebook = 1;
    const network_google = 2;
    const network_twitter = 3;
    
    function onProcess () {

        switch (parent::getAction()) {
            case "edit":
                parent::focus();
                break;
            case "save":
                parent::param("networks", parent::post("networks"));
                parent::param("t_page", "success", parent::post("success"));
                parent::blur();
                break;
            case "facebookLogin":
                $site = Context::getSite();
                $facebook = new Facebook(array(
                    'appId'  => $site->facebookappid,
                    'secret' => $site->facebooksecret,
                ));
                $userLogin = $facebook->getUser();
                if ($userLogin) {
                    try {
                        $user_profile = $facebook->api('/me');
                        $userByEmail = UsersModel::getUserByEmail($user_profile['email']);
                        if (!empty($userByEmail) && empty($userByEmail->facebook_uid)) {
                            UsersModel::setFacebookId($userByEmail->id, $user_profile['id']);
                        }
                        $userLogin = UsersModel::loginWithFacebookId($user_profile['id']);
                        if ($userLogin) {
                            if ($userByEmail->email != $user_profile['email'] || 
                                $userByEmail->firstname != $user_profile['first_name'] || 
                                $userByEmail->lastname != $user_profile['last_name'] || 
                                (($userByEmail->gender == "1" && $user_profile['gender'] != "male") ||
                                ($userByEmail->gender == "0" && $user_profile['gender'] != "female"))) {
                                $gender = $user_profile['gender'] == "male" ? "1" : "0";
                                UsersModel::saveUser($userByEmail->id, $userByEmail->username, $user_profile['first_name'], $user_profile['last_name'], null, $user_profile['email'], Common::toUiDate($userByEmail->birthdate), null, $gender);
                            }
                            NavigationModel::redirectPage(parent::param("success"));
                        } else {
                            $_SESSION['register.user'] = $user_profile;
                            NavigationModel::redirectStaticModule("register",array("type"=>"facebook"));
                        }
                    } catch (FacebookApiException $e) {
                        error_log($e);
                        $userLogin = null;
                        parent::redirect(array("action"=>"bad"));
                    }
                } else {
                    parent::focus();
                    NavigationModel::redirect($facebook->getLoginUrl(array('scope'=>'email')),false);
                }
                break;
            case "googleLogin":
                try {
			
			$site = Context::getSite();
			$redirect = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."?static=login&action=googleLogin";

			$client = new Google_Client();
			$client->setClientId($site->googleclientid);
			$client->setClientSecret($site->googleclientsecret);
			$client->setRedirectUri($redirect);
			$client->addScope(array("https://www.googleapis.com/auth/userinfo.email"));
			
			if (isset($_GET['code'])) {
                            $client->authenticate($_GET['code']);
                            $_SESSION['access_token'] = $client->getAccessToken();
                            
                            $client->setAccessToken($_SESSION['access_token']);
                            $userInfo = $client->verifyIdToken()->getAttributes();
                            
                            $userLogin = UsersModel::loginWithEmail($userInfo['payload']['email']);

                            if ($userLogin) {
                                NavigationModel::redirectPage(parent::param("success"));
                            } else {
                                $_SESSION['register.user'] = $userInfo['payload'];
                                NavigationModel::redirectStaticModule("register",array("type"=>"google"));
                            }
                        } else {
                            NavigationModel::redirect($client->createAuthUrl(),false);
                        }

                } catch(ErrorException $e) {
                    echo $e->getMessage();
                }

                break;
            case "twitterLogin":
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
            default:
                $this->printLoginView();
                break;
        }
    }

    function getRoles () {
        return array("login.edit");
    }
    
    function getStyles() {
        return array("css/loginNetworks.css");
    }
    
    function printEditView () {
        ?>
        <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
            <table class="formTable"><tr>
                <td><?php echo parent::getTranslation("login.edit.success"); ?></td>
                <td><?php InputFeilds::printSelect("success",parent::param("success"), Common::toMap(PagesModel::getPages(Context::getLang()), "id", "name")); ?></td>
            </tr><tr>
                <td><?php echo parent::getTranslation("login.edit.networks"); ?></td>
                <td><?php 
                    $options = array(
                        self::network_facebook => "facebook",
                        self::network_google => "google",
                        self::network_twitter => "twitter"
                    );
                    InputFeilds::printMultiSelect("networks", $options, parent::param("networks"));
                ?></td>
            </tr></table>
            <hr/>
            <div class="alignRight">
                <button class="jquiButton" type="submit"><?php echo parent::getTranslation("common.save"); ?></button>
            </div>
        </form>
        <?php
    }
    
    function printLoginView () {
        ?>
        <div class="panel loginNetworksPanel">
            <?php
            if (parent::param("networks")) {
                foreach (parent::param("networks") as $key => $value) {
                    switch ($value) {
                        case self::network_facebook:
                            ?>
                            <a class="facebookLoginButton" href="<?php echo parent::link(array("action"=>"facebookLogin"),true,true); ?>">
                                Sign In With <b>Facebook</b>
                            </a>
                            <?php
                            break;
                        case self::network_google:
                            ?>
                            <a class="googleLoginButton" href="<?php echo parent::link(array("action"=>"googleLogin"),true,true); ?>">
                                Sign In With <b>Google</b>
                            </a>
                            <?php
                            break;
                        case self::network_twitter:
                            break;
                    }
                }
            }
            ?>
        </div>
        <?php
    }
    
}