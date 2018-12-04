<?php

class PinboardModel {
	
	public $noteType_note = 1;
	public $noteType_placeInfo = 2;
	public $noteType_placeWiki = 3;
	public $noteType_placeNews = 4;
	public $noteType_advert = 5;
	
	static function validatePinboard ($name, $description, $icon) {
		
		$errors = array();
        if (strlen($name) == 0) {
            $errors["name"] = "This feild cannot be empty!";
        }
        if (strlen($name) > 100) {
            $errors["comment"] = "Maximum 100 characters allowed!";
        }
        
        if (strlen($description) == 0) {
            $errors["name"] = "This feild cannot be empty!";
        }
        if (strlen($description) > 1000) {
            $errors["comment"] = "Maximum 1000 characters allowed!";
        }
        
        return $errors;
	}
	
	static function createPinboard ($name, $description, $iconId, $lat, $lng, $userId = null) {
		
		if (empty($userId)) {
			$userId = Context::getUserId();
		}
		
		$name = Database::escape($name);
		$description = Database::escape($description);
		$userId = Database::escape($userId);
		$iconId = Database::escape($iconId);
		$lat = Database::escape($lat);
		$lng = Database::escape($lng);
		
		Database::query("insert into t_pinboard (name, description, userid, iconid, lat, lng, createdate, updatedate)
			values ('$name', '$description', '$userId', '$iconId', '$lat', '$lng', now(), now())");
		
		$result = Database::queryAsObject("select max(id) as newid from t_pinboard");
		return $result->newid;
	}
	
	static function setPinboardLocation ($id, $lat, $lng) {
		
		$id = Database::escape($id);
		$lat = Database::escape($lat);
		$lng = Database::escape($lng);
		
		Database::query("update t_pinboard set
			lat = '$lat',
			lng = '$lng'
			where id = '$id'");
	}
	
	static function savePinboard ($id, $name, $description, $iconId) {
		
		$id = Database::escape($id);
		$name = Database::escape($name);
		$description = Database::escape($description);
		$iconId = Database::escape($iconId);
		
		Database::query("update t_pinboard set
			name = '$name',
			description = '$description',
			iconid = '$iconId', 
			updatedate = now() 
			where id = '$id'");
	}
	
	static function getPinboard ($id) {
		
		$id = Database::escape($id);
		
		return Database::queryAsObject("select * from t_pinboard where id = '$id'");
	}
	
	static function getPinbords ($minLng, $minLat, $maxLng, $maxLat, $max=100) {
		
		$minLng = Database::escape($minLng);
		$minLat = Database::escape($minLat);
		$maxLng = Database::escape($maxLng);
		$maxLat = Database::escape($maxLat);
		$max = (int) $max;
		
		return Database::queryAsArray("select p.*, i.iconfile, i.width, i.height from t_pinboard p 
			join t_icon i on p.iconid = i.id 
			where p.lng > '$minLng' and p.lat > '$minLat' and p.lng < '$maxLng' and p.lat < '$maxLat' 
			limit $max");
	}
	
	static function validateNote ($message, $pinboardId, $type, $typeId, $userId, $x, $y) {
		
		$errors = array();
		if (strlen($message) == 0) {
            $errors["message"] = "This feild cannot be empty!";
        }
        if (strlen($message) > 10000) {
            $errors["message"] = "Maximum 10000 characters allowed!";
        }
        
        $pinboard = self::getPinboard($pinboardId);
        if (empty($pinboard)) {
        	$errors["pinboard"] = "This pinboard dose not exist!";
        }
        
		return $errors;
	}
	
	static function createNote ($message, $pinboardId, $type, $typeId, $userId, $x, $y) {
		
		$message = Database::escape($message);
		$pinboardId = Database::escape($pinboardId);
		$type = Database::escape($type);
		$typeId = Database::escape($typeId);
		$userId = Database::escape($userId);
		$x = Database::escape($x);
		$y = Database::escape($y);
		
		Database::query("insert into t_pinboard_note (message, pinboardid, type, typeid, userid, x, y, createdate)
			values ('$message', '$pinboardId', '$type', '$typeId', '$userId', '$x', '$y', now())");
		
		$result = Database::queryAsObject("select max(id) as newid from t_pinboard_note");
		return $result->newid;
	}
	
	static function setNotePosition ($noteId, $x, $y) {
		
		$noteId = Database::escape($noteId);
		$x = Database::escape($x);
		$y = Database::escape($y);
		
		Database::query("update t_pinboard_note set 
			x = '$x', 
			y = '$y' 
			where id = '$noteId'");
	}
	
	static function saveNote ($noteId, $message) {
		
		$noteId = Database::escape($noteId);
		$message = Database::escape($message);
		
		Database::query("update t_pinboard_note set 
			message = '$message' 
			where id = '$noteId'");
	}
	
	static function getNotes ($pinboardId, $max=100) {
		
		$pinboardId = Database::escape($pinboardId);
		$max = (int) $max;
		
		return Database::queryAsArray("select * from t_pinboard_note where pinboardid = '$pinboardId' limit $max");
	}
	
	static function getNote ($id) {
	
		$id = Database::escape($id);
	
		return Database::queryAsObject("select * from t_pinboard_note where id = '$id'");
	}
	
	static function deleteNote ($noteId) {
		
		$noteId = Database::escape($noteId);
		
		Database::query("delete from t_pinboard_note where id = '$noteId'");
	}
	
	
}

?>