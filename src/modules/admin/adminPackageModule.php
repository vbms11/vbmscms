<?php

require_once 'core/plugin.php';

class AdminPackageModule extends XModule {
    
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
        <div class="panel packagePanel">
            <div class="packageTabs">
                <ul>
                    <li href="#packageBill"><?php echo parent::getTranslation("admin.package.tab.bill"); ?><a></a></li>
                    <li href="#packageAccount"><?php echo parent::getTranslation("admin.package.tab.accountDetails"); ?><a></a></li>
                </ul>
                <div id="packageBill">
                    
                </div>
                <div id="packageAccount">
                    
                </div>
            </div>
        </div>
        <script type="text/javascript">
        
        </script>
        <?php
    }
    
}

?>