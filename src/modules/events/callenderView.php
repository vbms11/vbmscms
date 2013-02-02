<?php

require_once 'core/plugin.php';

class CallenderView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "date":
                if (Context::hasRole("events.callender")) {
                    if (isset($_GET["date"])) {
                        $_SESSION["events.date"] = $_GET["date"];
                    }
                }
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            default:
                if (Context::hasRole("events.callender")) {
                    $this->renderCallender();
                }
        }
    }
    
    function getRoles () {
        return array("events.callender");
    }
    
    function getStyles () {
        return array("css/events.css");
    }
    
    function renderCallender () {
        ?>
        <div class="panel">
            <div id="callender">
            </div>
            <script type="text/javascript">
            var cal_started = 0;
            $("#callender").datepicker({
                onSelect: function(dateText, inst) {
                    if (cal_started > 1) {
                        callUrl("<?php echo parent::link(array("action"=>"date"),false); ?>",{"date":dateText});
                    }
                    cal_started++;
                }
            });
            $("#callender").datepicker("option", "dateFormat", "yy-mm-dd");
            cal_started++;
            </script>
        </div>
        <?php
    }
    
}

?>