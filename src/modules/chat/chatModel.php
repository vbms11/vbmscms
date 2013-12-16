<?php

class ChatModel {
    
    static function getRoomMessages ($room,$version) {
        $room = mysql_real_escape_string($room);
        $version = mysql_real_escape_string($version);
        return Database::queryAsArray("select cm.*, u.username as username from t_chatmessage cm join t_users u on cm.user = u.id where room = '$room' and version > '$version' order by version asc");
    }
    
    static function getUserMessages ($sessionId,$version) {
        $sessionId = mysql_real_escape_string($sessionId);
        $version = mysql_real_escape_string($version);
        return Database::queryAsArray("select * from t_chatmessage where room = '$room' and version > '$version' and user = '$user'");
    }

    static function getRooms () {
        return Database::queryAsArray("select * from t_chat_room");
    }
    
    static function getRoomUsers ($room) {
        $room = mysql_real_escape_string($room);
        return Database::queryAsArray("select * from t_chat_room r join t_char_room_session s on s.room = '$room'");
    }

    static function postMessage ($room,$message,$user) {
        $room = mysql_real_escape_string($room);
        $user = mysql_real_escape_string($user);
        $message = mysql_real_escape_string($message);
        $version = ChatPageModel::getNextVersion();
        Database::query("insert into t_chatmessage (room,message,user,version) values ('$room','$message','$user','$version')");
    }

    static function getNextVersion () {
        $result = Database::query("select max(version) as max from t_chatmessage");
        return mysql_fetch_object($result)->max + 1;
    }

}

?>