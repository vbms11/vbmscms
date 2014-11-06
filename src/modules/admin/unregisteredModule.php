<?php

require_once 'core/plugin.php';

class UnregisteredModule extends XModule {
    
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
    
    static function getTranslations() {
        return array("en"=>array(
            "unregisted.title"  => "Domain Unregistered",
            "unregisted.text"   => "This domain is not registered."
        ));
    }
    
    function renderMainView() {
        
        ?>
        <div class="panel">
            <div>
                <h3><?php echo parent::getTranslation("unregisted.title"); ?></h3>
                <p>
                    <?php echo parent::getTranslation("unregisted.text"); ?>
                </p>
            </div>
        </div>
        <?php
    }
    
}

?>