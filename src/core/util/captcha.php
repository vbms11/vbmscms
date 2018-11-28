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
        
        $img = imagecreatetruecolor($width,$height);
        
        $background = imagecolorallocate($img, 230, 230, 240);
        imagefilledrectangle($img, 0, 0, $width , $height, $background);
        
        $fakecoloroffset = 60;
        $colors = array(
            imagecolorallocate($img, 0, 0, 0),
            imagecolorallocate($img, 120, 0, 0),
            imagecolorallocate($img, 0, 0, 120),
            imagecolorallocate($img, 0, 120, 0)
		);
        
        $countColors = count($colors);
        
        $maxHorizontalDisplace = 1;
        $maxVerticalDisplace = 12;
        $characterSpaceing = 22;
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
            $fakeColor = imagecolorallocate ($img, $fakeColor_r-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset), $fakeColor_g-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset), $fakeColor_b-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset));
            imagestring($img, $font, Common::rand()%$width-3, Common::rand()%$height-5, strtoupper("$char"), $fakeColor);
            
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
        imagegif($img);
        imagedestroy($img);
        Context::setReturnValue("");
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
        if (!isset($_POST[$captcha->inputName."_answer"]) || !isset($_POST[$captcha->inputName."_key"])) {
            return false;
        }
        $answer = $_POST[$captcha->inputName."_answer"];
        $key = $_POST[$captcha->inputName."_key"];
        if (Common::hash(strtolower($answer)) == $key) {
            $valid = true;
        }
		unset($_SESSION['captcha.'.$inputName]);
        return $valid;
    }
    
    static function drawGradientText ($image, $text, $fontSize, $direction, $startColor, $endColor) {
        
        $textImageSize = 
        
        $factor = sqrt($width*$width+$height*$height);
        $directionNorm = [1/$factor*$direction[0],1/$factor*$direction[1]];
        
        // make gradient
        $startPos = [0,0];
        if ($directionNorm[0] == 0) {
            $startPos[0] = 0;
            $endPos[0] = 0;
        } if ($directionNorm[0] > 0) {
            $startPos[0] = 0;
            $endPos[0] = $textImageSize;
        } else if ($directionNorm[0] < 0) {
            $startPos[0] = [$textImageSize,0];
        }
        if ($direction[1] == 0) {
            $startPos[1] = 0;
            $endPos[1] = 0;
        } else if ($directionNorm[1] > 0) {
            $startPos[1];
            $endPos[1] = 0;
        } else if ($directionNorm[1] > 0) {
            $startPos[1] = $textImageSize;
        }
        
        $startPos = [];
        $endPos = [];
        
        $pixelColor;
        for ($y=0; $y<$fontSize; $y++) {
            for ($x=0; $x<$fontSize; $x++) {
                
            }
        }
        
        // write character
        $char = Common::randHash(1);
        $fakeColor = imagecolorallocate ($img, $fakeColor_r-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset), $fakeColor_g-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset), $fakeColor_b-($fakecoloroffset/2)+(Common::rand()%$fakecoloroffset));
        imagestring($img, $font, Common::rand()%$width-3, Common::rand()%$height-5, strtoupper("$char"), $fakeColor);
        
        // cut out character fron gradient
        
        // write to transparent image
        $im = imagecreatetruecolor(55, 30);
        $red = imagecolorallocate($im, 255, 0, 0);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagecolortransparent($im, $black);
    }
}

?>