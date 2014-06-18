<?php

require_once("core/plugin.php");

class ChatModule extends XModule {

    
    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            
            default:
        }

    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            
            case "edit":
                if (Context::hasRole("chat.edit")) {
                    $this->printEditView();
                    break;
                }
            default:
                if (Context::hasRole("chat.view")) {
                    $this->printMainView();
                }
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
        
        return array("chat.edit","chat.view");
    }
    
    function printEditView () {
        
        ?>
        <div class="panel chatEditPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <hr/>
                <button type="sumit"><?php echo parent::getTranslation("common.save"); ?></button>
            </form>
        </div>
        <?php
    }

    function printMainView () {
        
        $user = Context::getUser();
        
        if ($user != null) {
            ?>
            <div class="panel chatPanel">
                <iframe id="chatIframe" src="modules/chat/chat/index.php?authkey=<?php echo $user->authkey; ?>"></iframe>
            </div>
            <?php
        }
    }
    
}

?>