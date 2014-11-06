<?php

class BackupModel {
    
    static function getBackup ($id) {
        $id = mysql_real_escape_string($id);
        $result = Database::query("select * from t_backup where id = '$id'");
        return mysql_fetch_object($result);
    }
    
    static function getBackups () {
        $result = Database::query("select * from t_backup");
        $backups = array();
        while ($obj = mysql_fetch_object($result)) {
            $backups[] = $obj;
        }
        return $backups;
    }
    
    static function deleteBackup ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_backup where id = '$id'");
    }
    
    static function addBackup ($name,$date=null) {
        $dateSql = "now()";
        if ($date != null) {
            $dateSql = "'".  mysql_real_escape_string($date)."'";
        }
        $name = mysql_real_escape_string($name);
        Database::query("insert into t_backup (name,date) values ('$name',$dateSql)");
    }
    
    static function loadBackup ($id) {
        
        $backups = BackupModel::getBackups();
        $backup = BackupModel::getBackup($id);
        if ($backup != null) {
            
            $path = ResourcesModel::getResourcePath("backup");
            $sqls = file_get_contents($path.$backup->name);
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
    
    static function createBackup () {
        
        //get all of the tables
        $tables = array();
        $result = Database::query('SHOW TABLES');
        while ($row = mysql_fetch_row($result)) {
            $tables[] = $row[0];
        }
        
        $return = "-- vbmscms database backup from: ".date("Y/m/d h:m:s").PHP_EOL;
        
        //cycle through
        foreach ($tables as $table) {
            
            $result = Database::query('SELECT * FROM '.$table);
            $num_fields = mysql_num_fields($result);

            $return.= 'DROP TABLE '.$table.';'.PHP_EOL;
            $row2 = mysql_fetch_row(Database::query('SHOW CREATE TABLE '.$table));
            $row2 = str_replace("\r\n", PHP_EOL, $row2);
            $row2 = str_replace("\n", PHP_EOL, $row2);
            $return.= $row2[1]."; ".PHP_EOL;

            for ($i=0; $i<$num_fields; $i++) {
                while($row = mysql_fetch_row($result)) {

                    $return.= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$num_fields; $j++) 
                    {
                        $row[$j] = mysql_real_escape_string($row[$j]);
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
                $return.="".PHP_EOL.PHP_EOL;
        }

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