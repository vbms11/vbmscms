<?php

require_once 'core/plugin.php';

class StatisticsModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            default:
                break;
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
        <div class="panel adminStatisticsPanel">
            <div class="adminStatisticsTabs">
                <ul>
                    <li><a href="#statisticsTab"><?php echo parent::getTranslation("admin.statistics.tab.label"); ?></a></li>
                </ul>
                <div id="statisticsTab">
                    
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".adminStatisticsTabs").tabs();
        </script>
        <?php
    }
    
}

?>