<?php

require_once('core/plugin.php');
require_once('core/model/usersModel.php');
require_once('core/ddm/dataView.php');


class UserMessageModule extends XModule {
    
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
                    parent::param("userAttribs",$_POST["userAttribs"]);
                    parent::param("profileTemplate",$_POST["profileTemplate"]);
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("user.profile.edit")) {
                    parent::focus();
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
                <table><tr><td>
                    <?php echo parent::getTranslation("users.profile.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentUser => parent::getTranslation("common.user.current"), self::modeSelectedUser => parent::getTranslation("common.user.selected"))); ?>
                </td></tr><tr><td colspan="2">
                    <?php echo parent::getTranslation("users.profile.edit.template"); ?>
                </td></tr><tr><td colspan="2">
                    <?php InputFeilds::printHtmlEditor("profileTemplate", parent::param("profileTemplate")); ?>
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
            user profile:
            <?php
            $userId = null;
            switch (parent::param("mode")) {
                case self::modeSelectedUser:
                    $userId = Context::getSelectedUserId();
                    break;
                default:
                case self::modeCurrentUser:
                    if (Context::hasRole("user.profile.own")) {
                        $userId = Context::getUserId();
                    }
                    break;
            }
            if (!empty($userId)) {
                $user = UsersModel::getUser($userId);
                if (!empty($user)) {
                    $user->profileImage = ResourcesModel::createResourceLink("gallery/small", $user->image);
                    $userInfo = VirtualDataModel::getRowByObjectIds(parent::param("userAttribs"), $user->objectId);
                    $placeholderReplacer = new TemplateParser();
                    $placeholderReplacer->addObject("user", $user);
                    $placeholderReplacer->addObject("userInfo", $userInfo);
                    $placeholderReplacer->setTemplate(parent::param("profileTemplate"));
                    echo $placeholderReplacer->render();
                }
            }
            ?>
        </div>
        <?php
    }
}

?>