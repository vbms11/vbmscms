<?php

require_once('core/plugin.php');

class UserDetailsModule extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("user.profile.edit")) {
                    parent::param("mode",$_POST["mode"]);
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("user.profile.edit")) {
                    parent::focus();
                }
                break;
            case "saveDetails":
            	
            	break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("user.profile.edit")) {
                    $this->printEditView();
                }
                break;
            case "saveDetails":
            default:
                if (Context::hasRole("user.profile.view")) {
                    $this->printMainView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("user.profile.edit","user.profile.view","user.profile.owner");
    }
    
    static function getTranslations() {
        return array(
            "en"=>array(
                "users.profile.edit.mode" => "Display Mode:"
            ),
            "de"=>array(
                "users.profile.edit.mode" => "Anzige Modus:"
            ));
    }
    
    function printEditView () {
        ?>
        <div class="panel usersProfilePanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("users.profile.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentUser => parent::getTranslation("common.user.current"), self::modeSelectedUser => parent::getTranslation("common.user.selected"))); ?>
                </td></tr>
                </table>
                <hr/>
                <div class="alignRight">
                    <button type="submit"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
            <script>
            $(".usersProfilePanel button").button();
            </script>
        </div>
        <?php
    }
    
    function printMainView () {
        ?>
        <div class="panel usersProfilePanel">
            <?php
            $userId = null;
            switch (parent::param("mode")) {
                case self::modeSelectedUser:
                    $userId = Context::getSelectedUserId();
                    break;
                default:
                case self::modeCurrentUser:
                    if (Context::hasRole("user.profile.owner")) {
                        $userId = Context::getUserId();
                    }
                    break;
            }
            if (!empty($userId)) {
                $user = UsersModel::getUser($userId);
                ?>
                <h1><?php echo parent::getTranslation("userDetails.title"); ?></h1>
                <p><?php echo parent::getTranslation("userDetails.description"); ?></p>
                <form method="post" action="<?php parent::link(array("action"=>"saveDetails")); ?>">
                	<table class="formTable"><tr><td>
                        <?php echo parent::getTranslation("users.attrib.username"); ?>
                    </td><td>
                        <?php 
                        InputFeilds::printTextFeild(parent::alias("username"),parent::post("username") == null ? $user->username : parent::post("username")); 
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.firstname"); ?>
                    </td><td>
                        <?php InputFeilds::printTextFeild(parent::alias("firstname"),parent::post("firstname") == null ? $user->firstname : parent::post("firstname")); 
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.lastname"); ?>
                    </td><td>
                        <?php InputFeilds::printTextFeild(parent::alias("lastname"),parent::post("lastname") == null ? $user->lastname : parent::post("lastname")); 
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.email"); ?>
                    </td><td>
                        <?php InputFeilds::printTextFeild(parent::alias("email"),parent::post("email") == null ? $user->email : parent::post("email")); 
                        ?>
                    </td></tr><tr><td>
                        <?php echo parent::getTranslation("users.attrib.dob"); ?>
                    </td><td>
                        <?php InputFeilds::printDataPicker(parent::alias("dob"),parent::post("dob") == null ? $user->birthdate : parent::post("dob")); 
                        ?>
                    </td></tr></table>
                    <hr>
                    <div class="alignRight">
                    	<button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                	</div>
                </form>
                <?php
            }
            ?>
        </div>
        <?php
    }
}

?>