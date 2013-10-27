<?php

require_once 'core/plugin.php';
require_once 'modules/events/eventsList.php';

class FullCallendarView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "date":
                if (Context::hasRole("events.callender")) {
                    if (isset($_GET["date"])) {
                        $_SESSION["events.date"] = $_GET["date"];
                    }
                }
                break;
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
            case "events":
                // renders all events in json format
                if (Context::hasRole("events.callender")) {
                    $events = EventsModel::getAllEvents();
                    $jsonEvents = array();
                    foreach ($events as $event) {
                        $jsonEvents[] = array(
                            'id' => htmlentities($event->id),
                            'title' => $event->name,
                            'start' => htmlentities($event->date),
                            'allDay' => 'true',
                            'url' => parent::link(array("action"=>"view","id"=>$event->id))
                        );
                    }
                    Context::setReturnValue(json_encode($jsonEvents));
                }
                break;
            case "deleteEvent":
                EventsModel::deleteEvent($_GET['id']);
                break;
            case "view":
            case "editEvent":
                parent::focus();
                break;
        }
        
    }
    
    function onView () {
        switch (parent::getAction()) {
            case "view":
                $this->renderViewEventView();
                break;
            case "editEvent":
                $this->renderEditEventView();
                break;
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
        return array("css/fullcalendar.css","css/events.css","css/fullcalendar.print.css");
    }
    
    
    function getScripts () {
        return array("js/fullcalendar.min.js","js/gcal.js");
    }
    
    function renderCallender () {
        $events = EventsModel::getAllEvents();
        ?>
        <div class="panel">
            <div id="calendar"></div>
            <script type="text/javascript">
            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    theme: true,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    editable: false,
                    events: "<?php echo parent::ajaxLink(array("action"=>"events")); ?>",
                    eventDrop: function(event, delta) {
                        alert(event.title + 'was moved '+delta+' days\n'+'(should probably update your database)');
                    },
                    eventClick: function(event) {
                        if (event.url) {
                            callUrl(event.url);
                            return false;
                        }
                    }
                });
            });
            </script>
            <?php
            if (Context::hasRole("events.edit")) {
                ?>
                <hr/>
                <div class="alignRight">
                    <button type="button" id="btnNewEvent">New Event</button>
                </div>
                <script>
                $("#btnNewEvent").button().click(function () {
                    callUrl("<?php echo parent::link(array("action"=>"editEvent")); ?>");
                });
                </script>
                <?php
            }
            ?>
        </div>
        <?php
    }
    
    function renderEditEventView () {
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
                $description = $event == null ? "" : $event->description;
                InputFeilds::printHtmlEditor("description", $description)
                ?>
                <br/>
                <hr/>
                <div class="alignRight">
                    <input type="submit" value="Save" />
                    <input type="button" value="Cancel" onclick="callUrl('<?php echo parent::link(array("action"=>"cancel")); ?>');" />
                </div>
            </form>
        </div>
        <script>
        $("#date").datepicker();
        $("#date").datepicker({changeMonth: true, changeYear: true});
        $("#date").datepicker("option", "showAnim", "blind");
        $("#date").datepicker("option", "dateFormat", "yy-mm-dd");
        $("#date").datepicker("setDate", "<?php echo Common::htmlEscape(($event == null ? "" : $event->date)); ?>");
        $(".alignRight input").button();
        </script>
        <?php
    }
    
    
    function renderViewEventView () {
        $event = EventsModel::getEvent($_GET['id']);
        ?>
        <div class="panel">
            <?php
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
                                <a href="<?php echo parent::link(array("action"=>"editEvent","id"=>$event->id)); ?>">
                                    <img class="imageLink" src="resource/img/edit.png" alt="">
                                </a>
                                <a href="<?php echo parent::link(array("action"=>"deleteEvent","id"=>$event->id)); ?>">
                                    <img class="imageLink" src="resource/img/delete.png" alt="">
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="eventDescription">
                        <?php echo $event->description; ?> 
                    </div>
                </div>
                <?php
            }
            if (Context::hasRole("events.edit")) {
                ?>
                <hr/>
                <div class="alignRight">
                    <button type="button" onclick="callUrl('<?php echo parent::link(array("action"=>"editEvent","id"=>$_GET['id'])); ?>');">Edit Event</button>
                    <button type="button" onclick="callUrl('<?php echo parent::link(); ?>');">Back to Callendar</button>
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