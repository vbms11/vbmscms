<?php

require_once 'core/plugin.php';

class CustomFileManagerModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        switch (parent::getAction()) {
            case "uploadFile":
                if (Context::hasRole("fileSystem.upload")) {
                    FileSystemModel::uploadFile(parent::get("parent"), "uploadFile");
                }
                break;
            case "createDirectory":
                if (Context::hasRole("fileSystem.create")) {
                    FileSystemModel::createDirectory(parent::post("name", parent::get("parent")));
                }
                break;
            case "deleteFile":
                if (Context::hasRole("fileSystem.delete") && FileSystemModel::canDeleteFile(Context::getUserId(), parent::get("id"))) {
                    FileSystemModel::deleteFile(parent::get("id"));
                }
                break;
            case "renameFile":
                if (Context::hasRole("fileSystem.rename") && FileSystemModel::canRenameFile(Context::getUserId(), parent::get("id"))) {
                    // validate filename
                    if (preg_match_all("[09azAz]{1,200}", parent::post("newName"))) {
                        $file = FileSystemModel::getFile(parent::get("id"));
                        rename($file->filename, dirname($file->filepath).DIRECTORY_SEPARATOR.$newName);
                    } else {
                        parent::setMessages(parent::getTranslation("fileSystem.invalidFileName", array("fileName"=>parent::post("newName"))));
                    }
                }
                break;
            case "downloadFile":
                
                if (Context::hasRole("fileSystem.download") && FileSystemModel::canDownlaodFile(Context::getUserId(), parent::get("id"))) {
                    
                    $file = FileSystemModel::getFile(parent::get("id"));
                    
                    // get mime type
                    if ($forceDownload) {
                        $mimeType = "application/octet-stream";
                    } else {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mimeType = finfo_file($finfo, $filename);
                        finfo_close($finfo);
                    }
                    
                    // set header
                    header("Pragma: public");
                    header("Expires: 0");
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header("Cache-Control: private", false);
                    header("Content-Type: ".$mimeType, true, 200);
                    header('Content-Length: '.$file->size);
                    header('Content-Disposition: attachment; filename='.$file->filename);
                    header("Content-Transfer-Encoding: binary");
                    
                    // put file in output stream
                    readfile($filePath);
                    
                    Context::setReturnValue("");
                }
                break;
            case "deleteDirectory":
                if (Context::hasRole("fileSystem.delete") && FileSystemModel::canDeleteDirectory(Context::getUserId(), parent::get("id"))) {
                    FileSystemModel::deleteDirectory(parent::get("id"));
                }
                break;
            case "renameDirectory":
                if (Context::hasRole("fileSystem.rename") && FileSystemModel::canRenameDirectory(Context::getUserId(), parent::get("id"))) {
                    // validate filename
                    if (preg_match_all("[09azAz]{1,200}", parent::post("newName"))) {
                        $directory = FileSystemModel::getFile(parent::get("id"));
                        if (!empty($directory)) {
                            rename($directory->path, dirname($directory->path).DIRECTORY_SEPARATOR.$newName);
                        }
                    } else {
                        parent::setMessages(parent::getTranslation("fileSystem.invalidDirectoryName", array("directoryName"=>parent::post("newName"))));
                    }
                }
                break;
            case "downloadDirectory":
                
