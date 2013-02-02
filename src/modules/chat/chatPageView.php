<?php

require_once("core/plugin.php");
require_once("core/model/chatModel.php");

class ChatPageView extends XModule {

    public $action;
    public $message;
    public $room;
    public $version;
    
    
    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        $this->getRequestVars();

        switch ($this->action) {

            case "post":
                ChatPageModel::postMessage($this->room, $this->message, Context::getUserId());
                NavigationModel::redirectAjaxModule($moduleId,array("action"=>"poll","version"=>$this->version));
                break;
            case "poll":
                break;
        }

    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        $this->getRequestVars();

        switch ($this->action) {
            
            case "post":
                break;
            case "poll":
                $this->printPollView($moduleId);
                break;
            default:
                $this->printMainView($moduleId);
        }
 
 
    }

    /**
     * returns style sheets used by this module
     */
    function getStyles () {
        return array("css/chat.css");
    }

    /**
     * returns scripts used by this module
     */
    function getScripts () {
        return array("js/chat.js");
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("chat.user","chat.view");
    }

    function getRequestVars () {
        if (isset($_GET['action'])) $this->action = $_GET['action'];
        if (isset($_GET['message'])) $this->message = $_GET['message'];
        if (isset($_GET['room'])) $this->room = $_GET['room'];
        if (isset($_GET['version'])) $this->version = $_GET['version'];
    }

    function printMainView ($moduleId) {
        
        ?>
        <div class="panel chatPage">
            <div id="chatMessages" class="chatMessages">
                
            </div>
            <div class="chatInputDiv">
                <textarea id="chatInput" class="expand" rows="3" cols="3" onkeydown="return chatHandelKey(event,'<?php echo NavigationModel::createModuleAjaxLink($moduleId,array("action"=>"post"),false); ?>');"></textarea>
            </div>
            <script type="text/javascript">
                chatStartPoll("<?php echo NavigationModel::createModuleAjaxLink($moduleId,array("action"=>"poll"),false); ?>");
            </script>
        </div>
        <?php
         
    }

    function printPollView ($moduleId) {

        $messages = ChatPageModel::getMessages($this->room,$this->version);
        $maxVersion = 0;

        foreach ($messages as $message) {
            $maxVersion = $message->version;
            ?>
            <div>
                <div class="chatUser">
                    <?php echo htmlspecialchars($message->username,ENT_QUOTES); ?> says:
                </div>
                <div class="chatMessage">
                    <?php echo htmlspecialchars($message->message,ENT_QUOTES); ?>
                </div>
            </div>
            <?php
        }

        ?>
        <version><?php echo $maxVersion ?></version>
        <?php

    }

    function printEditView ($pageId) {
        ?>
        <?php
    }
}

?>