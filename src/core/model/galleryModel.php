<?php

class GalleryModel {
    
    const type_user = 1;
    const type_module = 2;
    
    const tinyWidth = 50;
    const tinyHeight = 50;
    const smallWidth = 170;
    const smallHeight = 170;
    const bigWidth = 1000;
    const bigHeight = 1000;
    
    // ordering
    
    static function getNextImageOrderKey () {
        $result = Database::queryAsObject("select max(orderkey) as max from t_gallery_image");
        return $result->max + 1;
    }
    
    static function getNextCategoryOrderKey () {
        $result = Database::queryAsObject("select max(orderkey) as max from t_gallery_category");
        return $result->max + 1;
    }

    static function setImageOrderKey ($id, $orderKey) {
        $id = Database::escape($id);
        $orderKey = Database::escape($orderKey);
        Database::query("update t_gallery_image set orderkey='$orderKey' where id='$id'");
    }
    
    static function setCategoryOrderKey ($id, $orderKey) {
        $id = Database::escape($id);
        $orderKey = Database::escape($orderKey);
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
        $moduleId = Database::escape($theId);
        $galleryType = Database::escape($galleryType);
        $gallery = Database::queryAsObject("select * from t_gallery_page where typeid = '$moduleId' and type = '$galleryType'");
        if ($gallery == null) {
            $rootCategory = GalleryModel::createCategory("root_$moduleId", "root_$moduleId", null, null);
            Database::query("insert into t_gallery_page (typeid,type,rootcategory) values('$moduleId','$galleryType','$rootCategory')");
            return GalleryModel::getGallery($theId, $galleryType);
        }
        return $gallery;
    }
    
    static function getCategory ($id) {
        $id = Database::escape($id);
        return Database::queryAsArray("
                select c.*, i.image as filename 
                from t_gallery_category c 
                left join t_gallery_image i on c.image = i.id 
                where c.id='$id'");
    }

    static function getImage ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_gallery_image where id='$id'");
    }

