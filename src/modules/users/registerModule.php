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
                    
                    $username = parent::post('userName');
                    $firstName = parent::post('firstName');
                    $lastName = parent::post('lastName');
                    $password = parent::post('password1');
                    $email = parent::post('email');
                    $birthDate = parent::post('birthDate');
                    $gender = parent::post('gender');
                    $over18 = parent::post('over18');
                    $agbs = parent::post('agbs');
                    
                    $lawValidation = array();
                    if ($over18 != "1") {
                        $lawValidation["over18"] = "You must be at least 18 years of age!";
                    }
                    if ($agbs != "1") {
                        $lawValidation["agbs"] = "You must accept the terms and conditions!";
                    }
                    
                    if (isset($_SESSION['register.user'])) {
                        $registerUser = $_SESSION['register.user'];
                        switch (parent::get("type")) {
                            case "facebook":
                                $firstName = $registerUser['first_name'];
                                $lastName = $registerUser['last_name'];
                                $email = $registerUser['email'];
                                if ($registerUser['gender'] == "male") {
                                    $gender = '1';
                                } else {
                                    $gender = '0';
                                }
                                $password = null;
                                break;
                            case "google":
                                // $firstName = $registerUser['namePerson/first'];
                                // $lastName = $registerUser['namePerson/last'];
                                $email = $registerUser['email'];
                                $password = null;
                                break;
                        }
                    }
                    
                    $userValidationMessages = UsersModel::validate(null, $username, $firstName, $lastName, $password, $email, $birthDate, $gender);
                    $addressValidationMessages = UserAddressModel::validate(parent::post('continent'), parent::post('continentId'), parent::post('country'), parent::post('countryId'), parent::post('state'), parent::post('stateId'), parent::post('region'), parent::post('regionId'), parent::post('city'), parent::post('cityId'), parent::post('address'), parent::post('postcode'));
                            
                    if (count($lawValidation) == 0 && count($userValidationMessages) == 0 && count($addressValidationMessages) == 0) {

                        $userId = UsersModel::saveUser(null, $username, $firstName, $lastName, $password, $email, $birthDate, null, $gender);

			$userRoles = parent::param("userRoles");
                        if (!empty($userRoles)) {
                            foreach (parent::param("userRoles") as $roleId) {
                                RolesModel::addCustomRoleToUser($roleId,$userId);
                            }
                        }

                        $userAddressId = UserAddressModel::createUserAddress($userId, parent::post('continent'), parent::post('continentId'), parent::post('country'), parent::post('countryId'), parent::post('state'), parent::post('stateId'), parent::post('region'), parent::post('regionId'), parent::post('city'), parent::post('cityId'), parent::post('address'), parent::post('postcode'), parent::post('x'), parent::post('y'));
                        if (parent::param("requireConfirmEmail")) {
                            // send the confirm email
                            $emailText = parent::param("confirmEmail");
                            $emailText = str_replace("%userName%", $username, $emailText);
                            $emailText = str_replace("%firstName%", $firstName, $emailText);
                            $emailText = str_replace("%lastName%", $lastName, $emailText);
                            $emailText = str_replace("%email%", $email, $emailText);
                            $emailText = str_replace("%birthDate%", $birthDate, $emailText);
                            ConfirmModel::sendConfirmation($email, parent::param("subject"), $emailText, parent::param("from"), parent::getId(), array("action"=>"confirm","userid"=>$userId), parent::param("expiredays"));
                            parent::redirect(array("action"=>"confirmRegister"));
                        } else {
                            // activate user and login
                            UsersModel::setUserActiveFlag($userId,"1");

                            if (isset($_SESSION['register.user'])) {
                                $registerUser = $_SESSION['register.user'];
                                switch (parent::get("type")) {
                                    case "facebook":
                                        UsersModel::loginWithFacebookId($registerUser['id']);
                                        break;
                                    case "google":
                                        UsersModel::loginWithEmail($email);
                                        break;
                                }
                            } else {
                                UsersModel::login($username, $password);
                            }
                            
                            if (NavigationModel::hasNextAction()) {
                                NavigationModel::redirectNextAction();
                            } else {
                                NavigationModel::redirectStaticModule("userProfile",array("userId"=>$userId));
                            }
                        }
                    } else {
                        parent::setMessages($userValidationMessages);
                        parent::addMessages($addressValidationMessages);
                        parent::addMessages($lawValidation);
                    }
                    
                    parent::focus();
                } else {
                    parent::setMessages(array("captcha"=>parent::getTranslation("register.captcha")));
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
            case "confirmRegister":
                $this->printConfirmRegisterView();
                break;
            case "confirm":
                $this->printFinnishRegisterView();
                break;
            case "validate":
            default:
                $this->printRegisterUserView();
                break;
        }
    }
    
    function getRoles () {
        return array("users.register.edit");
    }
    
    function getScripts() {
        return array("js/locationSelection.js");
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

    function printRegisterUserView () {
        $firstName = parent::post("firstName");
        $lastName = parent::post("lastName");
        $email = parent::post("email");
        $gender = "0";
	
        if (isset($_SESSION['register.user'])) {
            $registerUser = $_SESSION['register.user'];
            switch (parent::get("type")) {
                case 'facebook':
                    $firstName = utf8_decode($registerUser['first_name']);
                    $lastName = utf8_decode($registerUser['last_name']);
                    $email = utf8_decode($registerUser['email']);
                    if ($registerUser['gender'] == "male") {
                        $gender = '1';
                    } else {
                        $gender = '0';
                    }
                    break;
                case 'google':
                    // $firstName = utf8_decode($registerUser['namePerson/first']);
                    // $lastName = utf8_decode($registerUser['namePerson/last']);
                    $email = utf8_decode($registerUser['email']);
                    break;
            }
        }
        ?>
        <div class="panel registerPanel">
            <?php
            $message = parent::getMessage("captcha");
            if (!empty($message)) {
                echo '<span class="validateTips">'.$message.'</span>';
            }
            ?>
            <form method="post" id="<?php echo parent::alias("registerUserForm"); ?>" action="<?php echo parent::link(array("action"=>"register","type"=>parent::get("type"))); ?>">
                <input type="hidden" name="x" value="<?php echo parent::post("x") ?>" />
		<input type="hidden" name="y" value="<?php echo parent::post("y") ?>" />
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
                    <td><input name="firstName" type="text" <?php if (isset($_SESSION['register.user']) && parent::get("type") == "facebook") { echo 'disabled="true"'; } ?> value="<?php echo $firstName; ?>" /><?php
                    
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.lastname"); ?></td>
                    <td><input name="lastName" type="text" <?php if (isset($_SESSION['register.user']) && parent::get("type") == "facebook") { echo 'disabled="true"'; } ?> value="<?php echo $lastName ?>" /><?php
                    $message = parent::getMessage("lastname");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.gender"); ?></td>
                    <td><select name="gender" <?php if (isset($_SESSION['register.user']) && parent::get("type") == "facebook") { echo 'disabled="true"'; } ?>>
                            <option value="0" <?php if ($gender == "0") { echo 'selected="true"'; } ?>><?php echo parent::getTranslation("common.female"); ?></option>
                            <option value="1" <?php if ($gender == "1") { echo 'selected="true"'; } ?>><?php echo parent::getTranslation("common.male"); ?></option>
                        </select>
                        <?php
                    $message = parent::getMessage("gender");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.email"); ?></td>
                    <td><input name="email" type="text" <?php if (isset($_SESSION['register.user'])) { echo 'disabled="true"'; } ?> value="<?php echo $email; ?>" /><?php
                    $message = parent::getMessage("email");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.dob"); ?></td>
                    <td><?php
                    InputFeilds::printDataPicker("birthDate",Common::toSqlDate(parent::post("birthDate")));
                    $message = parent::getMessage("dob");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr>
                <?php
                if (!parent::get("type")) {
                    ?>
                    <tr>
                        <td><?php echo parent::getTranslation("register.password1"); ?></td>
                        <td><input id="password1" name="password1" type="password" value="" /></td>
                    </tr><tr>
                        <td><?php echo parent::getTranslation("register.password2"); ?></td>
                        <td><input id="password2" name="password2" type="password" value="" /></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td><?php echo parent::getTranslation("register.continent"); ?></td>
                    <td><select name="continentId" type="text"></select>
                        <input name="continent" type="hidden" value="<?php echo parent::post("continent"); ?>" /><?php
                    $message = parent::getMessage("continent");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.country"); ?></td>
                    <td><select name="countryId" type="text"></select>
                        <input name="country" type="hidden" value="<?php echo parent::post("country"); ?>" /><?php
                    $message = parent::getMessage("country");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.state"); ?></td>
                    <td><select name="stateId" type="text"></select>
                        <input name="state" type="hidden" value="<?php echo parent::post("state"); ?>" /><?php
                    $message = parent::getMessage("state");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.region"); ?></td>
                    <td><select name="regionId" type="text"></select>
                        <input name="region" type="hidden" value="<?php echo parent::post("region"); ?>" /><?php
                    $message = parent::getMessage("region");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation("register.city"); ?></td>
                    <td><select name="cityId" type="text"></select>
                        <input name="city" type="hidden" value="<?php echo parent::post("city"); ?>" /><?php
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
                </tr><tr>
                    <td></td>
                    <td>
                        <div>
                            <input name="over18" type="checkbox" value="1" />
                            <?php echo parent::getTranslation("register.over18"); ?>
                        </div>
                        <?php
                        $message = parent::getMessage("over18");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                    ?></td>
                </tr><tr>
                    <td></td>
                    <td>
                        <div>
                            <input name="agbs" type="checkbox" value="1" />
                            <?php echo parent::getTranslation("register.agbs",null,false); ?>
                        </div>
                        <?php
                        $message = parent::getMessage("agbs");
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
                    <button type="submit">
                        <?php echo parent::getTranslation("register.register"); ?>
                    </button>
                </div>
            </form>
            <script type="text/javascript">
            var submitButton = $("#<?php echo parent::alias("registerUserForm"); ?>").find("button[type=submit]");
		if ($("#<?php echo parent::alias("registerUserForm"); ?>").find("input[name=x]").val().length === 0
			&& $("#<?php echo parent::alias("registerUserForm"); ?>").find("input[name=y]").val().length === 0) {
			submitButton.button({ disabled: true });
		} else {
			submitButton.button();
		}
	submitButton.click(function (e) {
                if ($(".registerPanel input[name=password1]").val() !== $(".registerPanel input[name=password2]").val()) {
                    alert("<?php echo parent::getTranslation("register.missmatch"); ?>");
                    e.preventDefault();
                }
            });
            setupPlaceFeilds($("#<?php echo parent::alias("registerUserForm"); ?>"),"<?php echo parent::post("continentId"); ?>","<?php echo parent::post("countryId"); ?>","<?php echo parent::post("stateId"); ?>","<?php echo parent::post("regionId"); ?>","<?php echo parent::post("cityId"); ?>", submitButton);
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
