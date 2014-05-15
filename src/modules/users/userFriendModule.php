<?php

require_once('core/plugin.php');

class UserFriendModule extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("user.friend.edit")) {
                    parent::param("mode",$_POST["mode"]);
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("user.friend.edit")) {
                    parent::focus();
                }
                break;
            default:
                if (parent::get("userId")) {
                    Context::setSelectedUser(parent::get("userId"));
                } else if (parent::param("mode") == self::modeCurrentUser) {
                    Context::setSelectedUser(Context::getUserId());
                }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("user.friend.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("user.friend.view")) {
                    $this->printMainView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("user.friend.edit","user.friend.view");
    }
    
    function getStyles() {
        return array("css/userFriend.css");
    }
    
    function printEditView () {
        ?>
        <div class="panel usersFriendEditPanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("users.friend.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentUser => parent::getTranslation("common.user.current"), self::modeSelectedUser => parent::getTranslation("common.user.selected"))); ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function printMainView () {
        ?>
        <div class="panel usersFriendPanel">
            <?php
            $userId = null;
            switch (parent::param("mode")) {
                case self::modeSelectedUser:
                    $userId = Context::getSelectedUserId();
                    break;
                case self::modeCurrentUser:
                default:
                    if (Context::hasRole("user.profile.owner")) {
                        $userId = Context::getUserId();
                    }
                    break;
            }
            if (!empty($userId)) {
                
                $friends = UserFriendModel::getUserFriends($userId);
                
                ?>
                <h1><?php echo parent::getTranslation("userFriend.friend.title"); ?></h1>
                <div class="friendList">
                    <?php
                    foreach ($friends as $friend) {

                        $user = UsersModel::getUser($friend->friendid);
                        $userProfileImage = UsersModel::getUserImageUrl($user->id);
                        $username = htmlentities($user->username);

                        ?>
                        <div class="usersFriendUserDiv shadow">
                            <div class="usersFriendUserImage">
                                <a href="<?php echo parent::staticLink('userProfile',array('userId' => $user->id)); ?>">
                                    <img class="imageLink" width="170" height="170" src="<?php echo $userProfileImage; ?>" alt="<?php echo $username; ?>"/>
                                </a>
                            </div>
                            <div class="usersFriendUserDetails">
                                <a href="<?php echo parent::staticLink('userProfile',array('userId' => $user->id)); ?>">
                                    <?php echo $user->username; ?>
                                    <?php echo ' ('.$user->age.')'; ?>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}

?>