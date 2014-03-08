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
        
        $googleUrl = "maps.google.com/maps/api/geocode/json?sensor=false&address=".urlencode($address);
        $json = Http::getContent($googleUrl);
        
        if ($json != null) {
            $obj = json_decode($json);
        
            if ($obj['status'] == 'OK') {
                $location = $obj['results']['geometry']['location'];
                $coordinates = array('x'=>$location['lat'],'y'=>$location['lng']);
            }
        }
        
        return $coordinates;
    }
    
    static function validate ($countryId, $city, $address, $postcode) {
        
        $messages = array();
        
        $country = CountriesModel::getCountry($countryId);
        if (empty($country)) {
            $messages['country'] = "invalid country";
        }
        
        if (strlen($city) < 1) {
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
    
    static function updateCoordinates ($addressId) {
        
    }
    
    static function createUserAddress () {
        
    }
    
    static function updateUserAddress () {
        
    }
    
    static function deleteUserAddress () {
        
    }
}

?>
