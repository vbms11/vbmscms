<?php

class Serializer {
    
    public $files;
    public $tables;
    public $oldNewIds;
    
    function __construct() {
        $this->clear();
    }
    
    function clear () {
        $this->files = array();
        $this->tables = array();
        $this->oldNewIds = array();
    }
    
    function getTable ($tableName) {
        return $this->tables[$tableName];
    }
    
    function addTable ($tableName, $data) {
        $this->tables[$tableName] = $data;
    }
    
    function hasTable ($tableName) {
        return isset($this->tables[$tableName]);
    }
    
    function removeTable ($tableName) {
        if (isset($this->tables[$tableName])) {
            unset($this->tables[$tableName]);
        }
    }
    
    function addFile ($filePath) {
        $this->files[$filePath] = $filePath;
    }
    
    function getNewId ($tableName, $oldId) {
        if (isset($this->oldNewIds[$tableName]) && isset($this->oldNewIds[$tableName][$oldId])) {
            return $this->oldNewIds[$tableName][$oldId];
        }
        return null;
        //throw new Exception("getNewId table: $tableName has no new id for old id: $oldId");
    }
    
    function setNewId ($tableName, $oldId, $newId=null) {
        if (!isset($this->oldNewIds[$tableName])) {
            $this->oldNewIds[$tableName] = array();
        }
        if (is_array($oldId)) {
            $this->oldNewIds[$tableName] = $oldId;
        } else {
            $this->oldNewIds[$tableName][$oldId] = $newId;
        }
    }
    
    function createXml () {
        
        // tables
        $xml = new DOMDocument();
        
        $xmlTable = $xml->createElement("tables");
        foreach ($this->tables as $tableName => $data) {
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
                            $cell->setAttribute("value",$value);
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
        foreach ($this->files as $filePath => $data) {
            $file = $xml->createElement("file");
            $file->setAttribute("path",$filePath);
            $xmlFile->appendChild($file);
        }
        $xml->appendChild($xmlFile);
        
        return $xml->saveXML();
    }
    
    function loadXml ($filename) {
        
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
                $this->addTable($tableName,$data);    
            }
        }
        
        // files
        $xmlFiles = $xml->getElementsByTagName("files");
        $files = $xmlFiles->getElementsByTagName("file");
        if (!empty($files)) {
            foreach ($files as $file) {
                $this->addFile($xmlTable->getAttribute("path"));
            }
        }
    }
    
    function createArchive ($archiveFile) {
        
        file_put_contents($archiveFile,gzcompress(serialize(array("tables"=>$this->tables,"files"=>$this->files)),9));
    }
    
    function loadArchive ($archiveFile) {
        
        $this->clear();
        $data = unserialize(gzuncompress(file_get_contents($archiveFile)));
        $this->tables = $data["tables"];
        $this->files = $data["files"];
    }
}

/*


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
    
    static function createArchive ($archiveFile) {
        
        file_put_contents($archiveFile,gzcompress(serialize(array("tables"=>self::$tables,"files"=>self::$files)),9));
    }
    
    static function loadArchive ($archiveFile) {
        
        self::clear();
        $data = unserialize(gzuncompress($archiveFile));
        self::$tables = $data["tables"];
        self::$files = $data["files"];
    }

 */


