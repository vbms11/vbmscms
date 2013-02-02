<?php

$dataSource = null;

class Database {
    
    static function getDataSource () {
        global $dataSource;
        if ($dataSource == null) {
            $dataSource = DataSourceFactory::getDefaultDataSource();
        }
        return $dataSource;
    }
    
    static function escape (&$vars) {
        if (is_array($vars)) {
            foreach ($vars as $var) {
                $var = Database::getDataSource()->escape($var);
            }
        } else {
            $vars = Database::getDataSource()->escape($vars);
        }
    }
    
    static function affectedRows ($result) {
        return Database::getDataSource()->affectedRows($result);
    }
    
    static function numRows ($result) {
        return Database::getDataSource()->numRows($result);
    }
    
    static function query ($query) {
        // Log::info("query: $query");
        $result = Database::getDataSource()->query($query) or die(Database::getDataSource()->getError());
        return $result;
    }
    
    static function queryAsObject ($query) {
        $result = Database::getDataSource()->query($query) or die(Database::getDataSource()->getError());
        $obj = Database::getDataSource()->fetchObject($result);
        return $obj;
    }
    
    static function queryAsArray ($query,$index = null) {
        $result = Database::getDataSource()->query($query) or die(Database::getDataSource()->getError());
        $ret = array();
        if ($index != null) {
            while ($obj = Database::getDataSource()->fetchObject($result)) {
                $ret[$obj->$index] = $obj;
            }
        } else {
            while ($obj = Database::getDataSource()->fetchObject($result)) {
                $ret[] = $obj;
            }
        }
        return $ret;
    }

    static function getLastInsertId ($tableName) {
	$lastInsertId = Database::getDataSource()->fetchObject("select last_insert_id() as id from 0x".bin2hex($tableName));
	return $lastInsertId->id;
    }
}

interface IDataSource {
    
    function query ($query);
    function escape ($input);
    function affectedRows ($result);
    function numRows ($result);
    function fetchObject ($result);
    function getError ();
    function isAvalible ();
    function connect ();
}

class MysqlDataSource implements IDataSource {
    
    function query ($query) {
        // echo $query."<br/><br/>";
        // $_SESSION['database.querys'][] = $query;
        $result = mysql_query($query) or die(mysql_error());
        return $result;
    }
    
    function escape ($input) {
        return mysql_real_escape_string($input);
    }
    
    function affectedRows ($result) {
        return mysql_affected_rows($result);
    }
    
    function numRows ($result) {
        return mysql_num_rows($result);
    }
    
    function fetchObject ($result) {
        $obj = mysql_fetch_object($result);
        return $obj;
    }
    
    function getError () {
        return mysql_error();
    }
    
    function isAvalible () {
        return true;
    }
    
    function connect () {
        mysql_connect($GLOBALS['dbHost'],$GLOBALS['dbUser'],$GLOBALS['dbPass']) or die(mysql_error());
        mysql_select_db($GLOBALS['dbName']) or die(mysql_error());
    }
}

class SqliteDataSource implements IDataSource {
    
    private $database = null;
    private $error = null;
    
    function query ($query) {
        // echo "$query <br/><br/>";
        $result = $this->database->queryExec($query, $this->error);
        if(!$result) {
            return null;
        }
        $row = $result->fetchObject() or die($this->error);
        return $row;
    }
    
    function escape ($input) {
        return sqlite_escape_string($input);
    }
    
    function affectedRows ($result) {
        $affectedRows = mysql_affected_rows($result);
        return $affectedRows;
    }
    
    function numRows ($result) {
        $numRows = mysql_num_rows($result);
        return $numRows;
    }
    
    function fetchObject ($result) {
        $obj = $result->fetchObject();
        return $obj;
    }
    
    function getError () {
        return $this->error;
    }
    
    function isAvalible () {
        return true;
    }
    
    function connect () {
        try {
            $this->database = new SQLiteDatabase('myDatabase.sqlite', 0666, $this->error);
        } catch(Exception $e) {
            return false;
        }
        return true;
    }
}

class DataSourceFactory {
    
    // static $dataSources = array(MysqlDataSource);
    
    static function getDefaultDataSource () {
        $dataSource = new MysqlDataSource();
        if ($dataSource->isAvalible()) {
            $dataSource->connect();
            return $dataSource;
        }
        return $dataSource;
    }
}

?>