    static function getCategorys ($parent=null) {
        if ($parent == null) {
            return Database::queryAsArray("select c.*, c.parent, i.image as filename 
            from t_gallery_category c 
            left join t_gallery_image i on c.image = i.id order by c.orderkey");
        } else {
            $parent = Database::escape($parent);
            return Database::queryAsArray("select c.*, c.parent, i.image as filename 
                from t_gallery_category c 
                left join t_gallery_image i on c.image = i.id 
                where c.parent = '$parent' order by c.orderkey");
        }
        
        
    }
    
    // crete update delete

    static function createCategory ($title, $description, $image, $parent) {
        $title = Database::escape($title);
        $image = Database::escape($image);
        $description = Database::escape($description);
        $nextOrderKey = GalleryModel::getNextCategoryOrderKey();
        if ($parent == null) {
            $parent = "null";
        } else {
            $parent = "'".Database::escape($parent)."'";
        }
        Database::query("INSERT INTO t_gallery_category(title,image,parent,orderkey,description) VALUES('$title','$image',$parent,'$nextOrderKey','$description');");
        $result = Database::queryAsObject("SELECT max(id) as lastid");
        return $result->lastid;
    }
    
    static function updateCategory ($id, $title, $image, $description) {
        $id = Database::escape($id);
        $title = Database::escape($title);
        $image = Database::escape($image);
        $description = Database::escape($description);
        Database::query("update t_gallery_category set title='$title', image='$image', description='$description' where id='$id'");
    }
    
    static function deleteCategory ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_gallery_category where id = '$id';");
    }
    
    static function getImageCount ($category) {
        $category = Database::escape($category);
        $handle = Database::query("select count(id) as count from t_gallery_image where categoryid = '$category'");
        $row = mysql_fetch_array($handle);
        return $row['count'];
    }
    
    static function getImages ($category) {
        $category = Database::escape($category);
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
        $id = Database::escape($id);
        $image = self::getImage($id);
        unlink(ResourcesModel::getResourcePath("gallery",$image->image));
        unlink(ResourcesModel::getResourcePath("gallery/small",$image->image));
        unlink(ResourcesModel::getResourcePath("gallery/tiny",$image->image));
        Database::query("delete from t_gallery_image where id = '$id'");
    }
    
    function updateImage ($id, $title, $image, $description) {
        $id = Database::escape($id);
        $title = Database::escape($title);
        $image = Database::escape($image);
        $description = Database::escape($description);
        Database::query("update t_gallery_image set title='$title' image='$image' description='$description' where id='$id'");
    }
    
    static function addImage ($categoryId,$imageName,$title,$description) {
        $categoryId = Database::escape($categoryId);
        $imageName = Database::escape($imageName);
        $title = Database::escape($title);
        $description = Database::escape($description);
        $orderKey = GalleryModel::getNextImageOrderKey();
        Database::query("insert into t_gallery_image (image,categoryid,orderkey,title,description) values('$imageName','$categoryId','$orderKey','$title','$description')");
        $newObj = Database::queryAsObject("select max(id) as newid from t_gallery_image");
        return $newObj->newid;
    }
    
    
    
    static function cropImage ($imageFile,$width,$height,$outputFile,$x=null,$y=null,$w=null,$h=null) {
	
        $pathInfo = pathinfo($imageFile);
        $ext = strtolower($pathInfo['extension']);
        
        $originalImage = null;
        $originalImageSize = null;
        
        switch ($ext) {
            case "jpeg":
            case "jpg":
                $originalImage = imagecreatefromjpeg($imageFile);
                $originalImageSize = getimagesize($imageFile);
                break;
            case "png":
                $originalImage = imagecreatefrompng($imageFile);
                $originalImageSize = getimagesize($imageFile);
                break;
            case "gif":
                $originalImage = imagecreatefromgif($imageFile);
                $originalImageSize = getimagesize($imageFile);
                break;
        }
        
        $image = imagecreatetruecolor($width,$height);
        
        if ($x == null && $y == null && $w == null && $h == null) {
            
            if ($originalImageSize[0] > $originalImageSize[1]) {
                $ratio = $originalImageSize[0] / $originalImageSize[1];
                $w = $originalImageSize[0] / $ratio;
                $h = $originalImageSize[1];
                $x = ($originalImageSize[0] - $w) / 2;
                $y = 0;
            } else {
                $ratio = $originalImageSize[1] / $originalImageSize[0];
                $w = $originalImageSize[0];
                $h = $originalImageSize[1] / $ratio;
                $x = 0;
                $y = ($originalImageSize[1] - $h) / 2;
            }
        }
        
        imagecopyresampled($image,$originalImage, 0, 0, $x, $y, $width, $height, $w, $h);
        imagejpeg($image,$outputFile,90);
        imagedestroy($image);
    }
    
    static function uploadImage ($inputName,$category) {
        
        $imageId = null;
        $allowedExtensions = array("jpeg", "jpg", "png", "gif");
        $sizeLimit = 5 * 1024 * 1024;
        
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload(ResourcesModel::getResourcePath("gallery/new"));
        
        if (isset($result['success']) && $result['success']) {
            
            $filename = $result['filename'];
            $newFilename = self::getNextFilename();
            $filePathFull = ResourcesModel::getResourcePath("gallery/new",$filename);
            
            self::cropImage($filePathFull,self::bigWidth,self::bigHeight,ResourcesModel::getResourcePath("gallery",$newFilename));
            self::cropImage($filePathFull,self::smallWidth,self::smallHeight,ResourcesModel::getResourcePath("gallery/small",$newFilename));
            self::cropImage($filePathFull,self::tinyWidth,self::tinyHeight,ResourcesModel::getResourcePath("gallery/tiny",$newFilename));
            
            $imageId = self::addImage($category,$newFilename,"","");
            
            unlink($filePathFull);
            unset($result['filename']);
        }
        
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        return $imageId;
    }
    
    static function getNextFilename ($ext = "jpg") {
        $filename = null;
        do {
            $filename = Common::randHash(32, false).".".$ext;
            $filename = Database::escape($filename);
            $result = Database::queryAsObject("select 1 as taken from t_gallery_image where image = '$filename'");
        } while (!empty($result) && $result->taken == "1");
        return $filename;
    }
    
    static function renderImage ($imageId,$width,$height,$x=null,$y=null,$w=null,$h=null) {
        
        $image = self::getImage($imageId);
        
        if (!empty($image)) {
            
            $image = $image->image;
            
            $filename = $width.'_'.$height.'_'.$x.'_'.$y.'_'.$w.'_'.$h.'_'.$imageId.'.jpg';
            $filePath = ResourcesModel::getResourcePath("gallery/crop",$filename);
            
            if (!is_file($filePath)) {
                
                $originalImage = ResourcesModel::getResourcePath("gallery",$image);
                self::cropImage($originalImage,$width,$height,$filePath,$x,$y,$w,$h);
            }
            
            // header('Content-Description: File Transfer');
            // header('Content-Type: application/octet-stream');
            header("Content-Type: image/jpg");
            header('Content-Disposition: inline; filename="'.$filename.'"');
            //header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            //header('Pragma: public');
            header('Content-Length: '.filesize($filePath));
            readfile($filePath);
            Context::setReturnValue("");
        }
        
    }
    
}

?>