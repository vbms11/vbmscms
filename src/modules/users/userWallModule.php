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
                if (Context::hasRole("user.profile.owner")) {
                    if (parent::post("submitButton") && UserWallModel::canUserPost(parent::get("userId"))) {
                        $validationMessages = UserWallModel::validateWallPost(parent::get("userId"), Context::getUserId(), parent::post("comment"));
                        if (count($validationMessages) > 0) {
                            parent::setMessages($validationMessages);
                        } else {
                            $wallEventPostId = UserWallModel::createUserWallEventPost(parent::get("userId"), Context::getUserId(), parent::post("comment"));
                            if (parent::get("userId") !== Context::getUserId()) {
                                SocialController::notifyWallPost($wallEventPostId);
                            }
                            parent::clearMessages();
                            parent::redirect();
                        }
                    }
                }
                break;
            case "reply":
                if (Context::hasRole("user.profile.owner")) {
                    if (parent::post("submitButton") && UserWallModel::canUserPost(parent::get("userId"))) {
                        $validationMessages = UserWallModel::validateWallPost(parent::get("userId"), Context::getUserId(), parent::post("comment"), parent::get("eventId"));
                        if (count($validationMessages) > 0) {
                            parent::setMessages($validationMessages);
                        } else {
                            $wallEventPostId = UserWallModel::createUserWallEventPost(parent::get("userId"), Context::getUserId(), parent::post("comment"), parent::get("eventId"));
                            if (parent::get("userId") !== Context::getUserId()) {
                                SocialController::notifyWallReply($wallEventPostId);
                            }
                            parent::clearMessages();
                            parent::redirect();
                        }
                    }
                }
                break;
            case "deleteEvent":
                $userId = $this->getModeUserId();
                $comment = UserWallModel::getUserWallEventById(parent::get("id"));
                if ($userId == Context::getUserId() || $comment->userid == Context::getUserId()) {
                    UserWallmodel::deleteWallEventById(parent::get("id"));
                }
                if (Context::isAjaxRequest()) {
                    Context::setReturnValue("");
                }
                parent::redirect();
                break;
            case "deleteComment":
                $userId = $this->getModeUserId();
                $comment = UserWallModel::getUserWallPostById(parent::get("id"));
                if ($userId == Context::getUserId() || $comment->srcuserid == Context::getUserId()) {
                    UserWallmodel::deleteUserPostById(parent::get("id"));
                }
                if (Context::isAjaxRequest()) {
                    Context::setReturnValue("");
                } else {
                    parent::redirect();
                }
                break;
            case "editComment":
                if (parent::post("submitButton")) {
                    $post = UserWallModel::getUserWallPostById(parent::get("id"));
                    $validationMessages = UserWallModel::validateWallPost($post->srcuserid, Context::getUserId(), parent::post("comment"));
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
                if (parent::param("mode") == self::modeSelectedUser && parent::get("userId")) {
                    Context::setSelectedUser(parent::get("userId"));
                } else if (parent::param("mode") == self::modeCurrentUser) {
                    Context::setSelectedUser(Context::getUserId());
                }
                parent::clearMessages();
                parent::blur();
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
        
        $post = UserWallModel::getUserWallPostById($postId);
        $userProfileImage = UsersModel::getUserImageSmallUrl($post->srcuserid);
        
        $comment = $post->comment;
        if (parent::post("comment")) {
            $comment = parent::post("comment");
        }
        
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
                                <textarea name="<?php echo parent::alias("comment"); ?>"><?php echo htmlentities($comment); ?></textarea>
                                <?php
                                $message = parent::getMessage("comment");
                                if (!empty($message)) {
                                    echo '<span class="validateTips">'.$message.'</span>';
                                }
                                ?>
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
        
        $wallEvents = array();
        if (!empty($userId)) {
            $wallEvents = UserWallModel::getUserWallEventsByUserId($userId);
        }
        
        $currentUserProfileImage = UsersModel::getUserImageSmallUrl(Context::getUserId());
        
        $comment = "";
        if (parent::getAction() == "comment" || parent::getAction() == "reply") {
            $comment = parent::post("comment");
        }
        
        ?>
        <div class="panel usersWallPanel">
            <?php
            
            if (!empty($userId) && UserWallModel::canUserPost($userId)) {
                ?>
                <div class="userWallPostCommentBox">
                    <div class="userWallPostImage">
                        <img src="<?php echo $currentUserProfileImage; ?>" alt="" title="" />
                    </div>
                    <div class="userWallPostBody">
                        <form method="post" action="<?php echo parent::link(array("action"=>"comment","userId"=>$userId)); ?>">
                            <div class="userWallPostTextarea">
                                <textarea name="<?php echo parent::alias("comment") ?>"><?php echo parent::getAction() == "comment" ? htmlentities($comment) : ""; ?></textarea>
                                <?php
                                $message = parent::getMessage("comment");
                                if (!empty($message)) {
                                    echo '<span class="validateTips">'.$message.'</span>';
                                }
                                ?>
                            </div>
                            <hr/>
                            <div class="alignRight">
                                <button class="jquiButton" type="submit" name="<?php echo parent::alias("submitButton"); ?>" value="1">
                                    <?php echo parent::getTranslation("userWall.button.comment"); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="clear"></div>
                </div>
                <?php
            }
            
            if (!empty($wallEvents)) {
                $wallEventsCount = count($wallEvents);
                for ($i=0; $i<$wallEventsCount; $i++) {
                    
                    $originalEvent = $wallEvents[$i];
                    $sameTypeEvents = array($originalEvent);
                    
                    while ($i+1 < $wallEventsCount && $wallEvents[$i+1]->type === $originalEvent->type) {
                        
                        if ($wallEvents[$i+1]->type !== UserWallModel::type_friend && $wallEvents[$i+1]->type === UserWallModel::type_image) {
                            break;
                        }
                        
                        $sameTypeEvents[] = $wallEvents[$i+1];
                        $i++;
                    }
                    
                    ?>
                    <div class="userWallPostThread">    
                        <?php

                        switch ($wallEvent->type) {

                            case UserWallModel::type_wall:
                                $this->printEventTypeWall($originalEvent);
                                break;
                            case UserWallModel::type_birthday:
                                $this->printEventTypeBirthday($originalEvent);
                                break;
                            case UserWallModel::type_register:
                                $this->printEventTypeRegister($originalEvent);
                                break;
                            case UserWallModel::type_friend:
                                $this->printEventTypeFriend($sameTypeEvents);
                                break;
                            case UserWallModel::type_image:
                                $this->printEventTypeImage($sameTypeEvents);
                                break;
                            //case UserWallModel::type_share:
                            //    $this->printEventTypeShare($originalEvent);
                            //    break;
                        }
                        
                        ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
    
    function printWallEventPosts ($wallEventPosts) {
        
        foreach ($wallEventPosts as $wallPostReply) {

            $replyUser = UsersModel::getUser($wallPostReply->srcuserid);
            $replyUserName = $replyUser->firstname." ".$replyUser->lastname;
            $replyUserImage = UsersModel::getUserImageSmallUrl($replyUser->id);
            ?>
            <div class="userWallPostReply">
                <div class="userWallPostImage">
                    <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$replyUser->id)) ?>">
                        <img src="<?php echo $replyUserImage; ?>" alt="" title="" />
                    </a>
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
                        if ($this->getModeUserId() == Context::getUserId()) {
                            $allowDelete = true;
                        }
                        if ($allowDelete || $allowEdit) {
                            ?>
                            <div class="userWallPostTitleTools">
                                <?php
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
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="userWallPostTitleDate">
                            <?php echo $wallPostReply->date; ?>
                        </div>
                        <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$replyUser->id)) ?>">
                            <?php echo $replyUserName; ?>
                        </a>
                    </div>
                    <div class="userWallPostComment">
                        <?php echo htmlentities($wallPostReply->comment); ?>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <?php
        }
        if (UserWallModel::canUserPost(Context::getUserId())) {
            
            
            
            ?>
            <div class="userWallPostReplyBox">
                <div class="userWallPostImage">
                    <img src="<?php echo $currentUserProfileImage; ?>" alt="" title="" />
                </div>
                <div class="userWallPostBody">
                    <form method="post" action="<?php echo parent::link(array("action"=>"reply","eventId"=>$wallEvent->id,"userId"=>Context::getUserId())); ?>">
                        <div class="userWallPostTextarea">
                            <textarea name="<?php echo parent::alias("reply") ?>"><?php parent::getAction() == "reply" ? htmlentities($comment) : ""; ?></textarea>
                            <?php
                            $message = parent::getMessage("comment");
                            if (!empty($message)) {
                                echo '<span class="validateTips">'.$message.'</span>';
                            }
                            ?>
                        </div>
                        <hr/>
                        <div class="alignRight">
                            <button class="jquiButton" type="submit" name="<?php echo parent::alias("submitButton"); ?>" value="1">
                                <?php echo parent::getTranslation("userWall.button.reply"); ?>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="clear"></div>
            </div>
            <?php
        }
    }
    
    function printEventPost ($wallEventPosts) {
        
        $currentUserProfileImage = UsersModel::getUserImageSmallUrl(Context::getUserId());
        
        $srcUser = UsersModel::getUser($wallEvent->userid);
        $srcUserName = $srcUser->firstname." ".$srcUser->lastname;
        $userProfileImage = UsersModel::getUserImageSmallUrl($srcUser->id);

        $wallEventPosts = UserWallModel::getUserWallPostsByEventId($wallEvent->id);
        $originalPost = next($wallEventPosts);
        
        ?>
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
                    if (Context::getUserId() == $originalPost->srcuserid) {
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
                            if ($allowDelete) {
                                ?>
                                <img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("userWall.dialog.confirmDelete"); ?>','<?php echo parent::link(array("action"=>"deleteEvent","id"=>$wallEvent->id),false); ?>');" />
                                <?php
                            }
                            if ($allowEdit) {
                                ?>
                                <a href="<?php echo parent::link(array("action"=>"editComment","id"=>$originalPost->id)); ?>">
                                    <img src="resource/img/preferences.png" alt="" />
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="userWallPostTitleDate">
                        <?php echo $originalPost->date; ?>
                    </div>
                    <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$srcUser->id)); ?>">
                        <?php echo $srcUserName; ?>
                    </a>
                </div>
                <div class="userWallPostComment">
                    <?php echo htmlentities($originalPost->comment); ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <?php
        $this->printWallEventPosts($wallEventPosts);
    }
    
    function printEventTypeBirthday ($originalEvent) {
        
        ?>
        <div class="userWallBirthday">
            <div class="userWallPostImage">
                <img src="modules/users/img/birthday.png" alt="" title="" />
            </div>
            <div class="userWallPostBody">
                <?php
                echo parent::getTranslation("userWall.birthday.message");
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php
        $wallEventPosts = UserWallModel::getUserWallPostsByEventId($originalEvent->id);
        $this->printWallEventPosts($wallEventPosts);
    }
    
    function printEventTypeRegister($originalEvent) {
        
        ?>
        <div class="userWallRegister">
            <div class="userWallPostImage">
                <img src="modules/users/img/register.png" alt="" title="" />
            </div>
            <div class="userWallPostBody">
                <?php
                echo parent::getTranslation("userWall.register.message");
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php
        $wallEventPosts = UserWallModel::getUserWallPostsByEventId($originalEvent->id);
        $this->printWallEventPosts($wallEventPosts);
    }
    
    function printEventTypeFriend($sameTypeEvents) {
        
        $newFriends = array();
        foreach ($sameTypeEvents as $sameTypeEvent) {
            
            $user = UsersModel::getUser($sameTypeEvent->typeid);
            $username = $user->firstname." ".$user->lastname;
            $newFriends []= '<a href="'.parent::staticLink("userProfile",array("userId"=>$user->id)).'">'.$username.'</a>';
        }
        
        $newFriendsString = implode(", ", $newFriends);
        
        ?>
        <div class="userWallFriend">
            <div class="userWallPostImage">
                <img src="modules/users/img/friend.png" alt="" title="" />
            </div>
            <div class="userWallPostBody">
                <?php
                echo parent::getTranslation("userWall.friend.message", array("friends",$newFriendsString));
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php
        $eventIds = array();
        foreach ($sameTypeEvents as $sameTypeEvent) {
            $eventIds []= $sameTypeEvent;
        }
        $wallEventPosts = UserWallModel::getUserWallPostsByEventIds($eventIds);
        $this->printWallEventPosts($wallEventPosts);
    }
    
    function printEventTypeImage ($sameTypeEvents) {
        
        Context::addRequiredScript("resource/js/lightbox/js/jquery.lightbox-0.5-pack.js");
        Context::addRequiredStyle("resource/js/lightbox/css/jqzery.lightbox-0.5.css");
        
        ?>
        <div class="userWallImage">
            <div class="userWallPostImage">
                <img src="modules/users/img/image.png" alt="" title="" />
            </div>
            <div class="userWallPostBody">
                <?php
                foreach ($sameTypeEvents as $sameTypeEvent) {
                    $image = GalleryModel::getImage($sameTypeEvent->typeid);
                    ?>
                    <a href="<?php echo ResourcesModel::createResourceLink("gallery",$image->image); ?>">    
                        <img src="<?php echo ResourcesModel::createResourceLink("gallery/small",$image->image); ?>" alt=""/>
                    </a>
                    <?php
                }
                ?>
                <script type="text/javascript">
                $('.userWallImage a').lightBox();
                </script>
            </div>
            <div class="clear"></div>
        </div>
        <?php
        $endEvent = end($sameTypeEvents);
        $this->printWallEventPosts($endEvent);
    }
    
    /*
    function printEventTypeShare($originalEvent) {
    }
    */
    
}

?>