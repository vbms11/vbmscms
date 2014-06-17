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
            case "addFriend":
                if (Context::hasRole("user.profile.owner")) {
                    $friendRequestId = UserFriendModel::createUserFriendRequest(Context::getUserId(), parent::get("id"));
                    SocialController::notifyFriendRequest($friendRequestId);
                    parent::redirect();
                }
                break;
            case "removeFriend":
                if (Context::hasRole("user.profile.owner")) {
                    UserFriendModel::deleteUserFriend(parent::get("id"));
                    parent::redirect();
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
    
    function getStyles() {
        return array("css/userProfile.css");
    }
    
    function printEditView () {
        ?>
        <div class="panel usersProfilePanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("users.profile.edit.mode"); ?>
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
        <div class="panel usersProfilePanel">
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
                $user = UsersModel::getUser($userId);
                $username = htmlentities($user->username);
                $userProfileImage = UsersModel::getUserImageUrl($user->id);
                ?>
                <div class="userProfileImage">
                    <?php
                    if ($userId == Context::getUserId()) {
                        ?>
                        <div class="userProfileImageEdit">
                            <a href="<?php echo parent::staticLink("userProfileImage",array("userId"=>$user->id)) ?>">
                                <?php echo parent::getTranslation("userProfile.editImage"); ?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                    <img src="<?php echo $userProfileImage; ?>" title="<?php echo $username; ?>" alt="<?php echo $username; ?>" />
                </div>
                <div class="userProfileName">
                    <?php echo $username." (".$user->age.")"; ?>
                </div>
                <div class="userProfileMenu">
                    <div>
                        <a href="<?php echo parent::staticLink("userWall",array("userId"=>$userId)); ?>">
                            <?php echo parent::getTranslation("userProfile.wall"); ?>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo parent::staticLink("userGallery",array("userId"=>$userId)); ?>">
                            <?php echo parent::getTranslation("userProfile.gallery"); ?>
                        </a>
                    </div>
                    <?php /*
                    <div>
                        <a href="<?php echo parent::staticLink("userDetails",array("userId"=>$userId)); ?>">
                            <?php echo parent::getTranslation("userProfile.details"); ?>
                        </a>
                    </div>
                     */
                    if (Context::isLoggedIn() == false) {
                        ?>
                        <div>
                            <a href="<?php echo parent::staticLink("login"); ?>">
                                <?php echo parent::getTranslation("userProfile.message"); ?>
                            </a>
                        </div>
                        <?php
                    } else if ($userId !== Context::getUserId()) {
                        ?>
                        <div>
                            <a href="<?php echo parent::staticLink("userMessage",array("action"=>"new","userId"=>$userId)); ?>">
                                <?php echo parent::getTranslation("userProfile.message"); ?>
                            </a>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div>
                            <a href="<?php echo parent::staticLink("userMessage",array("userId"=>$userId)); ?>">
                                <?php echo parent::getTranslation("userProfile.messages"); ?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                    <div>
                        <a href="<?php echo parent::staticLink("userFriend",array("userId"=>$userId)); ?>">
                            <?php echo parent::getTranslation("userProfile.friends"); ?>
                        </a>
                    </div>
                    <?php
                    if ($userId !== Context::getUserId()) {
                        $userFriend = UserFriendModel::getUserFriendRequest(Context::getUserId(),$userId);
                        if (Context::isLoggedIn() == false) {
                            ?>
                            <div>
                                <a href="<?php echo parent::staticLink("login"); ?>">
                                    <?php echo parent::getTranslation("userProfile.addFriends"); ?>
                                </a>
                            </div>
                            <?php
                        } else if (empty($userFriend)) {
                            ?>
                            <div>
                                <a href="<?php echo parent::link(array("action"=>"addFriend","id"=>$userId)); ?>">
                                    <?php echo parent::getTranslation("userProfile.addFriends"); ?>
                                </a>
                            </div>
                            <?php
                        } else if ($userFriend->confirmed == "0") {
                            ?>
                            <div>
                                <a href="#">
                                    <?php echo parent::getTranslation("userProfile.addFriendsSent"); ?>
                                </a>
                            </div>
                            <?php
                        } else if ($userFriend->confirmed == "1") {
                            ?>
                            <div>
                                <a href="<?php echo parent::link(array("action"=>"removeFriend","id"=>$userFriend->id)); ?>">
                                    <?php echo parent::getTranslation("userProfile.removeFriends"); ?>
                                </a>
                            </div>
                            <?php
                        }
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