<?php

class FileSystemModel {
    
    static $minFileNameLength = 1;
    static $maxFileNameLength = 200;
    
    static function getTempFolder () {
        return "fileSystem".DIRECTORY_SEPARATOR."temp";
    }
    
    static function getRootFolder () {
        return "fileSystem".DIRECTORY_SEPARATOR."root";
    }
    
    static function uploadFile ($parent, $uploadFeildName) {
        
        $name = Database::escape($name);
        $parent = Database::escape($parent);
        $uploadFeildName = Database::escape($uploadFeildName);
        
        $directory = self::getDirectory($parent);
        
        if (empty($directory)) {
            return null;
        }
        
        $allowedExtensions = array_merge(Common::getAllowedImageFormats(), Common::getAllowedDocumentFormats());
        $sizeLimit = Common::getMaximumUploadSize();
        
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload(ResourcesModel::getResourcePath($directory->path));
        
        if (!isset($result['success']) || !$result['success']) {
            return null;
        }
        
        $filename = $result['filename'];
        $filePathFull = ResourcesModel::getResourcePath("files/", $filename);
        
        $newFileId = self::createFile($filename, $parent);
        
        return $newFileId;
    }
    
    static function createFile ($name, $parent) {
        
        $directory = self::getDirectory($parent);
        
        if (empty($directory)) {
            return null;
        }
        
        $name = Database::escape($name);
        $parent = Database::escape($parent);
        
        $publicId = null;
        do {
            $publicId = Common::randHash();
            $exists = self::getFile($publicId);
        } while (empty($exists));
        $publicId = Database::escape($publicId);
        
        Database::query("insert into t_fs_file (name, pid, parent, createdate, modifydate) values('$name', '$publicId', '$parent', now(), now())");
        $result = Database::queryAsObject("select max(id) as newid from t_fs_file");
        
        return $result->newid;
    }
    
    static function createDirectory ($name, $parent=null) {
        
        $directory = null;
        $parentId = null;
        $path = null;
        if (!empty($parent)) {
            $directory = self::getDirectory($parent);
            $parentId = "'".Database::escape($directory->id)."'";
            $path = $directory->path.DIRECTORY_SEPARATOR.$name;
        } else {
            $parentId = "null";
            $path = $name;
        }
        
        $name = Database::escape($name);
        $path = Database::escape($path);
        
        if (!mkdir($path)) {
            return false;
        }
        
        $publicId = null;
        do {
            $publicId = Common::randHash();
            $exists = self::getDirectory($publicId);
        } while (empty($exists));
        $publicId = Database::escape($publicId);
        
        Database::query("insert into t_fs_directory (name, pid, parent, path, createdate) values('$name', '$publicId', $parentId, '$path', now())");
        $result = Database::queryAsObject("select max(id) as newid from t_fs_directory");
        
        return $result->newid;
    }
    
    static function getFile ($pid) {
        
        $pid = Database::escape($pid);
        $file = Database::queryAsObject("select f.* from t_fs_file as f where publicid = '$pid'");
        return $file;
    }
    
    static function deleteFile ($pid) {
        
        $file = self::getFile($pid);
        
        try {
            if (!empty($file)) {
                unlink($file->filepath);
                
                $pid = Database::escape($pid);
                Database::query("delete from t_fs_file where publicid = '$pid'");
            }
        } catch (Exception $e) {
            Context::error("an error happened while deleting the file: ".$file->filepath);
        }
    }
    
    static function renameFile ($pid, $newName) {
        
        $file = self::getFile($pid);
        
        $filePath = dirname($file->filepath).DIRECTORY_SEPARATOR.$newName;
        
        rename($file->filepath, $filePath);
        
        $pid = Database::escape($pid);
        Database::query("update t_fs_file set filename = '$newName', filepath = '$filePath' where publicid = '$pid'");
    }
    
    static function getFiles ($parentPublicId) {
        
        $parentPublicId = Database::escape($parentPublicId);
        
        return Database::queryAsArray("select f.* from t_fs_file where f.parent = '$parentPublicId'");
    }
    
    static function getFileInfo ($pid) {
        
    }
    
    static function getMimeTypeImage ($pid) {
        
    }
    
    
    static function getDirectory ($pid) {
        
        $pid = Database::escape($pid);
        
        return Database::queryAsObject("select d.* from t_fs_directory as d where d.publicid = '$pid'");
    }
    
    static function getDirectorys ($parentPublicId) {
        
        $parentPublicId = Database::escape($parentPublicId);
        
        return Database::queryAsArray("select d.* from t_fs_directory as d where d.parent = '$parentPublicId'");
    }
    
    static function deleteDirectory ($pid) {
        
        $directory = self::getDirectory($pid);
        
        if (unlink($directory->filepath)) {
            
            $pid = Database::escape($pid);
            
            Database::query("delete from t_fs_directory where publicid = '$pid'");
        }
    }
    
    static function renameDirectory ($pid, $name) {
        
        $directory = self::getDirectory($pid);
        
        $newPath = dirname($directory->filepath).DIRECTORY_SEPARATOR.$name;
        
        if (!is_dir($newPath) && !is_file($newPath)) {
            
            rename($directory->filepath, $newPath);
            
            $pid = Database::escape($pid);
            $name = Database::escape($name);
            $newPath = Database::escape($newPath);
            
            Database::query("update t_fs_directory set filepath = '$newPath', name = '$name' where publicid = '$pid'");
            
            return true;
        }
        
        return false;
    }
    
    /* access rights */
    
    static function canDeleteFile ($userId, $pid) {
        $directory = FileSystemModel::getRootDirectoryFromFile($pid);
        $user = UsersModel::getUser($userId);
        if ($user->directoryid == $directory->id) {
            return true;
        }
        return false;
    }
    
    static function canDownloadFile ($userId, $pid) {
        $directory = FileSystemModel::getRootDirectoryFromFile($pid);
        $user = UsersModel::getUser($userId);
        if ($user->directoryid == $directory->id) {
            return true;
        }
        return false;
    }
    
    static function canDeleteDirectory ($userId, $pid) {
        $directory = FileSystemModel::getRootDirectory($pid);
        $user = UsersModel::getUser($userId);
        if ($user->directoryid == $directory->id) {
            return true;
        }
        return false;
    }
    
    static function canRenameDirectory ($userId, $pid) {
        $directory = FileSystemModel::getRootDirectory($pid);
        $user = UsersModel::getUser($userId);
        if ($user->directoryid == $directory->id) {
            return true;
        }
        return false;
    }
    
    static function canDownloadDirectory ($userId, $pid) {
        $directory = FileSystemModel::getRootDirectory($pid);
        $user = UsersModel::getUser($userId);
        if ($user->directoryid == $directory->id) {
            return true;
        }
        return false;
    }
    
    static function escapeFileName ($name) {
        return preg_replace("/[a-zA-Z-09\-\.\ ]{".self::$minFileNameLength.",".self::$maxFileNameLength."}/","_",$name);
    }
    
    static function escapeFolderName ($name) {
        return preg_replace("/[a-zA-Z-09\-\.\ ]{".self::$minFolderNameLength.",".self::$maxFolderNameLength."}/","_",$name);
    }
}
