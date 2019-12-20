<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('core/plugin.php');
include_once 'modules/forum/forumPageModel.php';

class ForumPageView extends XModule {

    public $action;
    public $thread;
    public $topic;
    public $post;
    public $parent;
    public $postMessage;
    public $threadTitle;
    public $threadMessage;
    public $topicName;

    function onProcess () {

        switch (parent::getAction()) {
            case "update":
                if (Context::hasRole("forum.admin")) {
                    parent::param("forumId", parent::post("selectedForum"));
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "edit":
                if (Context::hasRole("forum.admin")) {
                    parent::focus();
                }
                break;
            case "deleteThread":
            	if (Context::hasRole("forum.admin") || Context::hasRole("forum.moderator")) {
                    ForumPageModel::deleteThread(parent::get("thread"));
                    parent::blur();
                    parent::redirect();
            	}
                break;
            case "deletePost":
            	if (Context::hasRole("forum.admin") || Context::hasRole("forum.moderator")) {
                    ForumPageModel::deletePost(parent::get("post"));
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "deleteTopic":
                if (Context::hasRole("forum.admin") || Context::hasRole("forum.moderator")) {
                    ForumPageModel::deleteTopic(parent::get("topic"));
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "deleteForum":
                if (Context::hasRole("forum.admin")) {
                    ForumPageModel::deleteForum(parent::get("forumId"));
                    //parent::blur();
                    //parent::redirect();
                }
                break;
            case "saveThread":
            	if (Context::hasRole("forum.thread.create")) {
                    $validationMessages = ForumPageModel::validateThread(parent::get("topic"), parent::get("thread"), parent::post("threadTitel"), parent::post("threadMessage"));
                    if (empty($validationMessages)) {
                        ForumPageModel::saveThread(parent::get("topic"), parent::get("thread"), parent::post("threadTitel"), parent::post("threadMessage"));
                        parent::blur();
                        parent::redirect();
                    } else {
                        parent::setMessages($validationMessages);
                    }
                }
                break;
            case "savePost":
                if (Context::hasRole("forum.thread.post")) {
                    if (Captcha::validate("captcha")) {
                        ForumPageModel::savePost(parent::get("thread"), parent::get("post"), parent::post("postMessage"), Context::getUserId());
                        parent::blur();
                        parent::redirect();
                    } else {
                        parent::redirect(array("action"=>"captchaWrong"));
                    }
                }
                break;
            case "saveTopic":
                if (Context::hasRole("forum.topic.create")) {
                    ForumPageModel::saveTopic(parent::get("parent"), parent::get("topic"), parent::post("topicName"), Context::getUserId());
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "saveForum":
                if (Context::hasRole("forum.admin")) {
                    ForumPageModel::saveForum(parent::get("id"), parent::post("forumName"), Context::getSiteId());
                    //parent::blur();
                    //parent::redirect();
                }
                break;
            case "createForum":
                if (Context::hasRole("forum.admin")) {
                    parent::focus();
                }
                break;
            case "createThread":
                if (Context::hasRole("forum.thread.create")) {
                    parent::focus();
                }
                break;
            case "createPost":
                if (Context::hasRole("forum.thread.post")) {
                    parent::focus();
                }
                break;
            case "createTopic":
                if (Context::hasRole("forum.topic.create")) {
                    parent::focus();
                }
                break;
            case "viewThread":
                if (Context::hasRole("forum.view")) {
                    if (!isset($_SESSION['forum.views']) || !is_array($_SESSION['forum.views'])) {
                        $_SESSION['forum.views'] = array();
                    }    
                    if (!array_key_exists(parent::get("thread")."thr", $_SESSION['forum.views'])) {
                        ForumPageModel::viewThread(parent::get("thread"));
                        $_SESSION['forum.views'][parent::get("thread")."thr"] = '';
                    }
                }
                break;
            case "viewTopic":
                if (Context::hasRole("forum.view")) {
                    if (!isset($_SESSION['forum.views']) || !is_array($_SESSION['forum.views'])) {
                        $_SESSION['forum.views'] = array();
                    }    
                    if (!array_key_exists(parent::get("topic")."_top", $_SESSION['forum.views'])) {
                        ForumPageModel::viewTopic(parent::get("topic"));
                        $_SESSION['forum.views'][parent::get("topic")."_top"] = '';
                    }
                }
                break;
            case "viewUser":
            	NavigationModel::redirectStaticModule("userProfile", array("userId"=>parent::get("user")));
            	break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "newForum":
            case "saveForum":
            case "deleteForum":
            case "edit":
                $this->printEditView();
                break;
            case "createThread":
                if (Context::hasRole(array("forum.thread.create"))) {
                    $this->printCreateThreadView(parent::getId(), parent::get("parent"), parent::get("thread"));
                }
                break;
            case "createPost":
                if (Context::hasRole(array("forum.thread.post"))) {
                    $this->printCreateReplyView(parent::getId(), parent::get("thread"), parent::get("post"));
                }
                break;
            case "createTopic":
                if (Context::hasRole(array("forum.topic.create"))) {
                    $this->printCreateTopicView(parent::getId(), parent::get("topic"), parent::get("parent"));
                }
                break;
            case "viewThread":
                if (Context::hasRole(array("forum.view"))) {
                    $this->printViewThread(parent::getId(), parent::get("topic"), parent::get("thread"));
                }
                break;
		    case "captchaWrong":
				$this->printCaptchaWrongView();
			break;
            default:
                if (Context::hasRole(array("forum.view"))) {
                    $this->printMainView(parent::get("topic"));
                }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("forum.topic.create","forum.thread.create","forum.view","forum.admin","forum.moderator","forum.thread.post");
    }
    
    /**
     * returns style sheets used by this module
     */
    function getStyles () {
        return array("css/forum.css");
    }
    
    function printEditView () {
        
        $forums = ForumPageModel::getForums(Context::getSiteId());
        
        ?>
        <div class="panel">
            <form method="post" id="editForumForm" action="<?php echo parent::link(array("action"=>"update")) ?>">
                <table><tr>
                    <td class="nowrap">
                        Select Forum: 
                    </td>
                    <?php
                    if (count($forums) > 0) {
                        ?>
                        <td class="expand">
                            <?php InputFeilds::printSelect("selectedForum", parent::param("selectedForum"), Common::toMap($forums,"id","name")); ?>
                        </td>
                        <?php
                    }
                    ?>
                    <td>
                        <button id="btn_newForum">New</button>
                    </td>
                    <?php
                    if (count($forums) > 0) {
                        ?>
                        <td>
                            <button id="btn_editForum">Edit</button>
                        </td><td>
                            <button id="btn_deleteForum">Delete</button>
                        </td>
                        <?php
                    }
                    ?>
                    </tr></table>
            </form>
            
            
            <div id="new-forum-dialog" title="New Forum">
                <form method="post" id="new-forum-dialog-form" action="<?php echo parent::link(array("action"=>"saveForum")); ?>">
                    <table class="formTable"><tr>
                        <td><?php echo parent::getTranslation("forum.edit.new.label"); ?></td>
                        <td>
                            <?php
                            InputFeilds::printTextFeild("forumName");
                            ?>
                        </td>
                    </tr></table>
                </form>
            </div>
            
            <div id="edit-forum-dialog" title="Edit Forum Name">
                <form method="post" id="edit-forum-dialog-form" action="<?php echo parent::link(array("action"=>"saveForum")); ?>">
                    <table class="formTable"><tr>
                        <td><?php echo parent::getTranslation("forum.edit.new.label"); ?></td>
                        <td>
                            <?php
                            InputFeilds::printTextFeild("forumName");
                            ?>
                        </td>
                    </tr></table>
                </form>
            </div>
            
            <script type="text/javascript">
                $("#btn_newForum").button().click(function () {
                    $("#new-forum-dialog").dialog("open");
                });
                $("#btn_editForum").button().click(function () {
                    $("#selectedForum option:selected").each(function() {
                        $("#edit-forum-dialog #forumName").val($(this).text());
                        var action = $("#edit-forum-dialog-form").attr("action")
                        action += "&id=" + $("#selectedForum").val();
                        $("#edit-forum-dialog-form").attr({"action":action});
                    }
                    $("#edit-forum-dialog").dialog("open");
                });
                $("#btn_deleteForum").button().click(function () {
                    doIfConfirm('<?php echo parent::getTranslation("forum.delete.confirm") ?>',
                        '<?php echo parent::link(array("action"=>"deleteForum")); ?>',{"id":$("#selectedForum").val()});
                });
                $("#new-forum-dialog").dialog({
                    autoOpen: false, height: 300, width: 350, modal: true,
                    buttons: {
                        "Save": function() {
                            $("#new-forum-dialog-form").submit();
                        },
                        "Cancel": function() {
                            $(this).dialog("close");
                        }
                    }
                });
                $("#edit-forum-dialog").dialog({
                    autoOpen: false, height: 300, width: 350, modal: true,
                    buttons: {
                        "Save": function() {
                            $("#edit-forum-dialog-form").submit();
                        },
                        "Cancel": function() {
                            $(this).dialog("close");
                        }
                    }
                });
            </script>
        </div>
        <?php
    }

    function printCaptchaWrongView () {
    	?>
        <div class="panel forumPanel">
            <h3>Sorry you entered the security code wrong!</h3>
	</div>	
	<?php
    }

    function printMainView ($parentTopic) {
        
        $topics;
        $threads;
        if ($parentTopic == null) {
            $topics = ForumPageModel::getTopicsByForum(parent::param("forumId"));
            $threads = ForumPageModel::getThreadsByForum(parent::param("forumId"));
        } else {
            $topics = ForumPageModel::getTopics($parentTopic);
            $threads = ForumPageModel::getThreads($parentTopic);
        }
        
        # if this topic has threads display them
        
        ?>
        <div class="panel forumPage">

            <?php
            if (Context::hasRole(array("forum.topic.create"))) {
                echo " <a href='".parent::link(array("action"=>"createTopic","parent"=>$parentTopic))."'>Create Topic</a> ";
            }
            if (Context::hasRole(array("forum.thread.create"))) {
                echo " <a href='".parent::link(array("action"=>"createThread","parent"=>$parentTopic))."'>Create Thread</a> ";
            }
	if (count($threads) + count($topics) > 0) {
            ?>
            <br/>
	
            <table cellspacing="0" cellpadding="0" border="0" class="expand forum_table">
                <thead><tr>
                    <td></td>
                    <td class="expand"></td>
                    <td style="white-space:nowrap;">views |</td>
                    <td class="expand">replies</td>
                </tr></thead>
                <tbody>
                    <?php
                    foreach ($threads as $thread) {
                        ?>
                        <tr class="forum_thread_row"><td>
                            <div class="forum_thread_icon"></div>
                        </td><td class="expand forum_thread_titel">
                            <?php echo "<a class='forum_thread_titel_link' href='".parent::link(array("action"=>"viewThread","thread"=>$thread->id))."'>".htmlentities($thread->name,ENT_QUOTES)."</a><br/>"; ?>
                            <?php echo "by <a class='forum_thread_titel_link' href='".parent::link(array("action"=>"viewUser","user"=>$thread->userid))."'>".htmlentities($thread->username,ENT_QUOTES)."</a>"; ?>
                            <?php echo " - date: ".$thread->createdate; ?>
                            <?php
                            if (Context::hasRole(array("forum.moderator"))) {
                                ?>
                                <span style="float:right;">
                                    <a href="<?php echo parent::link(array("action"=>"createThread","thread"=>$thread->id,"parent"=>$parentTopic)); ?>">Edit</a> |
                                    <a href="<?php echo parent::link(array("action"=>"deleteThread","thread"=>$thread->id)); ?>">Delete</a>
                                </span>
                                <?php
                            }
                            ?>
                        </td><td class="expand forum_thread_views" align="center">
                            <?php echo $thread->views; ?>
                        </td><td class="expand forum_thread_replies" align="center">
                            <?php echo $thread->replies; ?>
                        </td></tr>
                        <?php
                    }
                    ?>
                    <?php
                    foreach ($topics as $topic) {
                        ?>
                        <tr class="forum_topic_row"><td>
                            <div class="forum_topic_icon"></div>
                        </td><td class="expand forum_topic_titel">
                            <?php echo "<a class='forum_topic_titel_link' href='".parent::link(array("action"=>"viewTopic","topic"=>$topic->id))."'>".htmlentities($topic->name,ENT_QUOTES)."</a><br/>"; ?>
                            <?php echo "by <a class='forum_topic_titel_link' href='".parent::link(array("action"=>"viewUser","topic"=>$topic->id))."'>".htmlentities($topic->username,ENT_QUOTES)."</a>"; ?>
                            <?php echo " - date: ".$topic->createdate; ?>
                            <?php
                            if (Context::hasRole(array("forum.moderator"))) {
                                ?>
                                <span style="float:right;">
                                    <a href="<?php echo parent::link(array("action"=>"createTopic","topic"=>$topic->id,"parent"=>$parentTopic)); ?>">Edit</a> |
                                    <a href="<?php echo parent::link(array("action"=>"deleteTopic","topic"=>$topic->id)); ?>">Delete</a>
                                </span>
                                <?php
                            }
                            ?>
                        </td><td class="expand forum_topic_views" align="center">
                            <?php echo $topic->views; ?>
                        </td><td class="expand forum_topic_replies" align="center">
                            <?php echo $topic->replies; ?>
                        </td></tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
	<?php
	}
	?>
        </div>
        <?php
    }
	
	function printUserInfo ($user) {
		$userAddress = UserAddressModule::getUserAddress($user->id);
		$userProfileImage = UsersModel::getUserImageUrl($user->id);
		?>
		
		<div class="forum_info_container">
			<div class="forum_info_image">
				<a href="<?php echo parent::link(array("action"=>"viewUser","user"=>$user->id)); ?>">
                	<img src="<?php echo $userProfileImage; ?>" alt="" />
                </a>
			</div>
			<div class="forum_info_name">
				<?php echo htmlspecialchars($user->username." (".$user->age.")"); ?>
			</div>
			<div class="forum_info_location">
				<?php echo htmlspecialchars($userAddress->country." ".$userAddress->city); ?>
			</div>
			<div class="forum_info_posts">
				<?php echo ForumPageModel::getUserTotalPosts($user->id); ?>
			</div>
			
		</div>
		
		<?php
	}
	
    function printViewThread($pageId, $topicId, $threadId) {
        $thread = ForumPageModel::getThread($threadId);
        $replies = ForumPageModel::getPosts($threadId);
        $threadUserProfileImage = UsersModel::getUserImageSmallUrl($thread->userid);
        ?>
        <div class="panel forumPanel">
        	<div class="forum_thread_buttons">
        		<a class="jquiButton" href="<?php echo parent::link(array("action"=>"createPost","thread"=>$thread->id)); ?>"><?php echo parent::getTranslation("forum.thread.reply"); ?></a> |
            	<a class="jquiButton" onclick="" href="javascript:history.back();"><?php echo parent::getTranslation("forum.thread.back"); ?></a>
            </div>
        	<div class="forum_thread_message_container">
        		<div class="forum_thread_message">
	        		<div class="forum_layout_left">
		        		<?php $this->printUserInfo($user); ?>
		        	</div>
		        	<div class="forum_layout_center">
		        		<div class="forum_thread_message_titel">
			        		<?php echo htmlentities($thread->name,ENT_QUOTES); ?>
			        	</div>
			        	<div class="forum_thread_message_body">
			        		<?php echo htmlentities($thread->message,ENT_QUOTES); ?>
			        	</div>
		        	</div>
	        	</div>
        	</div>
        	<div class="forum_thread_replys_container">
        		<?php
	            foreach ($replies as $reply) {
	            	$replyUser = UsersModel::getUser($reply->userid);
	            	$userProfileImage = UsersModel::getUserImageSmallUrl($reply->userid);
        			?>
        			<div class="forum_thread_reply">
		        		<div class="forum_layout_left">
			        		<?php $this->printUserInfo($replyUser); ?>
			        	</div>
			        	<div class="forum_layout_center">
			        		<div class="forum_thread_message_titel">
				        		
				        	</div>
				        	<div class="forum_thread_message_body">
				        		<?php echo htmlentities($reply->message,ENT_QUOTES); ?>
				        	</div>
			        	</div>
		        	</div>
        			<?php
    			}
    			?>
        	</div>
        	<div class="forum_thread_buttons">
        		<a class="jquiButton" href="<?php echo parent::link(array("action"=>"createPost","thread"=>$thread->id)); ?>"><?php echo parent::getTranslation("forum.thread.reply"); ?></a> |
            	<a class="jquiButton" onclick="" href="javascript:history.back();"><?php echo parent::getTranslation("forum.thread.back"); ?></a>
            </div>
        
            <br/><br/>
            <table class="expand"><tr><td valign="top">
                <div class="forum_thread_postdata">
                    <a class="forum_thread_titel_link" href="<?php echo parent::link(array("action"=>"viewUser","user"=>$thread->userid)); ?>">
                    	<img src="<?php echo $threadUserProfileImage; ?>" alt="" />
                    </a>
                    <a class="forum_thread_titel_link" href="<?php echo parent::link(array("action"=>"viewUser","user"=>$thread->userid)); ?>"><?php echo $thread->username; ?></a><br/>
                    <span class="nowrap"><?php echo htmlentities($thread->createdate,ENT_QUOTES); ?></span>
                </div>
            </td><td class="expand">
                <b><?php echo htmlentities($thread->name,ENT_QUOTES); ?></b>
                <?php
                if (Context::hasRole(array("forum.moderator"))) {
                    ?>
                    <span style="float:right;">
                        <a href="<?php echo parent::link(array("action"=>"createThread","thread"=>$thread->id,"parent"=>$thread->parent)); ?>">Edit</a> |
                        <a href="<?php echo parent::link(array("action"=>"deleteThread","thread"=>$thread->id)); ?>">Delete</a>
                    </span>
                    <?php
                }
                ?>
                <br/><hr><br/>
                <?php echo htmlentities($thread->message,ENT_QUOTES); ?>
            </td></tr></table>
            <?php
            foreach ($replies as $reply) {
            	$userProfileImage = UsersModel::getUserImageSmallUrl($reply->srcuser);
                ?>
                <br/><hr/>
                <table class="expand"><tr><td valign="top">
                    <div class="forum_thread_postdata">
                        <a class="forum_thread_titel_link" href="<?php echo parent::link(array("action"=>"viewUser","user"=>$reply->userid)); ?>">
                        	<img src="<?php echo $userProfileImage; ?>" alt="" />
                        </a><br/>
                        <a class="forum_thread_titel_link" href="<?php echo parent::link(array("action"=>"viewUser","user"=>$reply->userid)); ?>"><?php echo $reply->username; ?></a><br/>
                        <span class="nowrap"><?php echo htmlentities($reply->createdate,ENT_QUOTES); ?></span>
                    </div>
                </td><td class="expand">
                    <?php
                    if (Context::hasRole(array("forum.moderator"))) {
                        ?>
                        <span style="float:right;">
                            <a href="<?php echo parent::link(array("action"=>"createPost","post"=>$reply->id)); ?>">Edit</a> |
                            <a href="<?php echo parent::link(array("action"=>"deletePost","post"=>$reply->id)); ?>">Delete</a>
                        </span>
                        <?php
                    }
                    ?>
                    <?php echo htmlentities($reply->message,ENT_QUOTES); ?>
                </td></tr></table>
                <?php
            }
            ?>
            <br/><hr/>
            <a href="<?php echo parent::link(array("action"=>"createPost","thread"=>$thread->id)); ?>">Reply</a> |
            <a onclick="" href="javascript:history.back();">Back to topic</a>
        </div>
        <?php
    }

    function printCreateThreadView ($pageId,$topic,$threadId) {
        $name = ""; $message = "";
        if (!Common::isEmpty($threadId)) {
            $thread = ForumPageModel::getThread($threadId);
            $name = $thread->name;
            $message = $thread->message;
        }
        ?>
        <div class="panel forumPage">
            <form method="post" action="<?php echo parent::link(array("action"=>"saveThread","thread"=>$threadId,"topic"=>$topic)); ?>">
                <b>Titel</b><br/>
                <input name="threadTitel" class="expand" type="text" value="<?php echo htmlentities($name, ENT_QUOTES); ?>" />
                <br/><br/><b>Message</b><br/>
                <textarea cols="10" rows="10" class="expand" name="threadMessage"><?php echo htmlentities($message, ENT_QUOTES); ?></textarea>
                <br/><br/><b>Security Code:</b><br/>
                <?php 
                InputFeilds::printCaptcha("captcha");
                ?>
                <hr/>
		<div class="alignRight">
                	<button type="submit">Submit</button>
                	<button onclick="history.back(); return false;">Cancel</button>
		</div>
            </form>
        </div>
	<script>
	$(".forumPage .alignRight button").each(function (index,object){
		$(object).button();
	});
	</script>
        <?php
    }

    function printCreateReplyView ($pageId,$threadId,$postId) {
        $message = "";
        if (!Common::isEmpty($postId)) {
            $post = ForumPageModel::getPost($postId);
            $message = $post->message;
        }
        ?>
        <div class="panel forumPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"savePost","thread"=>$threadId,"post"=>$postId)); ?>">
                <b>Message</b><br/>
                <textarea cols="10" rows="10" class="expand" name="postMessage"><?php echo htmlentities($message,ENT_QUOTES); ?></textarea>
                <br/>
                <hr/>
		<div class="alignRight">
               		<button type="submit">Submit</button>
                	<button onclick="history.back(); return false;">Cancel</button>
		</div>
            </form>
        </div>
	<script>
	$(".forumPanel .alignRight button").each(function (index,object){
		$(object).button();
	});
	</script>
        <?php
    }

    function printCreateTopicView ($pageId,$topicId,$parentTopic) {
        $name = "";
        if (!Common::isEmpty($topicId)) {
            $topic = ForumPageModel::getTopic($topicId);
            $name = $topic->name;
        }
        ?>
        <div class="panel forumPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"saveTopic","topic"=>$topicId,"parent"=>$parentTopic)); ?>">
                <b>Topic name:</b><br/>
                <input type="text" class="expand" name="topicName" value="<?php echo htmlentities($name,ENT_QUOTES) ?>" />
                <br/>
                <hr/>
		<div class="alignRight">
               		<button type="submit">Submit</button>
                	<button onclick="history.back(); return false;">Cancel</button>
		</div>
            </form>
        </div>
	<script>
	$(".forumPanel .alignRight button").each(function (index,object){
		$(object).button();
	});
	</script>
        <?php
    }
}

?>