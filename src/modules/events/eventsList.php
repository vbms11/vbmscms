<?php

require_once 'core/plugin.php';
require_once 'core/model/eventsModel.php';

class EventsListView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("events.edit")) {
                    if (Common::isEmpty($_GET['id'])) {
                        EventsModel::createEvent($_POST['name'], $_POST['type'], 
                                Context::getUserId(), $_POST['date'], $_POST['description']);
                    } else {
                        EventsModel::saveEvent($_GET['id'], $_POST['name'], 
                                $_POST['type'], $_POST['date'], $_POST['description']);
                    }
                }
                parent::blur();
                parent::redirect();
                break;
            case "update":
                parent::param("eventType",$_POST["eventType"]);
                parent::param("showType",$_POST["showType"]);
                parent::param("pastEvents",$_POST["pastEvents"]);
                parent::param("futureEvents",$_POST["futureEvents"]);
                parent::param("preview",$_POST["preview"]);
                parent::blur();
                break;
            case "editEvent":
                parent::focus();
                break;
            case "edit":
                parent::focus();
                break;
            case "view":
                parent::focus();
                break;
            case "deleteEvent":
                EventsModel::deleteEvent($_GET['id']);
                break;
            case "cancel":
                parent::blur();
                parent::redirect();
                break;
        }
    }
    
    function onView() {
        
        switch (parent::getAction()) {
            case "editEvent":
                $this->renderEditEvent();
                break;
            case "edit":
                $this->renderEditView();
                break;
            case "view":
                $this->renderShowView();
                break;
            default:
                $this->renderEventsList();
                break;
        }
    }
    
    function getRoles () {
        return array("events.list","events.edit");
    }
    
    function getStyles () {
        return array("css/events.css");
    }
    
    function renderEditEvent () {
        
        $event = null;
        if (isset($_GET['id'])) {
            $event = EventsModel::getEvent($_GET['id']);
        }
        
        ?>
        <div class="panel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save","id"=>(isset($_GET['id']) ? $_GET['id'] : ""))); ?>">
                <?php
                InfoMessages::printInfoMessage("Here you can edit the events details.");
                ?>
                <br/><b>Name of the Event:</b><br/>
                <input type="textbox" name="name" class="expand" value="<?php echo Common::htmlEscape(($event == null ? "" : $event->name)); ?>"/>
                <br/><br/>
                <b>Date of the Event:</b><br/>
                <input type="textbox" id="date" name="date" class="expand" value="<?php echo Common::htmlEscape(($event == null ? "" : $event->date)); ?>"/>
                <br/><br/>
                <b>Type of Event:</b><br/>
                <?php
                InputFeilds::printSelect("type", null, EventsModel::getEventTypes());
                ?>
                <br/><br/>
                <b>Description of the Event:</b><br/>
                <?php
                InputFeilds::printHtmlEditor("description", ($event == null ? "" : $event->description))
                ?>
                <br/><br/>
                <hr/>
                <div class="alignRight">
                    <input type="submit" value="Save" />
                    <input type="button" value="Cancel" onclick="callUrl('<?php echo parent::link(array("action"=>"cancel")); ?>');" />
                </div>
            </form>
        </div>
        <script>
        $("#date").datepicker();
        $("#date").datepicker("option", "showAnim", "blind");
        $("#date").datepicker("option", "dateFormat", "yy-mm-dd");
        $("#date").datepicker("setDate", "<?php echo Common::htmlEscape(($event == null ? "" : $event->date)); ?>");
        $(".alignRight input").button();
        </script>
        <?php
    }
    
    function renderEditView () {
        ?>
        <div class="panel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <table class="nowrap"><tr><td>
                    <b>Type of events to show:</b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printSelect("eventType", parent::param("eventType"), EventsModel::getEventTypes());
                    ?>
                </td></tr><tr><td>
                    <b>Show past or future events:</b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printSelect("showType", parent::param("showType"), array("1"=>"Future Events","2"=>"Past Events","3"=>"All Events"));
                    ?>
                </td></tr><tr><td>
                    <b>Number of past events:</b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printTextFeild("pastEvents", parent::param("pastEvents"), "expand");
                    ?>
                </td></tr><tr><td>
                    <b>Number of future events:</b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printTextFeild("futureEvents", parent::param("futureEvents"), "expand");
                    ?>
                </td></tr><tr><td>
                    <b>Preview characters length:</b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printTextFeild("preview", parent::param("preview"));
                    ?>
                </td></tr></table>
                <br/>
                <hr/>
                <div class="alignRight">
                    <input type="submit" value="Save" />
                    <input type="button" onclick="history.back();" value="Cancel" />
                </div>
                <script>
                $(".alignRight input").button();
                </script>
            </form>
        </div>
        <?php
    }
    
    function renderEventsList () {
        
        $selectedDate = date("Y-m-d");
        if (isset($_SESSION["events.date"]))
            $selectedDate = $_SESSION["events.date"];
        
        $pastEvents = parent::param("pastEvents");
        $futureEvents = parent::param("futureEvents");
        switch (parent::param("showType")) {
            case 1:
                $pastEvents = 0;
                break;
            case 2:
                $futureEvents = 0;
                break;
            case 3:
                break;
        }
        
        $events = EventsModel::getEvents($selectedDate, $futureEvents, $pastEvents, parent::param("eventType"));
        ?>
        <div class="panel">
            <?php
            if (Context::hasRole("events.edit")) {
                ?>
                <div class="alignRight">
                    <button type="button" onclick="callUrl('<?php echo parent::link(array("action"=>"editEvent")); ?>');">New Event</button>
                </div>
                <?php
            }
            if (count($events) > 0) {
                foreach ($events as $event) {
                    ?>
                    <div class="eventDiv">
                        <div class="eventName">
                            <?php 
                            echo Common::htmlEscape($event->name);
                            echo " <span> ".Common::htmlEscape($event->date)."</span>";
                            if (Context::hasRole("events.edit")) {
                                ?>
                                <div style="float:right;">
                                    <a href="<?php echo parent::link(array("action"=>"deleteEvent","id"=>$event->id)); ?>">
                                        <img class="imageLink" src="resource/img/delete.png" alt="">
                                    </a>
                                    <a href="<?php echo parent::link(array("action"=>"editEvent","id"=>$event->id)); ?>">
                                        <img class="imageLink" src="resource/img/edit.png" alt="">
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="eventDescription">
                            <?php 
                            if (parent::param("preview") > 0) {
                                echo strip_tags(nl2br(substr($event->description, 0, parent::param("preview"))));
                                ?> 
                                 ... 
                                <a href="<?php echo parent::link(array("action"=>"view","id"=>$event->id)); ?>"> more</a>
                                <?php
                            } else {
                                echo nl2br($event->description);
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                if (Context::hasRole("events.edit")) {
                    ?>
                    <div class="alignRight">
                        <button type="button" onclick="callUrl('<?php echo parent::link(array("action"=>"editEvent")); ?>');">New Event</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <script>
        $(".alignRight button").button();
        </script>
        <?php
    }
    
    function renderShowView () {
        $event = EventsModel::getEvent($_GET['id']);
        ?>
        <div class="panel">
            <?php
            if (Context::hasRole("events.edit")) {
                ?>
                <div class="alignRight">
                    <button type="button" onclick="callUrl('<?php echo parent::link(array("action"=>"editEvent","id"=>$_GET['id'])); ?>');">Edit Event</button>
                </div>
                <?php
            }
            if (Context::hasRole("events.list")) {
                ?>
                <div class="eventDiv">
                    <div class="eventName">
                        <?php 
                        echo Common::htmlEscape($event->name);
                        echo " <span> ".Common::htmlEscape($event->date)."</span>";
                        if (Context::hasRole("events.edit")) {
                            ?>
                            <div style="float:right;">
                                <a href="<?php echo parent::link(array("action"=>"deleteEvent","id"=>$event->id)); ?>">
                                    <img class="imageLink" src="resource/img/delete.png" alt="">
                                </a>
                                <a href="<?php echo parent::link(array("action"=>"editEvent","id"=>$event->id)); ?>">
                                    <img class="imageLink" src="resource/img/edit.png" alt="">
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="eventDescription">
                        <?php echo nl2br($event->description); ?> 
                    </div>
                </div>
                <?php
            }
            if (Context::hasRole("events.edit")) {
                ?>
                <div class="alignRight">
                    <button type="button" onclick="callUrl('<?php echo parent::link(array("action"=>"editEvent","id"=>$_GET['id'])); ?>');">Edit Event</button>
                </div>
                <?php
            }
            ?>
        </div>
        <script>
        $(".alignRight button").button();
        </script>
        <?php
    }
    
}

?>