<?php

class Captcha {
    
    static function getCaptcha ($inputName) {
	if (isset($_SESSION['captcha.'.$inputName])) {
            return $_SESSION['captcha.'.$inputName];
        }
	$captcha;
	$captcha->answer = Captcha::createAnswer(7);
	$captcha->key = Common::hash(strtolower($captcha->answer));
	$captcha->inputName = "captcha_".Common::rand();
	$_SESSION['captcha.'.$inputName] = $captcha;
        return $captcha;
    }
    
    static function loadFont () {
        $im = imagecreatetruecolor($width, $height);
	$transparent=imagecolorallocatealpha($im, 255, 255, 255, 127);
	imagefill($im,0,0,$transparent);

	// Replace path by your own font path
	$font = "OptimusPrinceps.ttf";
	// The text to draw
	$text = 'Testing...';
	// Replace path by your own font path
	$font = 'arial.ttf';
	// Create black color
	$black = imagecolorallocate($im, 0, 0, 0);
	//Get image from text
	imagettftext($im, 14, 0, 10, 20, $black, $font, $text);
        
        //rotate the image
	// $im=imagerotate($im, $degrees, 0);
        
        //create the image with transparent background
	

    }
    
    static function createImage ($inputName) {
	
        $captcha = Captcha::getCaptcha($inputName);
        
        // create image
        $width = 163;
        $height = 40;
        $fakeColor_r = 225;
        $fakeColor_g = 225;
        $fakeColor_b = 225;
        $img = imagecreate ($width,$height);
        $background = ImageColorAllocate ($img, 230, 230, 240);
        $fakecoloroffset = 60;
        $colors = array(
            ImageColorAllocate ($img, 0, 0, 0),
            ImageColorAllocate ($img, 120, 0, 0),
            ImageColorAllocate ($img, 0, 0, 120),
            ImageColorAllocate ($img, 0, 120, 0)
	);
        
        $countColors = count($colors);
        
        $maxHorizontalDisplace = 1;
        $maxVerticalDisplace = 12;
        $characterSpaceing = 21;
        $posx = 10;
        $posy = 14;
        $font = 20;
        
        
        
        // create lines on image
        $lines = 30;
        $cntLines = 0;
        $face = null;
        $pos1; $pos2;
        while ($cntLines < $lines) {
            $f = Common::rand() % 4;
            if ($f == $face) {
                continue;
            } else if ($face == null) {
                $face = $f;
            } else {
                $pos1 = Captcha::getPosOnBorder($f,$width,$height);
                $pos2 = Captcha::getPosOnBorder($face,$width,$height);
                imageline($img, $pos1[0], $pos1[1], $pos2[0], $pos2[1], $colors[Common::rand() % $countColors]);
                $face = null;
                $cntLines++;
            }
        }
        
        // create characters invisible to the human eye
        for ($i=0; $i<200; $i++) {
            
            $char = Common::randHash(1);
            $fakeColor = ImageColorAllocate ($img, $fakeColor_r-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset), $fakeColor_g-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset), $fakeColor_b-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset));
            ImageString($img, $font, Common::rand()%$width-3, Common::rand()%$height-5, strtoupper("$char"), $fakeColor);
            
        }

        // print the answer
        for ($i=0; $i<strlen($captcha->answer); $i++) {
            
            $char = substr($captcha->answer, $i, 1);
            $charXPos = floor($posx + (Common::rand() % $maxHorizontalDisplace));
            $charYPos = 4+floor($posy + (Common::rand() % $maxVerticalDisplace) + ($maxVerticalDisplace / 2));
            imagettftext($img, 20, 0, $charXPos, $charYPos, $colors[Common::rand() % $countColors], ResourcesModel::getBasePath()."resource/css/fonts/OptimusPrinceps.ttf", $char);
            $posx += $characterSpaceing;
            
        }
	
        // render and send the image
        header("Content-Type: image/gif");
        ImageGif ($img);
        ImageDestroy ($img);
        Context::returnValue("");
    }
    
    static function createAnswer ($anserLen) {
	$chars = array("A","C","D","E","F","G","H","K","L","M","N","P","R","T","U","V","W","X","Y","Z","2","3","4","6","7","9");
	$charsCount = count($chars);
	$answer = "";
	for ($i=0; $i<$anserLen; $i++) {
		$answer .= $chars[Common::rand() % $charsCount];
	}
	return $answer;
    }
    
    static function getPosOnBorder ($f,$width,$height) {
        $pos = array();
        if ($f == 0 || $f == 2) {
            $pos[0] = Common::rand() % $width;
            if ($f == 0) {
                $pos[1] = 1;
            } else {
                $pos[1] = $height-1;
            }
        } else {
            $pos[1] = Common::rand() % $height;
            if ($f == 1) {
                $pos[0] = $width-1;
            } else {
                $pos[0] = 1;
            }
        }
        return $pos;
    }
    
    static function validateInput ($inputName) {
        $captcha = Captcha::getCaptcha($inputName);
        // validate the users input
        $valid = false;
        if (Common::hash(strtolower($_POST[$captcha->inputName."_answer"])) != $_POST[$captcha->inputName."_key"]) {
            $valid = false;
        } else {
            $valid = true;
        }
	unset($_SESSION['captcha.'.$inputName]);
        return $valid;
    }
}

?>