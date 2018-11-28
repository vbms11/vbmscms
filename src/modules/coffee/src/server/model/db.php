<?php

class DB {
    
    static $defaultDataSource = "mysql";
    static $dataSourceList = null;
    
    function __constructor ($args) {
        
    }
    
    function __call ($name, $params) {
        
    }
    
    static function __callStatic ($name, $params) {
        $dataSource = self::getDataSource();
        switch ($name) {
            case "connect":
                return $dataSource->connect();
                break;
            case "close":
                return $dataSource->close();
                break;
            case "get":
                return $dataSource->get($params[0], $params[1], isset($params[2]) ? $params[2] : false);
                break;
            case "save":
                return self::save($params[0], $params[1]);
                break;
            case "delete":
                return self::delete($params[0], $params[1]);
                break;
            case "all":
                return self::all();
                break;
            case "find":
                return self::find($params[0], $params[1]);
                break;
            case "search":
                return self::search($params[0], $params[1]);
                break;
        }
    }
    
    static function getDataSource ($name = null) {
        if ($dataSource == null) {
            $dataSource = self::$defaultDataSource;
        }
        if (isset(self::$dataSourceList[$name])) {
            return self::$dataSourceList[$name];
        } else {
            $obj = new ReflectionClass($name);
            return $obj->isSubclassOf(DbDataSource);
        }
    }
    
    static function connect () {
        $dataSource = self::getDataSource();
        if (!$dataSource->isConnected()) {
            return $dataSource->connect();
        }
        return true;
    }
    
    static function close () {
        $dataSource = self::getDataSource();
        if ($dataSource->isConnected()) {
            $dataSource->close();
        }
    }
    
    static function get ($tableName, $params, $or=false) {
        $result = array();
        $condition = array();
        foreach ($params as $key => $value) {
            $condition []= " '".mysql_real_escape_string($key)."'='".mysql_real_escape_string($value)."' ";
        }
        $result = mysql_query("select * from $tableName ".implode($or ? " or " : " and ", $condition));
        if (($obj = mysql_fetch_object($result)) != null) {
            $result []= $obj;
        }
        return $result;
    }
    
    static function save ($tableName, $id,  $obj) {
        $id = mysql_real_escape_string($id);
        if ($id == null) {
            $names = array();
            $values = array();
            foreach (get_object_vars($obj) as $name) {
                $names []= $name;
                $values []= $obj->$name;
            }
            mysql_query("insert into $tableName (".implode(",",$names).") values (".implode(",",$values).")");
        } else {
            $params = array();
            foreach (get_object_vars($obj) as $name) {
                $params []= $name."=".$obj->$name;
            }
            mysql_query("update $tableName set ".implode(", ",$params)." where id = '$id'");
        }
    }
    
    static function delete ($tableName, $id) {
        
        $id = mysql_real_escape_string($id);
        $result = mysql_query("delete from $tableName where id = '$id'");
        return mysql_affected_rows($result) > 0;
    }
    
    static function all ($tableName) {
        
        $all = array();
        $result = mysql_query("select * from $tableName");
        while ($row = mysql_fetch_object($result) != null) {
            $all []= $row;
        }
        return $all;
    }
    
    static function find ($tableName, $values, $all) {
        foreach ($values as $value => $key) {
            if (is_array($value)) {
                
            }
        }
        implode($values);
        $all = array();
        $result = $dataSource->query("select * from $tableName");
        
        return $all;
    }
    
    static function search ($tableName, $values, $all) {
        $pattern = "?$value?";
    }
    
}

?>