<?php

//TODO reomve this it was just to log some data

class LogDataModel {
    
    static function logThis ($data) {
        $dataParts = explode(",",$data);
        foreach ($dataParts as $datapart) {
            $datapart = mysql_real_escape_string($datapart);
            Database::query("insert into t_logdata (logdata) values ('$datapart')");
        }
    }
}

?>