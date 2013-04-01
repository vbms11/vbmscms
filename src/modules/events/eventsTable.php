<?php

require_once 'core/plugin.php';
require_once 'core/model/eventsModel.php';

class EventsTableView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("events.edit")) {
                    if (Common::isEmpty($_GET['id'])) {
                        EventsModel::createEvent($_POST['name'], $_POST['type'], Context::getUserId(), 
                                $_POST['date'], $_POST['description'], $_POST['houres'], $_POST['minutes']);
                    } else {
                        EventsModel::saveEvent($_GET['id'], $_POST['name'], $_POST['type'], 
                                $_POST['date'], $_POST['description'], $_POST['houres'], $_POST['minutes']);
                    }
                }
                parent::blur();
                parent::redirect();
                break;
            case "update":
                parent::param("showType",$_POST["showType"]);
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
            case "viewEvent":
                $this->renderShowView();
                break;
            default:
                $this->renderEventsList();
                break;
        }
    }
    
    function getRoles () {
        return array("events.list","events.edit","events.users.all");
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
                <br/>
                <table><tr><td>
                    <b>Start Time of the Event:</b>
                </td><td>
                    Houres: 
                </td><td>
                    <?php InputFeilds::printSelect("startHoure", $event == null ? null : $event->starthoures, Common::getSequence(0,24,1));  ?>
                </td><td>
                    Minutes:
                </td><td>
                    <?php InputFeilds::printSelect("startMinute", $event == null ? null : $event->startminutes, Common::getSequence(0,60,5));  ?>
                </td></tr></table>
                <br/>
                <table><tr><td>
                    <b>Duration of the Event:</b>
                </td><td>
                    Houres: 
                </td><td>
                    <?php InputFeilds::printSelect("houres", $event == null ? null : $event->houres, Common::getSequence(0,24,1));  ?>
                </td><td>
                    Minutes:
                </td><td>
                    <?php InputFeilds::printSelect("minutes", $event == null ? null : $event->minutes, Common::getSequence(0,60,5));  ?>
                </td></tr></table>
                <br/>
                <b>Type of Event:</b><br/>
                <?php
                InputFeilds::printSelect("type", null, EventsModel::getEventTypes());
                ?>
                <br/><br/>
                <b>Description of the Event:</b><br/>
                <?php
                $description = Common::htmlEscape(($event == null ? "" : $event->description));
                InputFeilds::printHtmlEditor("description", $description)
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
        $("#date").datepicker({changeMonth: true, changeYear: true});
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
                    <b>Show Type:</b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printSelect("showType", parent::param("showType"), array("1"=>"All Users","2"=>"Current User"));
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
        
        // get selected date
        $selectedDate = date("Y-m-d",time());
        if (isset($_SESSION["events.date"])) {
            // $selectedDate = $_SESSION["events.date"];
        }
        $year = date('Y',time());
        if (isset($_GET['Y'])) {
            $year = $_GET['Y'];
        }
        $month = date('m',time());
        if (isset($_GET['selectedMonth'])) {
            $month = $_GET['selectedMonth'];
        }
        
        // get selected user
        $selectedUser = Context::getUserId();
        if (isset($_GET['selectedUser'])) {
            $selectedUser = $_GET['selectedUser'];
        }
        
        // event types
        $eventTypes = EventsModel::getEventTypes();
        
        // get events to show
        $events = array();
        switch (parent::param("showType")) {
            case 1:
                $events = EventsModel::getEventsInMonth($year,$month);
                break;
            case 2:
                $events = EventsModel::getEventsInMonth($year,$month,$selectedUser);
                break;
        }
        
        ?>
        <div class="panel">
            
            <table><tr><td class="contract alignRight">
                Month: 
            </td><td class="contract">
                <?php
                InputFeilds::printSelect("month", isset($_GET['selectedMonth']) ? $_GET['selectedMonth'] : $month, Common::getMonthNames());
                ?>
            </td>
            <?php
            if (parent::param("showType") == 2 && Context::hasRole("events.users.all")) {
                $users = Common::toMap(UsersModel::getUsers(true,true),"id","username");
                ?>
                <td class="contract alignRight">
                User: 
                </td><td class="contract">
                    <?php
                    InputFeilds::printSelect("selectedUser", $selectedUser, $users);
                    ?>
                </td>
                <?php
            }
            ?>
            <td class="contract">
                <?php
                if (Context::hasRole("events.edit")) {
                    ?>
                    <button type="button" style="white-space:nowrap;" onclick="callUrl('<?php echo parent::link(array("action"=>"editEvent")); ?>');">New Event</button>
                    <?php
                }
                ?>
            </td></tr></table>
            <hr/>
            <?php
            if (count($events) > 0) {
                ?>
                <table width="100%"><tr style="font-weight: bold;">
                    <td>Name</td>
                    <td>Date</td>
                    <td>Type</td>
                    <td>Duration</td>
                    <td>Tools</td>
                </tr>
                <?php
                $totalHoures = 0;
                $totalMinutes = 0;
                foreach ($events as $event) {
                    $totalHoures += $event->houres;
                    $totalMinutes += $event->minutes
                    ?>
                    <tr>
                        <td><?php echo Common::htmlEscape($event->name); ?></td>
                        <td><?php echo Common::htmlEscape($event->date); ?></td>
                        <td><?php echo $eventTypes[Common::htmlEscape($event->type)]; ?></td>
                        <td><?php echo Common::htmlEscape($event->houres.":".$event->minutes); ?></td>
                        <td class="contract nowrap">
                            <a href="<?php echo parent::link(array("action"=>"viewEvent","id"=>$event->id)); ?>">
                                <img class="imageLink" src="resource/img/view.png" alt="">
                            </a>
                            <a href="<?php echo parent::link(array("action"=>"editEvent","id"=>$event->id)); ?>">
                                <img class="imageLink" src="resource/img/edit.png" alt="">
                            </a>
                            <a href="<?php echo parent::link(array("action"=>"deleteEvent","id"=>$event->id)); ?>">
                                <img class="imageLink" src="resource/img/delete.png" alt="">
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                $totalHoures += floor($totalMinutes / 60);
                $totalMinutes = $totalMinutes % 60;
                ?>
                <tr style="background-color:rgb(220,220,220);">
                    <td colspan="3">Total:</td>
                    <td colspan="2"><?php echo Common::htmlEscape($totalHoures.":".$totalMinutes); ?></td>
                </tr>
                </table>
                <?php
                if (Context::hasRole("events.edit")) {
                    ?>
                    <hr/>
                    <div class="alignRight">
                        <button type="button" onclick="callUrl('<?php echo parent::link(array("action"=>"editEvent")); ?>');">New Event</button>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <script>
        $("button").button();
        $("#month").change(function () {
            callUrl("<?php echo parent::link(); ?>",{'selectedMonth':$('#month').val()});
        });
        $("#selectedUser").change(function () {
            callUrl("<?php echo parent::link(); ?>",{'selectedMonth':$('#month').val(),"selectedUser":$('#selectedUser').val()});
        });
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
                        <?php echo nl2br(Common::htmlEscape($event->description)); ?> 
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