<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('core/plugin.php');
require_once('modules/forum/forumPageModel.php');

class UserMessageModule extends XModule {

    function onProcess () {
        
        switch ($this->getAction()) {
            case "deleteMessage":
                ForumPageModel::deletePm(parent::get("id"));
                setFocusedArea(null);
                NavigationModel::redirectPage(Context::getPageId());
                break;
            case "send":
                $userNameEnd = stripos($_POST['dstuser'], "-");
                if ($userNameEnd == -1) {
                    $userName = $_POST['dstuser'];
                } else {
                    $userName = trim(substr($_POST['dstuser'], 0, $userNameEnd-1));
                }
                $user = UsersModel::getUserByUserName($userName);
                ForumPageModel::savePm(Context::getUserId(), $user->id, $_POST['subject'], $_POST['message']);
                setFocusedArea(null);
                NavigationModel::redirectPage(Context::getPageId());
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        if (Context::hasRole(array("message.inbox"))) {
            switch ($this->getAction()) {
                case "new":
                    $this->printCreateMessageView();
                    break;
                default:
                    $this->printMainView();
            }
        }
    }
    
    function getRoles () {
        return array("message.inbox");
    }
    
    function getStyles () {
        return array("css/message.css");
    }

    function printMainView () {
        
        $messages = ForumPageModel::getPms(Context::getUserId());
        ?>
        <div class="panel userMessagePanel">
            <h1><?php echo parent::getTranslation("userMessage.title"); ?></h1>
            <p><?php echo parent::getTranslation("userMessage.description"); ?></p>
            <table class="resultTable">
                <thead><tr><td>
                    <?php echo parent::getTranslation("userMessage.table.user"); ?>
                </td><td>
                    <?php echo parent::getTranslation("userMessage.table.title"); ?>
                </td><td>
                    <?php echo parent::getTranslation("userMessage.table.date"); ?>
                </td><td class="contract">
                    <?php echo parent::getTranslation("userMessage.table.tools"); ?>
                </td></tr></thead>
                <tbody>
                    <?php
                    foreach ($messages as $message) {
                        ?>
                        <tr><td>
                            <?php echo htmlentities($message->srcusername); ?>
                        </td><td>
                            <?php echo htmlentities($message->subject); ?>
                        </td><td>
                            <?php echo htmlentities($message->senddate); ?>
                        </td><td class="contract">
                            <a onclick="return confirm('<?php echo parent::getTranslation("userMessage.table.delete"); ?>')" href="<?php echo parent::link(array("action"=>"deleteMessage","id"=>$message->id)); ?>"><img src="resource/img/delete.png" alt=""/></a>
                        </td></tr>
                        <?php
                    }
                    ?>
            </tbody></table>
        </div>
        <?php
    }
    
    function printCreateMessageView ($userId) {
        $user = UsersModel::getUser($userId);
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
                    <input type="textbox" name="subject" value="" />
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("userMessage.create.message"); ?>
                </td><td>
                    <textarea name="message" cols="4" rows="4"></textarea>
                </td></tr>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("userMessage.create.send"); ?></button> 
                </div>
            </form>
        </div>
        <?php
    }
    
}

?>