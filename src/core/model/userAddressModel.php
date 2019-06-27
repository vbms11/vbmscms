<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userSearchModel
 *
 * @author Administrator
 */
class UserAddressModel {
    
    static function getCoordinatesFromAddress ($address) {
        
        $coordinates = null;
        
        $address = htmlentities($address);
        
        $googleUrl = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=".urlencode($address);
        $json = Http::getContent($googleUrl);
        
        if ($json != null) {
            $obj = json_decode($json);
        
            if ($obj->status == 'OK') {
                
                if (!empty($obj->results[0])) {
                    
                    $location = $obj->results[0]->geometry->location;
                    $coordinates->x = $location->lat;
                    $coordinates->y = $location->lng;
                }
            }
        }
        
        return $coordinates;
    }
    
    static function validate ($country, $city, $address, $postcode) {
        
        $messages = array();
        
        if (strlen(empty($country))) {
            $messages['country'] = "this feild is required!";
        }
        
        if (strlen(empty($city)) < 1) {
            $messages['city'] = "this feild is required!";
        }
        
        if (strlen($address) < 1) {
            $messages['address'] = "this feild is required!";
        }
        
        if (strlen($postcode) < 1) {
            $messages['postcode'] = "this feild is required!";
        }
        
        return $messages;
    }
    
    static function updateCoordinates ($addressId, $address) {
        $address = self::getUserAddress($addressId);
        $str_address = $address->country." ".$address->city." ".$address->address;
        $coordinates = self::getCoordinatesFromAddress($str_address);
	if ($coordinates != null) {
            $radiusOfEarthKM = 6371;
            $x = (sin(deg2rad($coordinates->x)) * cos(deg2rad($coordinates->y))) * $radiusOfEarthKM;
            $y = (cos(deg2rad($coordinates->x)) * cos(deg2rad($coordinates->y))) * $radiusOfEarthKM;
            $z = sin(deg2rad($coordinates->y)) * $radiusOfEarthKM;

            $x = Database::escape($x);
            $y = Database::escape($y);
            $z = Database::escape($z);
            $latitude = Database::escape($coordinates->x);
            $longditude = Database::escape($coordinates->y);
            $addressId = Database::escape($addressId);

            Database::query("update t_user_address set
                latitude = '$latitude', 
                longditude = '$longditude',
                vectorx = '$x', 
                vectory = '$y', 
                vectorz = '$z' 
                where id = '$addressId'");
        }
    }
    
    static function getUserAddress ($addressId) {
        $addressId = Database::escape($addressId);
        return Database::queryAsObject("select * from t_user_address where id = '$addressId'");
    }
    
    static function getUserAddressByUserId ($userId) {
        $userId = Database::escape($userId);
        return Database::queryAsObject("select * from t_user_address where userid = '$userId'");
    }
    
    static function createUserAddress ($userId, $country, $city, $address, $postcode) {
        $userId = Database::escape($userId);
        $country = Database::escape($country);
        $city = Database::escape($city);
        $address = Database::escape($address);
        $postcode = Database::escape($postcode);
        Database::query("insert into t_user_address (userid,country,city,address,postcode) 
            values ('$userId', '$country', '$city', '$address', '$postcode')");
        $userAddressId = Database::queryAsObject("select max(id) as newid from t_user_address");
        $coordinates = self::getCoordinatesFromAddress();
        if ($coordinates != null) {
            self::updateCoordinates($userAddressId->newid, "$country $city $postcode $address");
        }
        return $userAddressId->newid;
    }
    
    static function updateUserAddress ($userAddressId, $userId, $country, $city, $address, $postcode) {
        $userAddressId = Database::escape($userAddressId);
        $userId = Database::escape($userId);
        $country = Database::escape($country);
        $city = Database::escape($city);
        $address = Database::escape($address);
        $postcode = Database::escape($postcode);
        Database::query("update t_user_address set
            userid = '$userId',
            country = '$country',
            city = '$city',
            address = '$address',
            postcode = '$postcode
            where id = '$userAddressId'");
        self::updateCoordinates($userAddressId, "$country $city $postcode $address");
    }
    
    static function deleteUserAddress ($userAddressId) {
        $userAddressId = Database::escape($userAddressId);
        Database::query("delete from t_user_address where id = '$userAddressId'");
    }
}

?>
