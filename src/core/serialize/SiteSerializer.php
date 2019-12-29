<?php

class SiteSerializer {
    
    public static $files;
    public static $tables;
    
    const folder_files = "data";
    const file_site = "site.xml";
    
    static function clear () {
        self::$files = array();
        self::$tables = array();
    }
    
    static function getTable ($tableName) {
        return self::$tables[$tableName];
    }
    
    static function addTable ($tableName, $data) {
        if (!isset(self::$tables[$tableName])) {
            self::$tables[$tableName] = array();
        }
        self::$tables[$tableName][] = $data;
    }
    
    static function addFile ($filePath) {
        self::$files[$filePath] = $filePath;
    }
    
    static function createXml () {
        
        // tables
        $xml = new DOMDocument();
        
        $xmlTable = $xml->createElement("tables");
        foreach ($this->tables as $tableName => $data) {
            $tableTag = $xmlTable->createElement("table");
            $tableTag->setAttribute("name",$tableName);
            if (!empty($data)) {
                $table = $tableTag->createElement("data");
                foreach ($data as $key => $value) {
                    $table->setAttribute($key,$value);
                }
                $tableTag->appendChild($table);
            }
            $xmlTable->appendChild($tableTag);
        }
        
        // files
        $xmlFile = $xml->createElement("files");
        foreach ($this->files as $filePath => $data) {
            $file = $xmlFile->createElement("file");
            $file->setAttribute("path",$filePath);
            $xmlFile->appendChild($file);
        }
        
        return $xml->saveXML();
    }
    
    static function loadXml ($filename) {
        
        // tables
        $xml = new DOMDocument();
        $xml->loadXML($filename);
        $xmlTables = $xml->getElementsByTagName("table");
        foreach ($xmlTables as $xmlTable) {
            $tableName = $xmlTable->getAttribute('name');
            $tableData = $xmlTable->getElementsByTagName("data");
            foreach ($tableData as $table) {
                $data = new stdClass();
                foreach ($table->attributes as $attr) {
                    $data->$attr->localName = $attr->nodeValue;
                } 
                self::addTable($tableName,$data);    
            }
        }
        
        // files
        $xmlFiles = $xml->getElementsByTagName("files");
        $files = $xmlFiles->getElementsByTagName("file");
        if (!empty($files)) {
            foreach ($files as $file) {
                self::addFile($xmlTable->getAttribute("path"));
            }
        }
    }
    
    static function createArchive ($folder) {
        
        mkdir($folder);
        file_put_contents(self::file_site, self::createXml());
        
        mkdir($folder."/".self::folder_data);
        foreach ($this->files as $filePath => $data) {
            copy($filePath, $folder."/".self::folder_data."/".$filePath);
        }
    }
    
    static function loadArchive ($folder) {
        
        self::clear();
        self::loadXml($folder."/".self::file_site);
        
        foreach (self::$files as $filePath => $file) {
            copy($folder."/".self::folder_data."/".$filePath, $filePath);
        }
    }
}