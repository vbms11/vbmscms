<?php

class GalleryModel {
    
    const type_user = 1;
    const type_module = 2;
    
    // ordering
    
    static function getNextImageOrderKey () {
        $result = Database::query("select max(orderkey) as max from t_gallery_image");
        $row = mysql_fetch_array($result);
        return intval($row['max']) + 1;
    }
    
    static function getNextCategoryOrderKey () {
        $result = Database::query("select max(orderkey) as max from t_gallery_category");
        $row = mysql_fetch_array($result);
        return intval($row['max']) + 1;
    }

    static function setImageOrderKey ($id, $orderKey) {
        $id = mysql_real_escape_string($id);
        $orderKey = mysql_real_escape_string($orderKey);
        Database::query("update t_gallery_image set orderkey='$orderKey' where id='$id'");
    }
    
    static function setCategoryOrderKey ($id, $orderKey) {
        $id = mysql_real_escape_string($id);
        $orderKey = mysql_real_escape_string($orderKey);
        Database::query("update t_gallery_category set orderkey='$orderKey' where id='$id'");
    }
    
    static function moveImageUp ($id) {
        $theImage = self::getImage($id);
        $images = self::getImages($theImage->categoryid);
        $lastImage = null;
        foreach ($images as $image) {
            if ($image->id == $id) {
                if ($lastImage != null) {
                    self::setImageOrderKey($id, $lastImage->orderkey);
                    self::setImageOrderKey($lastImage->id, $image->orderkey);
                }
                return;
            }
            $lastImage = $image;
        }
    }
    
    static function moveImageDown ($id) {
        $theImage = self::getImage($id);
        $images = self::getImages($theImage->categoryid);
        $swapImage = null;
        foreach ($images as $image) {
            if ($swapImage != null) {
                self::setImageOrderKey($id, $image->orderkey);
                self::setImageOrderKey($image->id, $swapImage->orderkey);
                return;
            } else {
                if ($image->id == $id) {
                    $swapImage = $image;
                }
            }
        }
    }
    
    static function moveCategoryUp ($id) {
        $theCategory = self::getCategory($id);
        $categories = self::getImages($theCategory->parent);
        $lastCategory = null;
        foreach ($categories as $category) {
            if ($category->id == $id) {
                if ($lastCategory != null) {
                    self::setCategoryOrderKey($id, $lastCategory->orderkey);
                    self::setCategoryOrderKey($lastCategory->id, $category->orderkey);
                }
                return;
            }
            $lastCategory = $category;
        }
    }
    
    static function moveCategoryDown ($id) {
        $theCategory = self::getCategory($id);
        $categories = self::getCategorys($theCategory->parent);
        $swapCategory = null;
        foreach ($categories as $category) {
            if ($swapCategory != null) {
                self::setCategoryOrderKey($id, $category->orderkey);
                self::setCategoryOrderKey($category->id, $swapCategory->orderkey);
                return;
            } else {
                if ($category->id == $id) {
                    $swapCategory = $category;
                }
            }
        }
    }

    // acces
    
    static function getUserGallery ($userId) {
        return self::getGallery($userId, self::type_user);
    }
    
    static function getPageGallery ($moduleId) {
        return self::getGallery($moduleId, self::type_module);
    }
    
    static function getGallery ($theId, $galleryType) {
        $moduleId = mysql_real_escape_string($theId);
        $galleryType = mysql_real_escape_string($galleryType);
        $gallery = Database::queryAsObject("select * from t_gallery_page where typeid = '$moduleId' and type = '$galleryType'");
        if ($gallery == null) {
            $rootCategory = GalleryModel::createCategory("root_$moduleId", "root_$moduleId", null, null);
            Database::query("insert into t_gallery_page (typeid,type,rootcategory) values('$moduleId','$galleryType','$rootCategory')");
            return GalleryModel::getGallery($theId, $galleryType);
        }
        return $gallery;
    }
    
