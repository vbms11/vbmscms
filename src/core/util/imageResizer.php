<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class ImageResizer {








    function _ckdir($fn) {
        if (strpos($fn,"/") !== false) {
            $p=substr($fn,0,strrpos($fn,"/"));
            if (!is_dir($p)) {
                _o("Mkdir: ".$p);
                mkdir($p,777,true);
            }
        }
    }
    function resize($srcPath,$dstPath,$w,$h) {
        /* v2.5 with auto crop */
        $quality = 100;

        $r=1;
        $e=strtolower(substr($srcPath,strrpos($srcPath,".")+1,3));
        if (($e == "jpg") || ($e == "peg")) {
            $OldImage=ImageCreateFromJpeg($srcPath) or $r=0;
        } elseif ($e == "gif") {
            $OldImage=ImageCreateFromGif($srcPath) or $r=0;
        } elseif ($e == "bmp") {
            $OldImage=ImageCreateFromwbmp($srcPath) or $r=0;
        } elseif ($e == "png") {
            $OldImage=ImageCreateFromPng($srcPath) or $r=0;
        } else {
            echo "Not a Valid Image! (".$e.") -- ".$srcPath;
            $r=0;
        }
        if ($r) {
            $dim = getimagesize($srcPath);
            $width = $dim[0];
            $height = $dim[1];
            // check if ratios match
            $_ratio=array($width/$height,$w/$h);
            if ($_ratio[0] != $_ratio[1]) { // crop image

                // find the right scale to use
                $_scale=min((float)($width/$w),(float)($height/$h));

                // coords to crop
                $cropX=(float)($width-($_scale*$w));
                $cropY=(float)($height-($_scale*$h));

                // cropped image size
                $cropW=(float)($width-$cropX);
                $cropH=(float)($height-$cropY);

                $crop=ImageCreateTrueColor($cropW,$cropH);
                // crop the middle part of the image to fit proportions
                ImageCopy(
                    $crop,
                    $OldImage,
                    0,
                    0,
                    (int)($cropX/2),
                    (int)($cropY/2),
                    $cropW,
                    $cropH
                );
            }

            // do the thumbnail
            $NewThumb=ImageCreateTrueColor($w,$h);
            if (isset($crop)) { // been cropped
                ImageCopyResampled(
                    $NewThumb,
                    $crop,
                    0,
                    0,
                    0,
                    0,
                    $w,
                    $h,
                    $cropW,
                    $cropH
                );
                ImageDestroy($crop);
            } else { // ratio match, regular resize
                ImageCopyResampled(
                    $NewThumb,
                    $OldImage,
                    0,
                    0,
                    0,
                    0,
                    $w,
                    $h,
                    $width,
                    $height
                );
            }
            ImageJpeg($NewThumb,$dstPath,$quality);
            ImageDestroy($NewThumb);
            ImageDestroy($OldImage);
        }
        return $r;
    }

}

?>