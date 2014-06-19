<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('core/plugin.php');
require_once('modules/forum/forumPageModel.php');

class UserMessageModule extends XModule {
    
    const modeSelectedUser = 1;
    const modeCurrentUser = 2;
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("message.edit")) {
                    parent::param("mode",parent::post("mode"));
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "edit":
                if (Context::hasRole("message.edit")) {
                    parent::focus();
                }
                break;
            case "deleteMessage":
                if (Context::hasRole(array("message.inbox"))) {
                    $pm = ForumPageModel::getPm(parent::get("id"));
                    if (!empty($pm) && $pm->dstuser == Context::getUserId()) {
                        ForumPageModel::deletePm(parent::get("id"));
                    }
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "send":
                if (Context::hasRole(array("message.inbox"))) {
                    $validationMessages = ForumPageModel::validatePm(parent::post('subject'), parent::post('message'));
                    if (count($validationMessages) == 0) {$messageId = ForumPageModel::savePm(Context::getUserId(), Context::getSelectedUserId(), parent::post('subject'), parent::post('message'));
                        SocialController::notifyMessageSent($messageId);
                        parent::blur();
                        parent::redirect(array("action"=>"sent"));
                    } else {
                        parent::setMessages($validationMessages);
                    }
                }
                break;
            case "doReply":
                if (Context::hasRole(array("message.inbox"))) {
                    $validationMessages = ForumPageModel::validatePm(parent::post('subject'), parent::post('message'));
                    if (count($validationMessages) == 0) {
                        $messageId = ForumPageModel::savePm(Context::getUserId(), parent::get("dstUserId"), parent::post('subject'), parent::post('message'));
                        SocialController::notifyMessageSent($messageId);
                        parent::blur();
                        parent::redirect(array("action"=>"sent"));
                    } else {
                        parent::setMessages($validationMessages);
                    }
                }
                break;
            case "view":
                ForumPageModel::viewPm(parent::get("id"));
                break;
            case "reply":
                break;
            case "sent":
                break;
            default:
                if (parent::param("mode") == self::modeSelectedUser && parent::get("userId")) {
                    Context::setSelectedUser(parent::get("userId"));
                } else if (parent::param("mode") == self::modeCurrentUser) {
                    Context::setSelectedUser(Context::getUserId());
                }
                parent::clearMessages();
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("message.edit")) {
                    $this->printEditView();
                }
                break;
            case "new":
            case "send":
                if (Context::hasRole(array("message.inbox"))) {
                    $this->printCreateMessageView();
                }
                break;
            case "sent":
                $this->printSentView();
                break;
            case "view":
                $this->printViewView();
                break;
            case "reply":
            case "doReply":
                $this->printReplyView();
                break;
            default:
                if (Context::hasRole(array("message.inbox"))) {
                    if (Context::getSelectedUserId() == Context::getUserId() || Context::hasRoleGroup("admin")) {
                        $this->printMainView();
                    }
                }
        }
    }
    
    function getRoles () {
        return array("message.inbox","message.edit");
    }
    
    function getStyles () {
        return array("css/userMessages.css");
    }
    
    function printEditView () {
        ?>
        <div class="panel userMessageEditPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("userMessage.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentUser=>"Current User Messages",self::modeSelectedUser=>"Selected User Messages")); ?>
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
        
        $messages = ForumPageModel::getPms(Context::getUserId());
        ?>
        <div class="panel userMessagePanel">
            <h1><?php echo parent::getTranslation("userMessage.title"); ?></h1>
            <?php
            if (empty($messages)) {
                ?>
                <p><?php echo parent::getTranslation("userMessage.noMessages"); ?></p>
                <?php
            } else {
                ?>
                <p><?php echo parent::getTranslation("userMessage.description"); ?></p>
                <table class="resultTable" cellspacing="0">
                    <thead><tr><td class="contract nowrap">
                        <?php echo parent::getTranslation("userMessage.table.user"); ?>
                    </td><td>
                        <?php echo parent::getTranslation("userMessage.table.title"); ?>
                    </td><td class="contract">
                        <?php echo parent::getTranslation("userMessage.table.status"); ?>
                    </td><td class="contract">
                        <?php echo parent::getTranslation("userMessage.table.date"); ?>
                    </td><td class="contract">
                        <?php echo parent::getTranslation("userMessage.table.tools"); ?>
                    </td></tr></thead>
                    <tbody>
                        <?php
                        foreach ($messages as $message) {
                            ?>
                            <tr><td>
                                <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$message->srcuser)); ?>">
                                    <img alt="" src="<?php echo UsersModel::getUserImageSmallUrl($message->srcuser); ?>" />
                                </a>
                                <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$message->srcuser)); ?>">
                                    <?php echo htmlentities($message->srcusername); ?>
                                </a>
                            </td><td>
                                <a href="<?php echo parent::link(array("action"=>"view","id"=>$message->id)); ?>">
                                    <?php echo htmlentities($message->subject); ?>
                                </a>
                            </td><td>
                                <?php
                                if ($message->opened != "1") {
                                    echo parent::getTranslation("userMessage.table.new");
                                }
                                ?>
                            </td><td>
                                <?php echo htmlentities($message->senddate); ?>
                            </td><td>
                                <a onclick="return confirm('<?php echo parent::getTranslation("userMessage.table.delete"); ?>')" href="<?php echo parent::link(array("action"=>"deleteMessage","id"=>$message->id)); ?>"><img src="resource/img/delete.png" alt=""/></a>
                            </td></tr>
                            <?php
                        }
                        ?>
                </tbody></table>
                <?php
            }
            ?>
        </div>
        <?php
    }
    
    function printCreateMessageView () {
        $user = UsersModel::getUser(Context::getSelectedUserId());
        ?>
        <div class="panel createUserMessagePanel">
            <h1><?php echo parent::getTranslation("userMessage.create.title"); ?></h1>
            <p><?php echo parent::getTranslation("userMessage.create.description"); ?></p>
            <form name="createMessageForm" method="post" action="<?php echo parent::link(array("action"=>"send")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("userMessage.create.toUser"); ?>
                </td><td>
                    <input type="textbox" name="dstuser" value="<?php echo htmlentities($user->firstname." ".$user->lastname); ?>" disabled="true" />
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("userMessage.create.subject"); ?>
                </td><td>
                    <input type="textbox" name="subject" value="<?php echo htmlentities(parent::post("subject"), ENT_QUOTES); ?>" />
                    <?php
                    $message = parent::getMessage("subject");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("userMessage.create.message"); ?>
                </td><td>
                    <textarea name="message" cols="4" rows="4"><?php echo htmlentities(parent::post("message")); ?></textarea>
                    <?php
                    $message = parent::getMessage("message");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("userMessage.create.send"); ?></button> 
                </div>
            </form>
        </div>
        <?php
    }
    
    function printSentView () {
        ?>
        <div class="panel sentUserMessagePanel">
            <h1><?php echo parent::getTranslation("userMessage.sent.title"); ?></h1>
            <p><?php echo parent::getTranslation("userMessage.sent.description"); ?></p>
        </div>
        <?php
    }
    
    function printViewView () {
        $message = ForumPageModel::getPm(parent::get("id"));
        $srcUserImageUrl = UsersModel::getUserImageSmallUrl($message->srcuser);
        ?>
        <div class="panel viewUserMessagePanel">
            <h1><?php echo parent::getTranslation("userMessage.view.title"); ?></h1>
            <p><?php echo parent::getTranslation("userMessage.view.description"); ?></p>
            <hr/>
            <form name="viewMessageForm" method="post" action="<?php echo parent::link(array("action"=>"reply","id"=>parent::get("id"))); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("userMessage.view.fromUser"); ?>
                </td><td>
                    <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$message->srcuser)); ?>">
                        <img alt="<?php echo htmlentities($message->srcusername,ENT_QUOTES); ?>" src="<?php echo $srcUserImageUrl; ?>">
                    </a> 
                    <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$message->srcuser)); ?>">
                        <?php echo htmlentities($message->srcusername); ?>
                    </a>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("userMessage.view.subject"); ?>
                </td><td>
                    <?php echo htmlentities($message->subject); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("userMessage.view.message"); ?>
                </td><td>
                    <?php echo htmlentities($message->message); ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("userMessage.create.reply"); ?></button>
                    <button type="button" class="jquiButton" id="deleteMessage"><?php echo parent::getTranslation("userMessage.create.delete"); ?></button>
                    <button type="button" class="jquiButton" id="backToInbox"><?php echo parent::getTranslation("userMessage.create.back"); ?></button>
                </div>
            </form>
            <script>
            $("#deleteMessage").click(function(){
                callUrl("<?php echo parent::link(array("action"=>"deleteMessage","id"=>$message->id),false); ?>");
            });
            $("#backToInbox").click(function(){
                callUrl("<?php echo parent::link(); ?>");
            });
            </script>
        </div>
        <?php
    }
    
    function printReplyView () {
        
        $message = ForumPageModel::getPm(parent::get("id"));
        
        $subject = $message->subject;
        if (parent::post("subject")) {
            $subject = parent::post("subject");
        } else if (strpos($subject, "RE: ") !== 0) {
            $subject = "RE: ".$subject;
        }
        
        ?>
        <div class="panel replyUserMessagePanel">
            <h1><?php echo parent::getTranslation("userMessage.reply.title"); ?></h1>
            <p><?php echo parent::getTranslation("userMessage.reply.description"); ?></p>
            <form method="post" action="<?php echo parent::link(array("action"=>"doReply","dstUserId"=>$message->srcuser)); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("userMessage.reply.toUser"); ?>
                </td><td>
                    <input type="textbox" name="dstuser" value="<?php echo htmlentities($message->srcusername); ?>" disabled="true" />
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("userMessage.reply.subject"); ?>
                </td><td>
                    <input type="textbox" name="subject" value="<?php echo htmlentities($subject, ENT_QUOTES); ?>" />
                    <?php
                    $message = parent::getMessage("subject");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("userMessage.reply.message"); ?>
                </td><td>
                    <textarea name="message" cols="4" rows="4"><?php echo htmlentities(parent::post("message")); ?></textarea>
                    <?php
                    $message = parent::getMessage("message");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("userMessage.reply.send"); ?></button> 
                </div>
            </form>
        </div>
        <?php
    }
    
}

?>