    static function getCategory ($id) {
        $id = mysql_real_escape_string($id);
        $result = Database::query("
                select c.*, i.image as filename 
                from t_gallery_category c 
                left join t_gallery_image i on c.image = i.id 
                where c.id='$id'");
        return mysql_fetch_object($result);
    }

    static function getImage ($id) {
        $id = mysql_real_escape_string($id);
        $result = Database::query("select * from t_gallery_image where id='$id'");
        return mysql_fetch_object($result);
    }

    static function getCategorys ($parent=null) {
        if ($parent == null) {
            return Database::queryAsArray("select c.*, c.parent, i.image as filename 
            from t_gallery_category c 
            left join t_gallery_image i on c.image = i.id order by c.orderkey");
        } else {
            $parent = mysql_real_escape_string($parent);
            return Database::queryAsArray("select c.*, c.parent, i.image as filename 
                from t_gallery_category c 
                left join t_gallery_image i on c.image = i.id 
                where c.parent = '$parent' order by c.orderkey");
        }
        
        
    }
    
    // crete update delete

    static function createCategory ($title, $description, $image, $parent) {
        $title = mysql_real_escape_string($title);
        $image = mysql_real_escape_string($image);
        $description = mysql_real_escape_string($description);
        $nextOrderKey = GalleryModel::getNextCategoryOrderKey();
        if ($parent == null) {
            $parent = "null";
        } else {
            $parent = "'".mysql_real_escape_string($parent)."'";
        }
        Database::query("INSERT INTO t_gallery_category(title,image,parent,orderkey,description) VALUES('$title','$image',$parent,'$nextOrderKey','$description');");
        $result = Database::query("SELECT LAST_INSERT_ID() as lastid");
        return mysql_fetch_object($result)->lastid;
    }
    
    static function updateCategory ($id, $title, $image, $description) {
        $id = mysql_real_escape_string($id);
        $title = mysql_real_escape_string($title);
        $image = mysql_real_escape_string($image);
        $description = mysql_real_escape_string($description);
        Database::query("update t_gallery_category set title='$title', image='$image', description='$description' where id='$id'");
    }
    
    static function deleteCategory ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_gallery_category where id = '$id';");
    }
    
    static function getImageCount ($category) {
        $category = mysql_real_escape_string($category);
        $handle = Database::query("select count(id) as count from t_gallery_image where categoryid = '$category'");
        $row = mysql_fetch_array($handle);
        return $row['count'];
    }
    
    static function getImages ($category) {
        $category = mysql_real_escape_string($category);
        return Database::queryAsArray("select * from t_gallery_image where categoryid = '$category' order by orderkey");
    }

    static function getImagesInRange ($category, $startIndex, $endIndex) {
        $images = GalleryModel::getImages($category);
        $ret = array();
        for ($i=$startIndex; $i<$endIndex; $i++) {
                $ret[] = $images[$i];
        }
        return $ret;
    }
    
    
    static function deleteImage ($id) {
        $id = mysql_escape_string($id);
        Database::query("delete from t_gallery_image where id = '$id'");
    }
    
    function updateImage ($id, $title, $image, $description) {
        $id = mysql_real_escape_string($id);
        $title = mysql_real_escape_string($title);
        $image = mysql_real_escape_string($image);
        $description = mysql_real_escape_string($description);
        Database::query("update t_gallery_image set title='$title' image='$image' description='$description' where id='$id'");
    }
    
    static function addImage ($categoryId,$imageName,$title,$description) {
        $categoryId = mysql_escape_string($categoryId);
        $imageName = mysql_escape_string($imageName);
        $title = mysql_escape_string($title);
        $description = mysql_escape_string($description);
        $orderKey = GalleryModel::getNextImageOrderKey();
        $query = "insert into t_gallery_image (image,categoryid,orderkey,title,description) values('$imageName','$categoryId','$orderKey','$title','$description')";
        Database::query($query);
    }
    
    
    
    static function cropImage ($imageFile,$width,$height,$outputFile) {
		
        $img = imagecreatetruecolor($width,$height);
        $org_img = imagecreatefromjpeg($imageFile);
        $ims = getimagesize($imageFile);

        if ($ims[0] > $img[1]) {
            $ratio = $ims[0] / $ims[1];
            $srcw = $ims[0] / $ratio;
            $srch = $ims[1];
            $srcx = ($ims[0] - $srcw) / 2;
            $srcy = 0;
        } else {
            $ratio = $ims[1] / $ims[0];
            $srcw = $ims[0];
            $srch = $ims[1] / $ratio;
            $srcx = 0;
            $srcy = ($ims[1] - $srch) / 2;
        }

        imagecopyresampled($img,$org_img, 0, 0, $srcx, $srcy, $width, $height, $srcw, $srch);
        imagejpeg($img,$outputFile,90);
        imagedestroy($img);
    }
    
    static function uploadImage ($inputName,$category) {
        
        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array("jpeg", "jpg", "png", "gif");
        // max file size in bytes
        $sizeLimit = 5 * 1024 * 1024;

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload(ResourcesModel::getResourcePath("gallery/new"));
        
        // create preview image
        $handle = opendir(ResourcesModel::getResourcePath("gallery/new"));
        while (false !== ($file = readdir($handle))) {
            if ($file == "." || $file == "..") {
                continue;
            }
            $filename = substr($file, strrpos($file, "/"));
            copy(ResourcesModel::getResourcePath("gallery/new",$filename), ResourcesModel::getResourcePath("gallery",$filename));
            GalleryModel::cropImage(ResourcesModel::getResourcePath("gallery",$filename),170,170,ResourcesModel::getResourcePath("gallery/small",$filename));
            GalleryModel::cropImage(ResourcesModel::getResourcePath("gallery",$filename),50,50,ResourcesModel::getResourcePath("gallery/tiny",$filename));
            
            unlink(ResourcesModel::getResourcePath("gallery/new",$filename));
            GalleryModel::addImage($category,$filename,"","");
        }
        
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        
    }
    
    function getUploadedImages () {
        return $_SESSION["gallery.upload.files"];
    }
    
    function clearUploadedImages () {
        $_SESSION["gallery.upload.files"] = array();
    }
	
    function createManyImages () {

        $MAXIMUM_FILESIZE = 25 * 1024 * 1024;

        // move uploaded file if safe
        $zipFile;
        $isFile = is_uploaded_file($_FILES['zipfile']['tmp_name']);
        if ($isFile) {
            $safe_filename = preg_replace(array("/\s+/", "/[^-\.\w]+/"), array("_", ""), trim($_FILES['zipfile']['name']));
            if ($_FILES['zipfile']['size'] <= $MAXIMUM_FILESIZE) {
                $zipFile = '/kunden/217182_81247/rp-hosting/5/5/www/images/gallery/'.$safe_filename;
                $isMove = move_uploaded_file($_FILES['zipfile']['tmp_name'],$zipFile);
            } else {
                echo "file larger than maximum file size ($MAXIMUM_FILESIZE MB)<br/>";
            }
        } else {
            echo "Error uploading file sorry<br/>";
        }
        // read each file in the zip
        $root = $_SERVER['DOCUMENT_ROOT'];
        $zip = zip_open($root."images/gallery/");
        while($zip_icerik = zip_read($zip)) {

            // extract it
            $zip_dosya = zip_entry_name($zip_icerik);
            if(strpos($zip_dosya, '.')) {

                // validate before writing the file
                $MAXIMUM_FILESIZE = 5 * 1024 * 1024;
                $rEFileTypes = "/^\.(jpg|jpeg|gif|png){1}$/i";
                if (preg_match($rEFileTypes, strrchr($imageName, '.'))) {
                    // write the file
                    $hedef_yol = $root.'images/gallery/'.$zip_dosya;
                    touch($hedef_yol);
                    $yeni_dosya = fopen($hedef_yol, 'w+');
                    fwrite($yeni_dosya, zip_entry_read($zip_icerik));
                    fclose($yeni_dosya);
                    // add it to the database
                    $position = GalleryModel::getNextImageOrderKey();
                    $imageName = $position."_".$zip_dosya;
                    $imageName = mysql_escape_string($imageName);
                    $DB = new MySQLDB();
                    $query = "insert into gallery(contentid,position,filename) values('$this->contentId','$position','$imageName')";
                    Database::query($query, $DB->handle);
                    $DB->Close();

                    // create preview image
                    $this->cropImage('/kunden/217182_81247/rp-hosting/5/5/www/images/gallery/'.$imageName,170,170,'/kunden/217182_81247/rp-hosting/5/5/www/images/gallery/small/'.$imageName);

                } else {
                    echo "invalid filetype allowed filetypes are jpg jpeg gif png<br/>";
                }
            } else {
                @mkdir($root.'images/gallery/'.$zip_dosya);
            }
        }
    }
}

?>