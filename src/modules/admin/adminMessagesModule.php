<?php

require_once 'core/plugin.php';

class AdminMessagesModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            
            default:
                $this->renderMainView();
        }
    }
    
    function renderMainView() {
        ?>
        <div class="panel adminMessagesPanel">
            <div class="adminMessagesTabs">
                <ul>
                    <li><a href="#newMessages">New Messages</a></li>
                    <li><a href="#pastMessages">Past Messages</a></li>
                </ul>
                <div id="newMessages">
                    
                </div>
                <div id="pastMessages">
                    
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(function() {
            $(".adminMessagesTabs").tabs();
        });
        </script>
        <?php
    }
    
}

?>