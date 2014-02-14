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

        $this->getRequestVars();
        
        switch (parent::getAction()) {
            case "deleteThread":
                ForumPageModel::deleteThread($this->thread);
                parent::blur();
                parent::redirect();
                break;
            case "deletePost":
                ForumPageModel::deletePost($this->post);
                parent::blur();
                parent::redirect();
                break;
            case "deleteTopic":
                ForumPageModel::deleteTopic($this->topic);
                parent::blur();
                parent::redirect();
                break;
            case "saveThread":
                ForumPageModel::saveThread($this->topic, $this->thread, $this->threadTitel, $this->threadMessage);
                parent::blur();
                parent::redirect();
                break;
            case "savePost":
		if (Captcha::validate("captcha")) {
			ForumPageModel::savePost($this->thread, $this->post, $this->postMessage, Context::getUserId());
                	parent::blur();
                	parent::redirect();
		} else {
			parent::redirect(array("action"=>"captchaWrong"));
		}
                break;
            case "saveTopic":
                ForumPageModel::saveTopic($this->parent, $this->topic, $this->topicName, Context::getUserId());
                parent::blur();
                parent::redirect();
                break;
            case "createThread":
                Context::hasRole(array("forum.thread.create"));
                parent::focus();
                break;
            case "createPost":
                Context::hasRole(array("forum.thread.post"));
                parent::focus();
                break;
            case "createTopic":
                Context::hasRole(array("forum.topic.create"));
                parent::focus();
                break;
            case "viewThread":
                Context::hasRole(array("forum.view"));
                if (!isset($_SESSION['forum.views']) || !is_array($_SESSION['forum.views'])) {
                    $_SESSION['forum.views'] = array();
                }    
                if (!array_key_exists($this->thread."thr", $_SESSION['forum.views'])) {
                    ForumPageModel::viewThread($this->thread);
                    $_SESSION['forum.views'][$this->thread."thr"] = '';
                }
                break;
            case "viewTopic":
                Context::hasRole(array("forum.view"));
                if (!isset($_SESSION['forum.views']) || !is_array($_SESSION['forum.views'])) {
                    $_SESSION['forum.views'] = array();
                }    
                if (!array_key_exists($this->topic."_top", $_SESSION['forum.views'])) {
                    ForumPageModel::viewTopic($this->topic);
                    $_SESSION['forum.views'][$this->topic."_top"] = '';
                }
                
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        $this->getRequestVars();

        switch ($this->action) {
            case "createThread":
                if (Context::hasRole(array("forum.thread.create"))) {
                    $this->printCreateThreadView(parent::getId(), $this->parent, $this->thread);
                }
                break;
            case "createPost":
                if (Context::hasRole(array("forum.thread.post"))) {
                    $this->printCreateReplyView(parent::getId(), $this->thread, $this->post);
                }
                break;
            case "createTopic":
                if (Context::hasRole(array("forum.topic.create"))) {
                    $this->printCreateTopicView(parent::getId(), $this->topic, $this->parent);
                }
                break;
            case "viewThread":
                if (Context::hasRole(array("forum.view"))) {
                    $this->printViewThread(parent::getId(), $this->topic, $this->thread);
                }
                break;
	    case "captchaWrong":
		$this->printCaptchaWrongView();
		break;
            default:
                if (Context::hasRole(array("forum.view"))) {
                    $this->printMainView(parent::getId(),$this->topic);
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


    function getRequestVars () {
        if (isset($_GET['action'])) $this->action = $_GET['action'];
        if (isset($_GET['thread'])) $this->thread = $_GET['thread'];
        if (isset($_GET['topic'])) $this->topic = $_GET['topic'];
        if (isset($_GET['post'])) $this->post = $_GET['post'];
        if (isset($_GET['topic'])) $this->topic = $_GET['topic'];
        if (isset($_GET['parent'])) $this->parent = $_GET['parent'];
        if (isset($_POST['postMessage'])) $this->postMessage = $_POST['postMessage'];
        if (isset($_POST['threadMessage'])) $this->threadMessage = $_POST['threadMessage'];
        if (isset($_POST['threadTitel'])) $this->threadTitel = $_POST['threadTitel'];
        if (isset($_POST['threadPost'])) $this->threadPost = $_POST['threadPost'];
        if (isset($_POST['topicName'])) $this->topicName = $_POST['topicName'];
    }


    function printCaptchaWrongView () {
    	?>
        <div class="panel forumPanel">
		<h3>Sorry you entered the security code wrong!</h3>
	</div>	
	<?php
    }

    function printMainView ($pageId,$parentTopic) {

        $topics = ForumPageModel::getTopics($parentTopic);
        $threads = ForumPageModel::getThreads($parentTopic);

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
                    <td>&nbsp;</td><td class="expand">
                        &nbsp;
                    </td><td style="white-space:nowrap;">
                        views |
                    </td><td class="expand">
                        &nbsp;replies
                    </td></tr>
                </thead>
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

    function printViewThread($pageId, $topicId, $threadId) {
        $thread = ForumPageModel::getThread($threadId);
        $replies = ForumPageModel::getPosts($threadId);
        ?>
        <div class="panel forumPage">
            <a href="<?php echo parent::link(array("action"=>"createPost","thread"=>$thread->id)); ?>">Reply</a> |
            <a onclick="" href="javascript:history.back();">Back to topic</a>
            <br/><br/>
            <table class="expand"><tr><td valign="top">
                <div class="forum_thread_postdata">
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
                ?>
                <br/><hr/>
                <table class="expand"><tr><td valign="top">
                    <div class="forum_thread_postdata">
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