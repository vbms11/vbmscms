<?php

require_once 'core/plugin.php';

class StartupView extends XModule {
    
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
        <div class="panel">
            <div>
                <h3>Please login and Configure your website.</h3>
            </div>
        </div>
        <?php
    }
    
}

?>