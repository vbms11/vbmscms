<?php

class BackupModel {
    
    static function getBackup ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_backup where id = '$id'");
    }
    
    static function getBackups () {
        return Database::queryAsArray("select * from t_backup");
    }
    
    static function getBackupFiles () {
        return ResourcesModel::listResources("backup");
    }
    
    static function deleteBackup ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_backup where id = '$id'");
    }
    
    static function addBackup ($name,$date=null) {
        $dateSql = "now()";
        if ($date != null) {
            $dateSql = "'".  Database::escape($date)."'";
        }
        $name = Database::escape($name);
        Database::query("insert into t_backup (name,date) values ('$name',$dateSql)");
    }
    
    static function loadBackup ($id) {
        
        $backup = BackupModel::getBackup($id);
        if ($backup != null) {
            $path = ResourcesModel::getResourcePath("backup");
            self::loadBackupFile($path.$backup->name);
        }
    }
    
    static function loadBackupFile ($file) {
        
        if (file_exists($file)) {
            
            $sqls = file_get_contents($file);
            $sqls = explode(";",$sqls);
            
            // run restore sqls
            foreach ($sqls as $sql) {
            	if (Common::isEmpty($sql) || stripos(trim($sql),"--") == 0) {
            		continue;
            	}
                Database::query($sql);
            }
            
            // restore other backups
            // foreach ($backups as $backup) {
            //    BackupModel::deleteBackup($backup->id);
            //    addBackup($backup->name,$backup->date);
            // }
        }
    }
    
    static function getDatabaseSql ($freshInstall=false) {
        
        //get all of the tables
        $tables = array();
        $results = Database::queryAsArray('SHOW TABLES');
        foreach ($results as $result) {
            $tables[] = $result[0];
        }
        
        $return = "";
        
        //cycle through
        foreach ($tables as $table) {
            
            $result = Database::queryAsArray('SELECT * FROM '.$table);
            $num_fields = count($result);
            
            $return.= 'DROP TABLE '.$table.';'.PHP_EOL;
            $row2 = Database::queryAsObject('SHOW CREATE TABLE '.$table);
            $row2 = str_replace("\r\n", PHP_EOL, $row2);
            $row2 = str_replace("\n", PHP_EOL, $row2);
            $return.= $row2[1]."; ".PHP_EOL;
            
            $skipedTables = array("t_user","t_cms_customer","t_site","t_domain","t_roles");
            
            if ($freshInstall && in_array($table, $skipedTables)) {
                continue;
            }
            
            for ($i=0; $i<$num_fields; $i++) {
                foreach ($result as $row) {
                    
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$num_fields; $j++)
                    {
                        $row[$j] = Database::escape($row[$j]);
                        if (isset($row[$j])) {
                            $return.= '0x';
                            $return.= Common::isEmpty(bin2hex($row[$j])) ? "0" : bin2hex($row[$j]);
                        } else {
                            $return.= "''";
                        }
                        if ($j<($num_fields-1)) {
                            $return.= ',';
                        }
                    }
                    $return.= ");".PHP_EOL;
                }
            }
            $return .= PHP_EOL.PHP_EOL;
        }
        
        return $return;
    }
    
    static function createBackup () {
        
        $return = self::getDatabaseSql();
        
        //save file
        $path = ResourcesModel::getResourcePath("backup");
        $filename = 'db-backup-'.time().'-'.Common::randHash(20,false).'.sql';
        $handle = fopen($path.$filename,'w+');
        fwrite($handle,$return);
        fclose($handle);
        
        // add to database
        BackupModel::addBackup($filename);
    }
}

?>