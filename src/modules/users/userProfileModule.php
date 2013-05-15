<?php

require_once('core/plugin.php');
require_once('core/model/usersModel.php');
require_once('core/ddm/dataView.php');


class UserProfileModule extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("users.profile") && Context::isLoggedIn()) {

            switch (parent::getAction()) {
                case "save":
                    if (Context::hasRole("user.info.edit")) {
                        parent::param("mode",$_POST["mode"]);
                        parent::param("userAttribs",$_POST["userAttribs"]);
                        parent::param("profileTemplate",$_POST["profileTemplate"]);
                    }
                    parent::blur();
                    parent::redirect();
                    break;
                case "edit":
                    if (Context::hasRole("user.info.edit")) {
                        parent::focus();
                    }
                    break;
            }
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
            default:
                if (Context::hasRole("user.profile.view")) {
                    $this->printMainView();
                }
                break;
        }
    }

    /**
     * called when module is installed
     */
    function install () {

    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("user.profile.edit","user.profile.view","user.profile.own");
    }
    
    function getTranslations() {
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
        <div class="panel usersInfoPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table><tr><td>
                    <?php echo parent::getTranslation("users.profile.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(parent::getTranslation("common.user.current") => self::modeCurrentUser, parent::getTranslation("common.user.selected") => self::modeSelectedUser)); ?>
                </td></tr></table>
                <hr/>
                <button type="submit"><?php echo parent::getTranslation("common.save"); ?></button>
            </form>
        </div>
        <?php
    }
    
    function printMainView () {
        ?>
        <div class="panel usersProfilePanel">
            <?php
            $userId = null;
            switch (parent::getParam("mode")) {
                case self::modeCurrentUser:
                    if (Context::hasRole("user.profile.own")) {
                        $userId = Context::getUserId();
                    }
                    break;
                case self::modeSelectedUser:
                    $userId = Context::getSelectedUserId();
                    break;
            }
            $user = UsersModel::getUser($userId);
            $user->profileImage = ResourcesModel::createResourceLink("gallery/small", $user->image);
            $userInfo = VirtualDataModel::getRowByObjectIds(parent::param("userAttribs"), $user->objectId);
            $placeholderReplacer = new PlaceholderReplacer();
            $placeholderReplacer->addObject("user", $user);
            $placeholderReplacer->addObject("userInfo", $userInfo);
            $placeholderReplacer->setTemplate(parent::param("profileTemplate"));
            echo $placeholderReplacer->render();
            ?>
        </div>
        <?php
    }
}

?>