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
                    parent::param("confirmRegister",parent::post('confirmRegister'));
                    parent::param("finnishRegister",parent::post('finnishRegister'));
                    parent::param("userRoles",parent::post('userRoles'));
                    parent::param("subject",parent::post('subject'));
                    parent::param("from",parent::post('from'));
                    parent::param("expiredays",parent::post('expiredays'));
                    parent::param("confirmEmail",parent::post('confirmEmail'));
                    parent::param("requireConfirmEmail",isset($_POST['requireConfirmEmail']) ? "1" : "0");
                }
                break;
            case "register":
                if (Captcha::validateInput('captcha')) {
                    
                    $userValidationMessages = UsersModel::validate(null, parent::post('userName'), parent::post('firstName'), parent::post('lastName'), parent::post('password1'), parent::post('email'), parent::post('birthDate'));
                    $addressValidationMessages = UserAddressModel::validate(parent::post('country'), parent::post('city'), parent::post('address'), parent::post('postcode'));
                            
                    if (count($userValidationMessages) == 0 && count($addressValidationMessages) == 0) {
                        
                        $userId = UsersModel::saveUser(null, parent::post('userName'), parent::post('firstName'), parent::post('lastName'), parent::post('password1'), parent::post('email'), parent::post('birthDate'), null);
                        if (count(parent::param("userRoles")) > 0) {
                            foreach (parent::param("userRoles") as $roleId) {
                                RolesModel::addCustomRoleToUser($roleId,$userId);
                            }
                        }
                        if (parent::param("requireConfirmEmail")) {
                            // send the confirm email
                            $emailText = parent::param("confirmEmail");
                            $emailText = str_replace("%userName%", parent::post('userName'), $emailText);
                            $emailText = str_replace("%firstName%", parent::post('firstName'), $emailText);
                            $emailText = str_replace("%lastName%", parent::post('lastName'), $emailText);
                            $emailText = str_replace("%email%", parent::post('email'), $emailText);
                            $emailText = str_replace("%birthDate%", parent::post('birthDate'), $emailText);
                            ConfirmModel::sendConfirmation(parent::post('email'), parent::param("subject"), $emailText, parent::param("from"), parent::getId(), array("action"=>"confirm","userid"=>$userId), parent::param("expiredays"));
                        } else {
                            // activate user and login
                            UsersModel::setUserActiveFlag($userId,"1");
                            UsersModel::login(parent::post('userName'), parent::post('password1'));
                            if (NavigationModel::hasNextAction()) {
                                NavigationModel::redirectNextAction();
                            }
                        }
                    } else {
                        parent::setMessages($userValidationMessages);
                        parent::addMessages($addressValidationMessages);
                        parent::redirect(array("action"=>"validate"));
                    }
                    
                    parent::focus();
                } else {
                    parent::redirect(array("action"=>"captcha"));
                }
                break;
            case "confirm":
                //
                UsersModel::setUserActiveFlag(parent::get('userid'),"1");
                parent::focus();
                break;
            case "validate":
                break;
            default:
                parent::clearMessages();
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
                if (parent::param("requireConfirmEmail")) {
                    $this->printConfirmRegisterView();
                } else {
                    $this->printFinnishRegisterView();
                }
                break;
            case "confirm":
                $this->printFinnishRegisterView();
                break;
            case "captcha":
                $this->printCaptchaView();
            case "validate":
            default:
                $this->printRegisterUserView();
                break;
        }
    }
    
    function getRoles () {
        return array("users.register.edit");
    }

    function printEditView () {
        ?>
        <div class="panel registerPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr>
                    <td><?php echo parent::getTranslation("register.edit.fromEmail"); ?></td>
                    <td><?php InputFeilds::printTextfeild("from",parent::param("from")); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.edit.emailSubject"); ?></td>
                    <td><?php InputFeilds::printTextfeild("subject",parent::param("subject")); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.edit.expireDays"); ?></td>
                    <td><?php InputFeilds::printTextfeild("expiredays",parent::param("expiredays")); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.edit.requireConfirmEmail"); ?></td>
                    <td><?php InputFeilds::printCheckbox("requireConfirmEmail",parent::param("requireConfirmEmail")); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.edit.userRoles"); ?></td>
                    <td>
                    <?php
                    $customRoles = Common::toMap(RolesModel::getCustomRoles(),"id","name");
                    InputFeilds::printMultiSelect("userRoles", $customRoles, Common::toMap(parent::param("userRoles")));
                    ?>
                    </td>
                </tr><tr>
                    <td colspan="2"><?php echo parent::getTranslation("register.edit.confirmRegisterMessage"); ?></td>
                </tr><tr>
                    <td colspan="2"><?php InputFeilds::printHtmlEditor("confirmRegister",parent::param("confirmRegister")); ?></td>
                </tr><tr>
                    <td colspan="2"><?php echo parent::getTranslation("register.edit.confirmEmailContent"); ?>%</td>
                </tr><tr>
                    <td colspan="2"><?php InputFeilds::printHtmlEditor("confirmEmail",parent::param("confirmEmail")); ?></td>
                </tr><tr>
                    <td colspan="2"><?php echo parent::getTranslation("register.edit.registrationFinnishedMessage"); ?></td>
                </tr><tr>
                    <td colspan="2"><?php InputFeilds::printHtmlEditor("finnishRegister",parent::param("finnishRegister")); ?></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton">
                        <?php echo parent::getTranslation("common.save"); ?>
                    </button>
                </div>
            </form>
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
        }).show();
        </script>
        <?php
    }

    function printRegisterUserView () {
        ?>
        <div class="panel registerPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"register")); ?>">
                <table width="100%" class="formTable"><tr>
                    <td><?php echo parent::getTranslation("register.username"); ?></td>
                    <td><input name="userName" type="text" value="<?php echo parent::post("userName"); ?>" /><?php
                    $message = parent::getMessage("username");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.firstname"); ?></td>
                    <td><input name="firstName" type="text" value="<?php echo parent::post("firstName"); ?>" /><?php
                    $message = parent::getMessage("firstname");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.lastname"); ?></td>
                    <td><input name="lastName" type="text" value="<?php echo parent::post("lastName"); ?>" /><?php
                    $message = parent::getMessage("lastname");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.email"); ?></td>
                    <td><input name="email" type="text" value="<?php echo parent::post("email"); ?>" /><?php
                    $message = parent::getMessage("email");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.dob"); ?></td>
                    <td><?php
                    InputFeilds::printDataPicker("birthDate", parent::post("birthDate"));
                    $message = parent::getMessage("dob");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.password1"); ?></td>
                    <td><input id="password1" name="password1" type="password" value="" /></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.password2"); ?></td>
                    <td><input id="password2" name="password2" type="password" value="" /></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.country"); ?></td>
                    <td><?php
                    $countries = Common::toMap(CountriesModel::getCountries(), "id", "name");
                    InputFeilds::printSelect("country", parent::post("country"), $countries);
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.city"); ?></td>
                    <td><input name="city" type="text" value="<?php echo parent::post("city"); ?>" /><?php
                    $message = parent::getMessage("city");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.address"); ?></td>
                    <td><input name="address" type="text" value="<?php echo parent::post("address"); ?>" /><?php
                    $message = parent::getMessage("address");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.postcode"); ?></td>
                    <td><input name="postcode" type="text" value="<?php echo parent::post("postcode"); ?>" /><?php
                    $message = parent::getMessage("postcode");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr></table>
                <hr/>
                <?php
                InputFeilds::printCaptcha("captcha");
                ?>
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton" type="submit">
                        <?php echo parent::getTranslation("register.register"); ?>
                    </button>
                </div>
            </form>
            <script type="text/javascript">
            $(".registerPanel button[type=submit]").click(function (e) {
                if ($(".registerPanel input[name=password1]").val() !== $(".registerPanel input[name=password2]").val()) {
                    alert("<?php echo parent::getTranslation("register.missmatch"); ?>");
                    e.preventDefault();
                }
            });
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