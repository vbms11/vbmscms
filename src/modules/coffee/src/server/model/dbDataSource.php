<?php

/*

*/

abstract class DbDataSource {
    
    abstract function connect ();
    
    abstract function escapeMethod ($vars);
    
    abstract function query ($sql);
    
    abstract function affectedRows ($result);
    
    abstract function numRows ($result);
    
    abstract function fetchObject ($result);
    
    abstract function isConnected ();
    
    function escape ($vars) {
        if (is_array($vars)) {
            foreach ($vars as $var => $key) {
                $vars[$key] = $this->escapeMethod($var);
            }
        }
    }
    
    function getError () {
        
    }
    
    function isAvalible () {
        
    }
    
    function getTableNames () {
        
    }
      
    function getTableFeilds ($tableName) {
        
    }
    
    function close () {
        
    }
    
    function error () {
        
    }
}

/*
class CsvDataSource extends DbDataSource {
}
class XmlDataSource extends DbDataSource {
}
*/

class MysqlDataSource extends DbDataSource {

    private $connected = false;
    private $error = null;
    
    function getTableNames () {
        return $this->query("select tablename from info_schema where database = database()");
    }
    
    function getTableFeilds ($tableName) {
        $tableName = mysql_real_escape_string($tableName);
        return $this->query("select * from info_schema where database = datebase() and tablename = '$tableName'");
    }
    
    function query ($query) {
        $result = mysql_query($query) or parent::error();
        return $result;
    }
    
    function escapeMethod ($input) {
        return mysql_real_escape_string($input);
    }
    
    function affectedRows ($result) {
        return mysql_affected_rows($result);
    }
    
    function numRows ($result) {
        return mysql_num_rows($result);
    }
    
    function fetchObject ($result) {
        if ($result) {
            $rows = mysql_num_rows($result);
            if ($rows < 1) {
                return;
            }
            $obj = mysql_fetch_object($result);
            return $obj;
        }
        return;
    }
    
    function getError () {
        $error = mysql_error();
        if ($this->error == null && empty($error)) {
            $error = null;
        } else {
            //if (empty($error)) {
            //    $error = $this->error;
            //}
        }
        return $error;
    }
    
    function isAvalible () {
        return true;
    }
    
    function connect () {
        if (false !== mysql_connect(Config::getDbHost(),Config::getDbUser(),Config::getDbPassword()) 
                && true === mysql_select_db(Config::getDBName())) {
            $this->connected = true;
        } else {
            $this->connected = false;
            Log::error("failed to connect : ".$this->getError());
        }
        return $this->connected;
    }
    
    function isConnected () {
        return $this->connected;
    }
}

?>