                if (Context::hasRole("fileSystem.download") && FileSystemModel::canDownlaodDirectory(Context::getUserId(), parent::get("id"))) {
                    
                    $directory = FileSystemModel::getDirectory(parent::get("id"));
                    
                    // Get real path for our folder
                    $rootPath = realpath($directory->path);
                    
                    // Initialize archive object
                    $zip = new ZipArchive();
                    $zip->open('file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
                    
                    // Create recursive directory iterator
                    /** @var SplFileInfo[] $files */
                    $files = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($rootPath),
                        RecursiveIteratorIterator::LEAVES_ONLY
                    );
                    
                    $tempFilePath = Resource::createResourceLink("fileSystem/temp");
                    $tempFileName = null;
                    do {
                        $tempFileName = md5(rand())."zip";
                    } while (file_exists());
                    
                    foreach ($files as $name => $file) {
                        // Skip directories (they would be added automatically)
                        if (!$file->isDir()) {
                            // Get real and relative path for current file
                            $filePath = $file->getRealPath();
                            $relativePath = substr($filePath, strlen($rootPath) + 1);
                    
                            // Add current file to archive
                            $zip->addFile($filePath, $relativePath);
                        }
                    }
                    
                    // Zip archive will be created only after closing object
                    $zip->close();
                }
                break;
            default:
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView ($directoryId = null) {

        switch (parent::getAction()) {
            default:
                if (Context::hasRole("fileSystem.view")) {
                    $selectedDirectory = parent::get("directoryId");
                    if (!empty($selectedDirectory)) {
                        $directoryId = $selectedDirectory;
                    }
                    $this->printMainView($directoryId);
                }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("fileSystem.edit","fileSystem.view","fileSystem.upload","fileSystem.create","fileSystem.downlaod","fileSystem.rename","fileSystem.admin");
    }
    
    function getStyles () {
        return parent::getResourcePaths(array("css/customFileManager.css"));
    }
    
    function printMainView ($directoryId) {
        
        if (!empty($directoryId)) {
            
            $this->printListDirectoryView($directoryId);
        }
    }
    
    function printListDirectoryView ($directoryId) {
        
        $directory = FileSystemModel::getDirectory($directoryId);
        
        ?>
        <div class="panel fileSystemListDirectoryPanel">
            <?php
            $this->printDirectoryActions($directory);
            ?>
            <div class="fs_list_grid">
                <?php
                $this->printDirectorysList($directoryId);
                $this->printFilesList($directoryId);
                ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php
    }
    
    function printDirectoryActions ($directory) {
        ?>
        <div class="fs_actions">
            <?php
            if (!empty($directory->parent)) {
                ?>
                <a href="<?php echo parent::link(array("action"=>"viewDirectory","id"=>$directory->parent)); ?>">Back</a>
                <?php
            }
            ?>
            <a href="<?php echo parent::link(array("action"=>"uploadFile","id"=>$directory->pid)); ?>">Upload</a>
            <a href="<?php echo parent::link(array("action"=>"createDirectory","id"=>$directory->pid)); ?>">New Directory</a>
            <a href="<?php echo parent::link(array("action"=>"downloadDirectory","id"=>$directory->pid)); ?>">Download</a>
            <a href="<?php echo parent::link(array("action"=>"renameDirectory","id"=>$directory->pid)); ?>">Rename</a>
            <?php
            if (!empty($directory->parent)) {
                ?>
                <a href="<?php echo parent::link(array("action"=>"deleteDirectory","id"=>$directory->pid)); ?>">Delete</a>
                <?php
            }
            ?>
            <select name="displayType">
                <option value="grid"><?php echo parent::translation("customFileManager.displayType.grid"); ?></option>
                <option value="table"><?php echo parent::translation("customFileManager.displayType.table"); ?></option>
            </select>
        </div>
        <?php
    }
    
    function getDisplayType () {
        
        $displayType = parent::get("displayType");
        if (empty($displayType)) {
            $displayType = parent::session("displayType");
        }
        if (empty($displayType)) {
            $displayType = parent::param("displayType");
        }
        parent::session("displayType", $displayType);
        
        return $displayType;
    }
    
    function printFilesList ($directoryId) {
        
        $files = FileSystemModel::getFiles($directoryId);
        
        $displayType = $this->getDisplayType();
        
        foreach ($files as $file) {
            
            ?>
            <div class="fs_file fs_display_<?php echo $displayType; ?>">
                <div class="fs_extImage">
                    <img src="<?php echo FileSystemModel::getFileTypeImage($file); ?>" alt="" />
                </div>
                <div class="fs_name">
                    <?php echo $file->filename; ?>
                </div>
                <div class="fs_size">
                    <?php echo $file->size; ?>
                </div>
                <div class="fs_date">
                    <?php echo $file->createdate; ?>
                    <?php echo $file->modifydate; ?>
                </div>
                <div class="fs_options">
                    <a href="<?php echo parent::link(array("action"=>"deleteFile","id"=>$file->pid)); ?>">Delete</a>
                    <a href="<?php echo parent::link(array("action"=>"renameFile","id"=>$file->pid)); ?>">Rename</a>
                    <a href="<?php echo parent::link(array("action"=>"downloadFile","id"=>$file->pid)); ?>">Download</a>
                </div>
            </div>
            <?php
        }
        ?>
        <script>
        <?php
        switch ($displayType) {
            case "grid":
                ?>
                $(".fs_file").append(
                    $("<div>",{"class":"fs_dropDown"})
                        .mouseout(function(index,object){
                            object.hide();
                        })
                );
                $(".fs_name").each(function(index,object){
                    object.mouseover(function(){
                        $(this).parent().find("fs_dropDown").show();
                    });
                })
                $(".fs_size, .fs_date, .fs_options").each(function(index,object){
                    object.parent().append(object);
                });
                <?php
                break;
            case "table":
                break;
        }
        ?>
        </script>
        <?php
    }
    
    function printDirectorysList ($directoryId) {
        
        $directorys = FileSystemModel::getDirectorys($directoryId);
        
        $displayType = $this->getDisplayType();
        
        foreach ($directorys as $directory) {
            
            ?>
            <div class="fs_directory fs_display_<?php echo $displayType; ?>">
                <div class="fs_extImage">
                    <img src="<?php echo FileSystemModel::getFileTypeImage($directory); ?>" alt="" />
                </div>
                <div class="fs_name">
                    <?php echo $directory->name; ?>
                </div>
                <div class="fs_date">
                    <?php echo $directory->createdate; ?>
                </div>
                <div class="fs_options">
                    <a href="<?php echo parent::link(array("action"=>"deleteDirectory","id"=>$directory->pid)); ?>">Delete</a>
                    <a href="<?php echo parent::link(array("action"=>"renameDirectory","id"=>$directory->pid)); ?>">Rename</a>
                    <a href="<?php echo parent::link(array("action"=>"downloadDirectory","id"=>$directory->pid)); ?>">Download</a>
                </div>
            </div>
            <?php
        }
        
        ?>
        <script>
        <?php
        switch ($displayType) {
            case "grid":
                ?>
                $(".fs_directory").append(
                    $("<div>",{"class":"fs_dropDown"})
                        .mouseout(function(index,object){
                            object.hide();
                        })
                );
                $(".fs_name").each(function(index,object){
                    object.mouseover(function(){
                        $(this).parent().find("fs_dropDown").show();
                    });
                })
                $(".fs_date, .fs_options").each(function(index,object){
                    object.parent().append(object);
                });
                <?php
                break;
            case "table":
                break;
        }
        ?>
        </script>
        <?php
    }
    
}

?>