<?php

require_once 'core/plugin.php';

class SystemService extends XModule {
    
    function onProcess () {
        
        echo "<vcms>";
        
        switch (parent::getAction()) {
            
            case "usersOnline":
                
                // print list of users online
                echo "<usersOnline>";
                $usersOnline = SessionModel::getUsersOnline();
                foreach ($usersOnline as $userOnline) {
                    echo "
                    <user>
                        <id>".Common::htmlEscape($userOnline->publicid)."<id>
                        <name>".Common::htmlEscape($userOnline->name)."</user>
                        <image>".Common::htmlEscape($userOnline->image)."</image>
                    </user>";
                }
                echo "</usersOnline>";
                break;
                
            case "chatMessages":
                
                echo "<chatMessages>";
                // print list of rooms and new messages
                $roomsMessages = ChatModel::getUserMessages(Session::getSessionKey(),$_GET['version']);
                
                foreach ($roomsMessages as $room => $messages) {
                    echo "<room id='".Common::htmlEscape($room)."'>";
                    foreach ($messages as $message) {
                        echo "<message version='".Common::htmlEscape($message->version)."'>";
                        echo Common::htmlEscape($message->message,false);
                        echo "</message>";
                    }
                    echo "</room>";
                }
                echo "</chatMessages>";
                break;
            
            case "notifications":
                
                break;
            case "tasks":
                break;
            case "track":
                $clientIp = Database::escape($_SERVER['REMOTE_ADDR']);
                $href = Database::escape($_GET['href']);
                $obj = Database::queryAsObject("select 1 as exists from t_track where clientip = '$clientIp' and href = '$href'");
                if ($obj == null || $obj->exists != "1") {
                    Database::query("insert into t_track (clientip,href) values('$clientIp','$href')");
                }
                break;
            case "installProgress":
				echo isset($_SESSION['installProgress']) ? $_SESSION['installProgress'] : "";
                break;
            default:
                break;
        }
        
        echo "</vcms>";
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            
            default:
                $this->renderMainView();
        }
    }
    
    function renderMainView () {
        
    }
    
}

?>