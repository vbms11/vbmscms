<?php

class Database {
    
    private static $error = null;
    private static $dataSource = array();
    private static $defaultDataSourceName = "mysqli";
    
    static function getError () {
        return Database::getDataSource()->getError();
    }
    
    static function getTableNames () {
        return Database::getDataSource()->getTableNames();
    }
    
    static function getTableFeilds ($tableName) {
        return Database::getDataSource()->getTableFeilds($tableName);
    }
    
    static function getDataSource ($dataSourceName = null) {
        
        if ($dataSourceName == null) {
            $dataSourceName = self::$defaultDataSourceName;
        }
        if (isset(self::$dataSource[$dataSourceName])) {
            return self::$dataSource[$dataSourceName];
        }
        $newDataSource = DataSourceFactory::getDataSource($dataSourceName);
        if ($newDataSource == null) {
            throw Exception("no datasource exists with that name");
        }
        self::$dataSource[$dataSourceName] = $newDataSource;
        return self::$dataSource[$dataSourceName];
    }
    
    static function escape ($vars) {
        
        return Database::getDataSource()->escape($vars);
        /*
        if (is_array($vars)) {
            foreach ($vars as $var) {
                $var = Database::escape()->escape($var);
            }
        } else {
            $vars = Database::escape()->escape($vars);
        }
        */
    }
    
    static function affectedRows ($result) {
        return Database::getDataSource()->affectedRows($result);
    }
    
    static function numRows ($result) {
        return Database::getDataSource()->numRows($result);
    }
    
    static function query ($query) {
        Log::query($query);
        $result = Database::getDataSource()->query($query);
        $error = Database::getError();
        if ($error != null) {
            Context::addError("database::query('".$query."') error: ".$error);
        } else {
            self::$error = null;
        }
        return $result;
    }
    
    static function queryAsObject ($query) {
        Log::query($query);
        $result = Database::getDataSource()->query($query);
        $obj = Database::getDataSource()->fetchObject($result);
        $error = Database::getError();
        if ($error != null) {
            Context::addError("database::query('".$query."') error: ".$error);
        } else {
            self::$error = null;
        }
        // var_dump($obj);
        return $obj;
    }
    
    static function queryAsArray ($query,$index = null) {
        Log::query($query);
        $result = Database::getDataSource()->query($query) or die(Database::getError());
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
        $error = Database::getError();
        if ($error != null) {
            Context::addError("database::query('".$query."') error: ".$error);
        } else {
            self::$error = null;
        }
        // var_dump($ret);
        return $ret;
    }

    static function getLastInsertId ($tableName) {
        $lastInsertId = Database::getDataSource()->query("select max(id) as id from 0x".bin2hex($tableName));
        return $lastInsertId->id;
    }
    
    static function close () {
        foreach (self::$dataSource as $name => $dataSource) {
            $dataSource->close();
        }
        self::$dataSource = array();
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
    function isConnected ();
    function getTableNames ();    
    function getTableFeilds ($tableName);
    function close ();
}

class MysqlDataSource implements IDataSource {
    
    private $connected = false;
    private $error = null;
    
    function getTableNames () {
        return Database::queryAsArray('select tablename from info_schema where database = datebase()');
    }
    
    function getTableFeilds ($tableName) {
        $tableName = mysql_real_escape_string($tableName);
        return Database::queryAsArray("select * from info_schema where database = datebase() and tablename = '$tableName'");
    }
    
    function query ($query) {
        $result = mysql_query($query) or $this->error = true;
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
        if (false !== mysql_connect(Config::getDBHost(),Config::getDBUser(),Config::getDBPassword()) 
                && true === mysql_select_db(Config::getDBName())) {
            $this->connected = true;
        } else {
            $this->connected = false;
            Context::addError("database::connect() : failed to connect : ".$this->getError());
        }
        return $this->connected;
    }
    
    function isConnected () {
        return $this->connected;
    }
    
    function close () {
        mysql_close();
    }
}

class MysqliDataSource implements IDataSource {
    
    private $connected = false;
    private $error = null;
    private $mysqliLink = null;
    
    private function getDbLink () {
        if (!isset($_REQUEST["mysqliDataSource.mysqliLink"])) {
            $this->connect();
        }
        return $_REQUEST["mysqliDataSource.mysqliLink"];
    }
    
    private function setDbLink ($link) {
        $_REQUEST["mysqliDataSource.mysqliLink"] = $link;
    }
    
    function getTableNames () {
        return Database::queryAsArray('select tablename from info_schema where database = datebase()');
    }
    
    function getTableFeilds ($tableName) {
        $tableName = Database::escape($tableName);
        return Database::queryAsArray("select * from info_schema where database = datebase() and tablename = '$tableName'");
    }
    
    function query ($query) {
        $result = mysqli_query($this->getDbLink(), $query) or $this->error = true;
        return $result;
    }
    
    function escape ($input) {
        return mysqli_real_escape_string($this->getDbLink(), $input);
    }
    
    function affectedRows ($result) {
        return mysqli_affected_rows($this->getDbLink());
    }
    
    function numRows ($result) {
        return mysqli_num_rows($result);
    }
    
    function fetchObject ($result) {
        if ($result) {
            $rows = mysqli_num_rows($result);
            if ($rows < 1) {
                return;
            }
            $obj = mysqli_fetch_object($result);
            return $obj;
        }
        return;
    }
    
    function getError () {
        $error = mysqli_error($this->getDbLink());
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
        $dbLink = mysqli_connect(Config::getDBHost(),Config::getDBUser(),Config::getDBPassword());
        if (false !== $dbLink && true === mysqli_select_db($dbLink, Config::getDBName())) {
            $this->setDbLink($dbLink);
            $this->connected = true;
        } else {
            $this->connected = false;
            Context::addError("database::connect() : failed to connect : ".$this->getError());
        }
        return $this->connected;
    }
    
    function isConnected () {
        return $this->connected;
    }
    
    function close () {
        mysqli_close($this->getDbLink());
    }
}


class SqliteDataSource implements IDataSource {
    
    private $database = null;
    private $error = null;
    private $connected = false;
    
    function getTableNames () {
        return Database::queryAsArray('select tablename from info_schema where database = datebase()');
    }
    
    function getTableFeilds ($tableName) {
        $tableName = mysql_real_escape_string($tableName);
        return Database::queryAsArray("select * from info_schema where database = datebase() and tablename = '$tableName'");
    }
    
    function query ($query) {
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
            $this->database = new SqliteDataSource('myDatabase.sqlite', 0666, $this->error);
            $this->connected = true;
        } catch(Exception $e) {
            $this->connected = false;
        }
        return $this->connected;
    }
    
    function isConnected() {
        return $this->connected;
    }
    
    function close () {
        
    }
}

class DataSourceFactory {
    
    // static $dataSources = array(MysqlDataSource);
    
    static function getDefaultDataSource () {
        $dataSource = new MysqliDataSource();
        if ($dataSource->isAvalible() && $dataSource->connect()) {
            return $dataSource;
        }
        throw Exception("datasource not avalible or cannot connect");
    }
    
    static function getDataSource ($dataSourceName = null) {
        if ($dataSourceName == null) {
            return self::getDefaultDataSource();
        }
        return self::getDefaultDataSource();
    }
}

?>