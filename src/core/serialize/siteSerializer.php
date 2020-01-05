<?php

class SiteSerializer {
    
    public static $files;
    public static $tables;
    
    const folder_data = "data";
    const file_site = "site.xml";
    
    static function clear () {
        self::$files = array();
        self::$tables = array();
    }
    
    static function getTable ($tableName) {
        return self::$tables[$tableName];
    }
    
    static function addTable ($tableName, $data) {
        self::$tables[$tableName] = $data;
    }
    
    static function addFile ($filePath) {
        self::$files[$filePath] = $filePath;
    }
    
    static function createXml () {
        
        // tables
        $xml = new DOMDocument();
        
        $xmlTable = $xml->createElement("tables");
        foreach (self::$tables as $tableName => $data) {
            $tableTag = $xml->createElement("table");
            $tableTag->setAttribute("name",$tableName);
            if (!empty($data)) {
                foreach ($data as $row) {
                    $table = $xml->createElement("data");
                    foreach ($row as $key => $value) {
                        $cell = $xml->createElement("cell");
                        $cell->setAttribute("name",$key);
                        if ($value == null) {
                            $cell->setAttribute("null","true");
                        } else {
                            $cell->setAttribute("value",utf8_encode($value));
                        }
                        $table->appendChild($cell);
                    }
                    $tableTag->appendChild($table);
                }
            }
            $xmlTable->appendChild($tableTag);
        }
        $xml->appendChild($xmlTable);
        
        // files
        $xmlFile = $xml->createElement("files");
        foreach (self::$files as $filePath => $data) {
            $file = $xml->createElement("file");
            $file->setAttribute("path",$filePath);
            $xmlFile->appendChild($file);
        }
        $xml->appendChild($xmlFile);
        
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
                $cell = $tableData->getElementsByTagName("cell");
                $cellName = $cell->getAttribute("name");
                if ($cell->hasAttribute("null")) {
                    $data->$cellName = null;
                } else {
                    $data->$cellName = $cell->getAttribute("value");
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
    
    function createArchive ($archiveFile) {
        
        file_put_contents($archiveFile,gzcompress(serialize(array("tables"=>$this->tables,"files"=>$this->files)),9));
    }
    
    function loadArchive ($archiveFile) {
        
        $this->clear();
        $data = unserialize(gzuncompress($archiveFile));
        $this->tables = $data["tables"];
        $this->files = $data["files"];
    }
}