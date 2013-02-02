<?php

require_once('core/plugin.php');

class RegisterModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("users.register.edit")) {
                    parent::param("confirmRegister",$_POST['confirmRegister']);
                    parent::param("finnishRegister",$_POST['finnishRegister']);
                    parent::param("userRoles",$_POST['userRoles']);
                    parent::param("subject",$_POST['subject']);
                    parent::param("from",$_POST['from']);
                    parent::param("expiredays",$_POST['expiredays']);
                    parent::param("confirmEmail",$_POST['confirmEmail']);
                    parent::param("requireConfirmEmail",isset($_POST['requireConfirmEmail']) ? "1" : "0");
                }
                break;
            case "register":
                if (Captcha::validateInput('captcha')) {
                    // create the user and add roles
                    $userId = UsersModel::saveUser(null, $_POST['userName'], $_POST['firstName'], $_POST['lastName'], $_POST['password1'], $_POST['email'], $_POST['birthDate'], null);
                    if (count(parent::param("userRoles")) > 0) {
                        foreach (parent::param("userRoles") as $roleId) {
                            RolesModel::addCustomRoleToUser($roleId,$userId);
                        }
                    }
                    if (parent::param("requireConfirmEmail") == "1") {
                        // send the confirm email
                        $emailText = parent::param("confirmEmail");
                        $emailText = str_replace("%userName%", $_POST['userName'], $emailText);
                        $emailText = str_replace("%firstName%", $_POST['firstName'], $emailText);
                        $emailText = str_replace("%lastName%", $_POST['lastName'], $emailText);
                        $emailText = str_replace("%email%", $_POST['email'], $emailText);
                        $emailText = str_replace("%birthDate%", $_POST['birthDate'], $emailText);
                        ConfirmModel::sendConfirmation($_POST['email'], parent::param("subject"), $emailText, parent::param("from"), parent::getId(), array("action"=>"confirm","userid"=>$userId), parent::param("expiredays"));
                    } else {
                        // activate user and login
                        UsersModel::setUserActiveFlag($userId,"1");
                        UsersModel::login($_POST['userName'], $_POST['password1']);
                        if (NavigationModel::hasNextAction()) {
                            NavigationModel::redirectNextAction();
                        }
                    }
                    parent::focus();
                } else {
                    parent::redirect(array("action"=>"captcha"));
                }
                break;
            case "confirm":
                //
                UsersModel::setUserActiveFlag($_GET["userid"],"1");
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
                if (Context::hasRole("users.register.edit")) {
                    $this->printEditView();
                }
                break;
            case "register":
                $this->printConfirmRegisterView();
                break;
            case "confirm":
                $this->printFinnishRegisterView();
                break;
            case "captcha":
                $this->printCaptchaView();
            default:
                $this->printRegisterUserView();
                break;
        }
    }
    
    function getRoles () {
        return array("users.register.edit");
    }

    static function getTranslations () {
        return array(
            "en" => array(
                "register.username"     => "Username:",
                "register.firstname"    => "Firstname:",
                "register.lastname"     => "Lastname:",
                "register.email"        => "Email:",
                "register.dob"          => "Date Of Birth:",
                "register.password1"    => "Your Password:",
                "register.password2"    => "Confirm Password:",
                "register.register"     => "Register",
                "register.missmatch"    => "Passwords do not match!",
                "register.captcha"      => "Captcha code invalid!"
            ),
            "de" => array(
                "register.username"     => "Benutzername:",
                "register.firstname"    => "Vorname:",
                "register.lastname"     => "Nachname:",
                "register.email"        => "Email:",
                "register.dob"          => "Geburtsdatum:",
                "register.password1"    => "Dein Passwort:",
                "register.password2"    => "Passwort widerholen:",
                "register.register"     => "Registrieren",
                "register.missmatch"    => "Passwörter sind nicht gleich!",
                "register.captcha"      => "Captcha code invalid!"
            )
        );
    }

    function printEditView () {
        ?>
        <div class="panel registerPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table width="100%"><tr>
                    <td class="contract nowrap">From Email: </td>
                    <td class="expand"><?php InputFeilds::printTextfeild("from",parent::param("from")); ?></td>
                </tr><tr>
                    <td class="contract nowrap">Email Subject: </td>
                    <td class="expand"><?php InputFeilds::printTextfeild("subject",parent::param("subject")); ?></td>
                </tr><tr>
                    <td class="contract nowrap">Expire Days: </td>
                    <td class="expand"><?php InputFeilds::printTextfeild("expiredays",parent::param("expiredays")); ?></td>
                </tr><tr>
                    <td colspan="2"><br/>User Roles: </td>
                </tr><tr>
                <td colspan="2">
                    <?php
                    $customRoles = Common::toMap(RolesModel::getCustomRoles(),"id","name");
                    InputFeilds::printMultiSelect("userRoles", $customRoles, Common::toMap(parent::param("userRoles")));
                    ?>
                </td>
                </tr><tr>
                    <td colspan="2"><br/>Confirm registration message: </td>
                </tr><tr>
                    <td colspan="2"><?php InputFeilds::printHtmlEditor("confirmRegister",parent::param("confirmRegister")); ?></td>
                </tr><tr>
                    <td colspan="2"><br/>Registration confirm email, the following placeholders will be replaced: %userName% %firstName% %lastName% %email% %birthDate%</td>
                </tr><tr>
                    <td colspan="2"><?php InputFeilds::printHtmlEditor("confirmEmail",parent::param("confirmEmail")); ?></td>
                </tr><tr>
                    <td colspan="2"><br/>Registration finnished message: </td>
                </tr><tr>
                    <td colspan="2"><?php InputFeilds::printHtmlEditor("finnishRegister",parent::param("finnishRegister")); ?></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <input type="submit" value="Register" />
                </div>
            </form>
            <script type="text/javascript">
            $(".alignRight input").button();
            </script>
        </div>
        <?php
    }

    function printCaptchaView () {
        ?>
        <div id="dialog-message" title="Captcha Invalid">
            <p>
                <?php echo parent::getTranslation("register.captcha"); ?>
            </p>
        </div>
        <script>
        $("#dialog-message").dialog({
            modal: true, buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        $("#dialog-message").show();
        </script>
        <?php
    }

    function printRegisterUserView () {
        ?>
        <div class="panel registerPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"register")); ?>">
                <table width="100%"><tr>
                    <td class="formLabel"><?php echo parent::getTranslation("register.username"); ?></td>
                    <td class="expand"><input name="userName" class="textbox" type="text" value="" /></td>
                </tr><tr>
                    <td class="formLabel"><?php echo parent::getTranslation("register.firstname"); ?></td>
                    <td class="expand"><input name="firstName" class="textbox" type="text" value="" /></td>
                </tr><tr>
                    <td class="formLabel"><?php echo parent::getTranslation("register.lastname"); ?></td>
                    <td class="expand"><input name="lastName" class="textbox" type="text" value="" /></td>
                </tr><tr>
                    <td class="formLabel"><?php echo parent::getTranslation("register.email"); ?></td>
                    <td class="expand"><input name="email" class="textbox" type="text" value="" /></td>
                </tr><tr>
                    <td class="formLabel"><?php echo parent::getTranslation("register.dob"); ?></td>
                    <td class="expand"><input id="birthDate" name="birthDate" class="textbox" type="text" value="" /></td>
                </tr><tr>
                    <td class="formLabel"><?php echo parent::getTranslation("register.password1"); ?></td>
                    <td class="expand"><input id="password1" name="password1" class="textbox" type="password" value="" /></td>
                </tr><tr>
                    <td class="formLabel"><?php echo parent::getTranslation("register.password2"); ?></td>
                    <td class="expand"><input id="password2" name="password2" class="textbox" type="password" value="" /></td>
                </tr></table>
                <hr/>
                <?php
                InputFeilds::printCaptcha("captcha");
                ?>
                <hr/>
                <div class="alignRight">
                    <input type="submit" value="<?php echo parent::getTranslation("register.register"); ?>" />
                </div>
            </form>
            <script type="text/javascript">
            $(".alignRight input").button().click(function (e) {
                if ($("#password1").val() != $("#password2").val()) {
                    alert("<?php echo parent::getTranslation("register.missmatch"); ?>");
                    e.preventDefault();
                }
            });
            $("#birthDate").datepicker();
            $("#birthDate").datepicker("option", "showAnim", "blind");
            $("#birthDate").datepicker({changeMonth: true, changeYear: true});
            </script>
        </div>
        <?php
    }

    function printConfirmRegisterView () {
        ?>
        <div class="panel registerPanel">
            <?php echo parent::param("confirmRegister"); ?>
        </div>
        <?php
    }

    function printFinnishRegisterView () {
        ?>
        <div class="panel registerPanel">
            <?php echo parent::param("finnishRegister"); ?>
        </div>
        <?php
    }
}

?>