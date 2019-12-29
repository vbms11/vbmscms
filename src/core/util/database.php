<?php

class Database {
    
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
        return DataSourceFactory::getDataSource($dataSourceName);
    }
    
    static function escape ($vars) {
        return Database::getDataSource()->escape($vars);
    }
    
    static function affectedRows ($result) {
        return Database::getDataSource()->affectedRows($result);
    }
    
    static function numRows ($result) {
        return Database::getDataSource()->numRows($result);
    }
    
    static function query ($query) {
        Log::query($query);
        $dataSource = Database::getDataSource();
        $result = $dataSource->query($query);
        $error = $dataSource->getError();
        if ($error != null) {
            throw new Exception("error: $error");
        }
        return $result;
    }
    
    static function queryAsObject ($query) {
        Log::query($query);
        $dataSource = Database::getDataSource();
        $result = $dataSource->query($query);
        $obj = $dataSource->fetchObject($result);
        $error = $dataSource->getError();
        if ($error != null) {
            throw new Exception("error: $error");
        }
        return $obj;
    }
    
    static function queryAsArray ($query, $index = null) {
        Log::query($query);
        $dataSource = Database::getDataSource();
        $result = $dataSource->query($query);
        $ret = array();
        if ($result) {
            if ($index != null) {
                while ($obj = $dataSource->fetchObject($result)) {
                    $ret[$obj->$index] = $obj;
                }
            } else {
                while ($obj = $dataSource->fetchObject($result)) {
                    $ret[] = $obj;
                }
            }
        }
        $error = $dataSource->getError();
        if ($error != null) {
            throw new Exception("error: $error");
        }
        return $ret;
    }

    static function getLastInsertId ($tableName) {
        $lastInsertId = Database::getDataSource()->query("select max(id) as id from 0x".bin2hex($tableName));
        return $lastInsertId->id;
    }
    
    static function close () {
        self::getDataSource()->close();
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

class MysqliDataSource implements IDataSource {
    
    private $connected = false;
    private $error = null;
    private $mysqliLink = null;
    
    function getTableNames () {
        return Database::queryAsArray('select table_name from information_schema.tables where table_schema = database()');
    }
    
    function getTableFeilds ($tableName) {
        $tableName = $this->escape($tableName);
        return Database::queryAsArray("SELECT column_name, data_type, column_default, is_nullable, numeric_precision, character_maximum_length, extra from information_schema.columns WHERE table_schema=database() and table_name='$tableName'");
    }
    
    function query ($query) {
        return mysqli_query($this->mysqliLink, $query);
    }
    
    function escape ($input) {
        return mysqli_real_escape_string($this->mysqliLink, $input);
    }
    
    function affectedRows ($result) {
        return mysqli_affected_rows($this->mysqliLink);
    }
    
    function numRows ($result) {
        return mysqli_num_rows($result);
    }
    
    function fetchObject ($result) {
        return mysqli_fetch_object($result);
    }
    
    function getError () {
        $error = mysqli_error($this->mysqliLink);
        if (empty($error)) {
            $error = null;
        }
        return $error;
    }
    
    function isAvalible () {
        return true;
    }
    
    function connect () {
        $this->mysqliLink = mysqli_connect(Config::getDBHost(),Config::getDBUser(),Config::getDBPassword());
        if (false !== $this->mysqliLink && true === mysqli_select_db($this->mysqliLink, Config::getDBName())) {
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
        mysqli_close($this->mysqliLink);
    }
}

class DataSourceFactory {
    
    static $dataSources = array();
    
    static function getDefaultDataSource () {
        $dataSource = new MysqliDataSource();
        if ($dataSource->isAvalible() && $dataSource->connect()) {
            return $dataSource;
        }
        throw new Exception("datasource cannot connect error: ".$dataSource->getError());
    }
    
    static function getDataSource ($dataSourceName = null) {
        if (array_key_exists($dataSourceName,array_keys(self::$dataSources))) {
            return self::$dataSources[$dataSourceName];
        }
        if ($dataSourceName == null) {
            self::$dataSources[$dataSourceName] = self::getDefaultDataSource();
            return self::$dataSources[$dataSourceName];
        }
        return self::getDefaultDataSource();
    }
}

?>