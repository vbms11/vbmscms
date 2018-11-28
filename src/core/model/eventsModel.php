<?php

class EventsModel {
    
    static public $birthday = 1;
    static public $meeting = 2;
    static public $event = 3;
    static public $matches = 4;
    static public $news = 5;
    
    static function getEventTypes () {
        return array(EventsModel::$event=>"Event",EventsModel::$birthday=>"Birthday",EventsModel::$meeting=>"Meeting",EventsModel::$matches=>"Matches",EventsModel::$news=>"News");
    }
    
    static function createEvent ($name, $type, $userId, $date, $description,$houres=null,$minutes=null) {
        $name = Database::escape($name);
        $date = Database::escape($date);
        $type = Database::escape($type);
        $userId = Database::escape($userId);
        $description = Database::escape($description);
        $houres = $houres == null ? "" : Database::escape($houres);
        $minutes = $minutes == null ? "" : Database::escape($minutes);
        Database::query("insert into t_event (name,type,userid,date,description,houres,minutes) 
                values('$name','$type','$userId','$date','$description','$houres','$minutes')");
    }
    
    static function saveEvent ($id, $name, $type, $date, $description,$houres=null,$minutes=null) {
        $id = Database::escape($id);
        $name = Database::escape($name);
        $date = Database::escape($date);
        $type = Database::escape($type);
        $description = Database::escape($description);
        $houres = $houres == null ? "" : Database::escape($houres);
        $minutes = $minutes == null ? "" : Database::escape($minutes);
        Database::query("update t_event set name = '$name', type = '$type', date = '$date', description = '$description', houres = '$houres', minutes = '$minutes' where id = '$id'");
    }
    
    static function getEvent ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_event where id = '$id'");
    }
    
    static function deleteEvent ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_event where id = '$id'");
    }
    
    static function getEvents ($fromDate,$cntFuture,$cntPast,$eventType=null) {
        $events = array();
        $fromDate = Database::escape($fromDate);
        $type = "";
        if (!Common::isEmpty($eventType)) {
            $eventType = Database::escape($eventType);
            $type = "and type = '$eventType'";
        }
        $resultPast = Database::queryAsArray("select * from t_event where date < '$fromDate' $type order by date desc");
        $resultFuture = Database::queryAsArray("select * from t_event where date >= '$fromDate' $type order by date asc");
        
        // put future events into the result
        $cntFutureEvnt = count($resultFuture);
        if ($cntFutureEvnt < $cntFuture) {
            $cntFuture = $cntFutureEvnt;
        }
        for ($i=0; $i<$cntFuture; $i++) {
            $events[] = $resultFuture[$i];
        }
        // put past events into the result
        $cntPastEvnt = count($resultPast);
        if ($cntPastEvnt < $cntPast) {
            $cntPast = $cntPastEvnt;
        }
        // for ($i=$cntPast-1; $i>=0; $i--) {
        for ($i=0; $i<$cntPast; $i++) {
            $events[] = $resultPast[$i];
        }
        
        return $events;
    }
    
    static function getAllEvents () {
        return Database::queryAsArray("select * from t_event order by date desc");
    }
    
    static function getEventsInRange ($fromDate,$toDate=null) {
        $fromDate = Database::escape($fromDate);
        if ($toDate != null) {
            $toDate = Database::escape($toDate);
            $result = Database::queryAsArray("select * from t_event where date >= '$fromDate' and date <= '$toDate'");
        } else {
            $result = Database::queryAsArray("select * from t_event where date >= '$fromDate' and date <= DATE_ADD('$fromDate',INTERVAL 10 DAY)");
        }
        return $result;
    }
    
    static function getEventsInMonth ($year,$month,$user=null) {
        $year = Database::escape($year);
        $month = Database::escape($month);
        $userCondition = "";
        if ($user != null) {
            $user = Database::escape($user);
            $userCondition = " and userid = '$user' "; 
        }
        return Database::queryAsArray("select * from t_event where year(date) = '$year' and month(date) = '$month' $userCondition");
    }
    
    static function deleteUserEvent ($userId,$type=null) {
        $userId = Database::escape($userId);
        $typeSelect = "";
        if (!Common::isEmpty($type)) {
            $type = Database::escape($type);
            $typeSelect = "and type = '$type'";
        }
        Database::query("delete from t_event where userid = '$userId' $typeSelect");
    }
    
    static function addUserEvents ($userId) {
        $userId = Database::escape($userId);
        // remove old events
        EventsModel::deleteUserEvent($userId, EventsModel::$birthday);
        // add new events
        $user = UsersModel::getUser($userId);
        if ($user != null) {
            EventsModel::createEvent("birthday!", 1, $user->id, $user->birthday, "Happy Birthday ".$user->firstname." ".$user->lastname);
        }
    }
}

?>