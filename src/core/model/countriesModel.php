<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of codeModel
 *
 * @author vbms
 */
class CountryModel {
    
    static function getCountry ($countryId) {
        $countryId = mysql_real_escape_string($countryId);
        return Database::queryAsObject("select * from t_country where id = '$countryId'");
    }
    
    static function getCountryByGeonameId ($geonameId) {
        $geonameId = mysql_real_escape_string($geonameId);
        return Database::queryAsObject("select * from t_country where geonameid = '$geonameId'");
    }
    
    static function getCountries () {
        $countries = Database::queryAsArray("select * from t_country order by name asc","geonameid");
        if (empty($countries)) {
            self::updateCountriesList();
            $countries = self::getCountries();
        }
        return $countries;
    }
    
    static function saveCountry ($name, $geonameId) {
        $name = mysql_real_escape_string($name);
        $geonameId = mysql_real_escape_string($geonameId);
        $country = self::getCountryByGeonameId($geonameId);
        if (empty($country)) {
            Database::query("insert into t_country (name,geonameid) values('$name','$geonameId')");
        } else {
            Database::query("update t_country set name = '$name' where geonameid = '$geonameId'");
        }
    }
    
    static function updateCountriesList () {
        
        $continentsCode = "6295630";
        $geoDataUrl = "http://www.geonames.org/childrenJSON?geonameId=";
        
        $continentsJson = Http::getContent($geoDataUrl.$continentsCode);
        $continents = json_decode($continentsJson);
        foreach ($continents->geonames as $continent) {
            
            $countriesJson = Http::getContent($geoDataUrl.$continent->geonameId);
            $countries = json_decode($countriesJson);
            
            foreach ($countries->geonames as $country) {
                
                self::saveCountry($country->name,$country->geonameId);
            }
        }
        
    }
}

?>