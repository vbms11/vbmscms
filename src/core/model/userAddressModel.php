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
    
    static function validate ($continent, $continentId, $country, $countryId, $state, $stateId, $region, $regionId, $city, $cityId, $address, $postcode) {
        
        $messages = array();
        
        if (empty($continent) || empty($continentId)) {
            $messages['continent'] = "invalid country";
        }
        
        if (empty($country) || empty($countryId)) {
            $messages['country'] = "this feild is required!";
        }
        
        if (empty($state) || empty($stateId)) {
            $messages['state'] = "this feild is required!";
        }
        
        if (empty($region) || empty($regionId)) {
            $messages['region'] = "this feild is required!";
        }
        
        if (empty($city) || empty($cityId)) {
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
    
    static function updateCoordinates ($addressId, $x, $y) {
        $address = self::getUserAddress($addressId);
        $str_address = $address->country." ".$address->city." ".$address->address;
        // $coordinates = self::getCoordinatesFromAddress($str_address);
	$coordinates = null;
	$coordinates->x = $x;
	$coordinates->y = $y;
        
        $radiusOfEarthKM = 6371;
        $x = (sin(deg2rad($coordinates->x)) * cos(deg2rad($coordinates->y))) * $radiusOfEarthKM;
        $y = (cos(deg2rad($coordinates->x)) * cos(deg2rad($coordinates->y))) * $radiusOfEarthKM;
        $z = sin(deg2rad($coordinates->y)) * $radiusOfEarthKM;
        
        $x = mysql_real_escape_string($x);
        $y = mysql_real_escape_string($y);
        $z = mysql_real_escape_string($z);
        $latitude = mysql_real_escape_string($coordinates->x);
        $longditude = mysql_real_escape_string($coordinates->y);
        $addressId = mysql_real_escape_string($addressId);
        
        Database::query("update t_user_address set
            latitude = '$latitude', 
            longditude = '$longditude',
            vectorx = '$x', 
            vectory = '$y', 
            vectorz = '$z' 
            where id = '$addressId'");
    }
    
    static function getUserAddress ($addressId) {
        $addressId = mysql_real_escape_string($addressId);
        return Database::queryAsObject("select * from t_user_address where id = '$addressId'");
    }
    
    static function getUserAddressByUserId ($userId) {
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsObject("select * from t_user_address where userid = '$userId'");
    }
    
    static function createUserAddress ($userId, $continent, $continentId, $country, $countryId, $state, $stateId, $region, $regionId, $city, $cityId, $address, $postcode, $x, $y) {
        $userId = mysql_real_escape_string($userId);
        $continent = mysql_real_escape_string($continent);
        $continentId = mysql_real_escape_string($continentId);
        $country = mysql_real_escape_string($country);
        $countryId = mysql_real_escape_string($countryId);
        $state = mysql_real_escape_string($state);
        $stateId = mysql_real_escape_string($stateId);
        $region = mysql_real_escape_string($region);
        $regionId = mysql_real_escape_string($regionId);
        $city = mysql_real_escape_string($city);
        $cityId = mysql_real_escape_string($cityId);
        $address = mysql_real_escape_string($address);
        $postcode = mysql_real_escape_string($postcode);
        Database::query("insert into t_user_address (userid,continent,continentid,country,countryid,state,stateid,region,regionid,city,cityid,address,postcode) 
            values ('$userId', '$continent', '$continentId', '$country', '$countryId', '$state', '$stateId', '$region', '$regionId', '$city', '$cityId', '$address', '$postcode')");
        $userAddressId = Database::queryAsObject("select last_insert_id() as newid from t_user_address");
        self::updateCoordinates($userAddressId->newid, $x, $y);
        return $userAddressId->newid;
    }
    
    static function updateUserAddress ($userAddressId, $userId, $continent, $continentId, $country, $countryId, $state, $stateId, $region, $regionId, $city, $cityId, $address, $postcode, $x, $y) {
        $userAddressId = mysql_real_escape_string($userAddressId);
        $userId = mysql_real_escape_string($userId);
        $continent = mysql_real_escape_string($continent);
        $continentId = mysql_real_escape_string($continentId);
        $country = mysql_real_escape_string($country);
        $countryId = mysql_real_escape_string($countryId);
        $state = mysql_real_escape_string($state);
        $stateId = mysql_real_escape_string($stateId);
        $region = mysql_real_escape_string($region);
        $regionId = mysql_real_escape_string($regionId);
        $city = mysql_real_escape_string($city);
        $cityId = mysql_real_escape_string($cityId);
        $address = mysql_real_escape_string($address);
        $postcode = mysql_real_escape_string($postcode);
        Database::query("update t_user_address set
            userid = '$userId',
            continent = '$continent',
            continentid = '$continentId',
            country = '$country',
            countryid = '$countryId',
            state = '$state',
            stateid = '$stateId',
            region = '$region',
            regionid = '$regionId',
            city = '$city',
            cityid = '$cityId',
            address = '$address',
            postcode = '$postcode
            where id = '$userAddressId'");
        self::updateCoordinates($userAddressId, $x, $y);
    }
    
    static function deleteUserAddress ($userAddressId) {
        $userAddressId = mysql_real_escape_string($userAddressId);
        Database::query("delete from t_user_address where id = '$userAddressId'");
    }
}

?>
