<?php

require_once('core/plugin.php');
require_once('modules/users/userWallModel.php');

class UserWallModule extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("user.profile.edit")) {
                    parent::param("mode",parent::post("mode"));
                    parent::param("emailTemplate",parent::post("emailTemplate"));
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("user.profile.edit")) {
                    parent::focus();
                }
                break;
            case "comment":
                if (parent::post("submitButton")) {
                    $validationMessages = UserWallModel::validateWallPost(parent::get("userId"), Context::getUserId(), parent::post("comment"));
                    if (count($validationMessages) > 0) {
                        parent::setMessages($validationMessages);
                    } else {
                        UserWallModel::createUserWallPost(parent::get("userId"), Context::getUserId(), parent::post("comment"));
                        parent::redirect();
                    }
                }
                break;
            case "reply":
                if (parent::post("submitButton")) {
                    $validationMessages = UserWallModel::validateWallPost(parent::get("userId"), Context::getUserId(), parent::post("comment"), parent::get("parent"));
                    if (count($validationMessages) > 0) {
                        parent::setMessages($validationMessages);
                    } else {
                        UserWallModel::createUserWallPost(parent::get("userId"), Context::getUserId(), parent::post("comment"), parent::get("parent"));
                        parent::redirect();
                    }
                }
                break;
            case "deleteComment":
                $userId = $this->getModeUserId();
                $comment = UserWallModel::getUserPost(parent::get("id"));
                if ($userId == Context::getUserId() || $comment->srcuserid == Context::getUserId()) {
                    UserWallmodel::deleteUserPost(parent::get("id"));
                }
                parent::redirect();
                break;
            case "editComment":
                if (parent::post("submitButton")) {
                    $post = UserWallModel::getUserPost(parent::get("id"));
                    $validationMessages = UserWallModel::validateWallPost($post->userid, Context::getUserId(), parent::post("comment"));
                    if (count($validationMessages) > 0) {
                        parent::setMessages($validationMessages);
                    } else {
                        if ($post->srcuserid == Context::getUserId()) {
                            UserWallModel::updateUserPost(parent::get("id"), parent::post("comment"));
                            parent::redirect();
                        }
                    }
                }
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
                if (Context::hasRole("user.profile.edit")) {
                    $this->printEditView();
                }
                break;
            case "editComment":
                $this->printEditPostView(parent::get("id"));
                break;
            case "reply":
            case "comment":
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
    
    function getStyles () {
        return array("css/userWall.css");
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
    
    function getModeUserId () {
        
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
        return $userId;
    }
    
    function printEditPostView ($postId) {
        
        $post = UserWallModel::getUserPost($postId);
        $userProfileImage = UsersModel::getUserImageSmallUrl($post->srcuserid);
        ?>
        <div class="panel usersWallPanel">
            <?php
            
            if (!empty($post)) {
                ?>
                <div class="userWallPostCommentBox">
                    <div class="userWallPostImage">
                        <img src="<?php echo $userProfileImage; ?>" alt="" title="" />
                    </div>
                    <div class="userWallPostBody">
                        <form method="post" action="<?php echo parent::link(array("action"=>"editComment","id"=>$post->id)); ?>">
                            <div class="userWallPostTextarea">
                                <textarea name="<?php echo parent::alias("comment") ?>"><?php echo htmlentities($post->comment); ?></textarea>
                            </div>
                            <hr/>
                            <div class="alignRight">
                                <button class="jquiButton" type="submit" name="<?php echo parent::alias("submitButton"); ?>" value="1">
                                    <?php echo parent::getTranslation("userWall.button.save"); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    
    function printMainView () {
        
        $userId = $this->getModeUserId();
        
        $wallPosts = array();
        if (!empty($userId)) {
            $wallPosts = UserWallModel::getUserWallPosts($userId);
        }
        $currentUserProfileImage = UsersModel::getUserImageSmallUrl(Context::getUserId());
        
        ?>
        <div class="panel usersWallPanel">
            <?php
            
            if (!empty($userId)) {
                ?>
                <div class="userWallPostCommentBox">
                    <div class="userWallPostImage">
                        <img src="<?php echo $currentUserProfileImage; ?>" alt="" title="" />
                    </div>
                    <div class="userWallPostBody">
                        <form method="post" action="<?php echo parent::link(array("action"=>"comment","userId"=>$userId)); ?>">
                            <div class="userWallPostTextarea">
                                <textarea name="<?php echo parent::alias("comment") ?>"></textarea>
                            </div>
                            <hr/>
                            <div class="alignRight">
                                <button class="jquiButton" type="submit" name="<?php echo parent::alias("submitButton"); ?>" value="1">
                                    <?php echo parent::getTranslation("userWall.button.comment"); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
            
            if (!empty($wallPosts)) {
                foreach ($wallPosts as $wallPost) {
                    
                    if (!empty($wallPost->parent)) {
                        continue;
                    }
                    
                    $srcUser = UsersModel::getUser($wallPost->srcuserid);
                    $srcUserName = $srcUser->firstname." ".$srcUser->lastname;
                    $userProfileImage = UsersModel::getUserImageSmallUrl($srcUser->id);
                    ?>
                    <div class="userWallPostThread">
                        <div class="userWallPost">
                            <div class="userWallPostImage">
                                <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$srcUser->id)) ?>">
                                    <img src="<?php echo $userProfileImage; ?>" alt="" title="" />
                                </a>
                            </div>
                            <div class="userWallPostBody">
                                <div class="userWallPostTitle">
                                    <?php
                                    $allowDelete = false;
                                    $allowEdit = false;
                                    if (Context::getUserId() == $wallPost->srcuserid) {
                                        $allowDelete = true;
                                        $allowEdit = true;
                                    }
                                    if ($userId == Context::getUserId()) {
                                        $allowDelete = true;
                                    }
                                    if ($allowDelete || $allowEdit) {
                                        ?>
                                        <div class="userWallPostTitleTools">
                                        <?php
                                    }
                                    if ($allowDelete) {
                                        ?>
                                        <img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("userWall.dialog.confirmDelete"); ?>','<?php echo parent::link(array("action"=>"deleteComment","id"=>$wallPost->id),false); ?>');" />
                                        <?php
                                    }
                                    if ($allowEdit) {
                                        ?>
                                        <a href="<?php echo parent::link(array("action"=>"editComment","id"=>$wallPost->id)); ?>">
                                            <img src="resource/img/preferences.png" alt="" />
                                        </a>
                                        <?php
                                    }
                                    if ($allowDelete || $allowEdit) {
                                        ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="userWallPostTitleDate">
                                        <?php echo $wallPost->date; ?>
                                    </div>
                                    <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$srcUser->id)) ?>">
                                        <?php echo $srcUserName; ?>
                                    </a>
                                </div>
                                <div class="userWallPostComment">
                                    <?php echo htmlentities($wallPost->comment); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        foreach (array_reverse($wallPosts) as $wallPostReply) {
                            if ($wallPost->id == $wallPostReply->parent) {
                                $replyUser = UsersModel::getUser($wallPostReply->srcuserid);
                                $replyUserName = $replyUser->firstname." ".$replyUser->lastname;
                                ?>
                                <div class="userWallPostReply">
                                    <div class="userWallPostImage">
                                        <img src="<?php echo $userProfileImage; ?>" alt="" title="" />
                                    </div>
                                    <div class="userWallPostBody">
                                        <div class="userWallPostTitle">
                                            <?php
                                            $allowDelete = false;
                                            $allowEdit = false;
                                            if (Context::getUserId() == $wallPostReply->srcuserid) {
                                                $allowDelete = true;
                                                $allowEdit = true;
                                            }
                                            if ($userId == Context::getUserId()) {
                                                $allowDelete = true;
                                            }
                                            if ($allowDelete || $allowEdit) {
                                                ?>
                                                <div class="userWallPostTitleTools">
                                                <?php
                                            }
                                            if ($allowDelete) {
                                                ?>
                                                <img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("userWall.dialog.confirmDelete"); ?>','<?php echo parent::link(array("action"=>"deleteComment","id"=>$wallPostReply->id),false); ?>');" />
                                                <?php
                                            }
                                            if ($allowEdit) {
                                                ?>
                                                <a href="<?php echo parent::link(array("action"=>"editComment","id"=>$wallPostReply->id)); ?>">
                                                    <img src="resource/img/preferences.png" alt="" />
                                                </a>
                                                <?php
                                            }
                                            if ($allowDelete || $allowEdit) {
                                                ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <div class="userWallPostTitleDate">
                                                <?php echo $wallPostReply->date; ?>
                                            </div>
                                            <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$srcUser->id)) ?>">
                                                <?php echo $replyUserName; ?>
                                            </a>
                                        </div>
                                        <div class="userWallPostComment">
                                            <?php echo htmlentities($wallPostReply->comment); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="userWallPostReplyBox">
                            <div class="userWallPostImage">
                                <img src="<?php echo $userProfileImage; ?>" alt="" title="" />
                            </div>
                            <div class="userWallPostBody">
                                <form method="post" action="<?php echo parent::link(array("action"=>"reply","parent"=>$wallPost->id,"userId"=>$userId)); ?>">
                                    <div class="userWallPostTextarea">
                                        <textarea name="<?php echo parent::alias("comment") ?>"></textarea>
                                    </div>
                                    <hr/>
                                    <div class="alignRight">
                                        <button class="jquiButton" type="submit" name="<?php echo parent::alias("submitButton"); ?>" value="1">
                                            <?php echo parent::getTranslation("userWall.button.reply"); ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
}

?>