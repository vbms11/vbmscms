<?php

require_once('core/plugin.php');

class UserFriendRequestModule extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("user.friendRequest.edit")) {
                    parent::param("mode",$_POST["mode"]);
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("user.friendRequest.edit")) {
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
                if (Context::hasRole("user.friendRequest.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("user.friendRequest.view")) {
                    $this->printMainView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("user.friendRequest.edit","user.friendRequest.view");
    }
    
    function getStyles() {
        return array("css/userFriendRequest.css");
    }
    
    function printEditView () {
        ?>
        <div class="panel usersFriendRequestsEditPanel">
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
        <div class="panel usersFriendRequestsPanel">
            <?php
            $userId = null;
            switch (parent::param("mode")) {
                case self::modeSelectedUser:
                    $userId = Context::getSelectedUserId();
                    break;
                case self::modeCurrentUser:
                default:
                    $userId = Context::getUserId();
                    break;
            }
            if (!empty($userId)) {
                
                $friends = UserFriendModel::getUserFriends($userId);
                
                ?>
                <h1><?php echo parent::getTranslation("userFriendRequest.title"); ?></h1>
                <?php
                if (empty($friends)) {
                    ?>
                    <p><?php echo parent::getTranslation("userFriendRequest.none"); ?></p>
                    <?php
                } else {
                    ?>
                    <p><?php echo parent::getTranslation("userFriendRequest.description"); ?></p>
                    <div class="friendRequestList">
                    <?php
                    foreach ($friends as $friend) {

                        $user = UsersModel::getUser($friend->friendid);
                        $userProfileImage = UsersModel::getUserImageUrl($user->id);
                        $username = htmlentities($user->username);

                        ?>
                        <div class="usersFriendRequestDiv shadow">
                            <div class="usersFriendRequestImage">
                                <a href="<?php echo parent::staticLink('userProfile',array('userId' => $user->id)); ?>">
                                    <img class="imageLink" width="170" height="170" src="<?php echo $userProfileImage; ?>" alt="<?php echo $username; ?>"/>
                                </a>
                            </div>
                            <div class="usersFriendRequestDetails">
                                <a href="<?php echo parent::staticLink('userProfile',array('userId' => $user->id)); ?>">
                                    <?php echo $user->username; ?>
                                    <?php echo ' ('.$user->age.')'; ?>
                                </a>
                                <button><?php echo parent::getTranslation("userFriendRequest.button.confirm"); ?></button>
                                <button><?php echo parent::getTranslation("userFriendRequest.button.decline"); ?></button>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
        <?php
    }
}

?>