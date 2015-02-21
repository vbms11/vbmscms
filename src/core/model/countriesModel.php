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
    
	
	// continents
	
	static function getContinent ($continentId) {
		$continentId = mysql_real_escape_string($continentId);
		return Database::queryAsObject("select * from t_location_continent where id = '$continentId'");
	}
	
	static function getContinentByGeonameId ($geonameId) {
		$geonameId = mysql_real_escape_string($geonameId);
		return Database::queryAsObject("select * from t_location_continent where geonameid = '$geonameId'");
	}
	
	static function getContinents () {
		$continents = Database::queryAsArray("select * from t_location_continent order by name asc","geonameid");
		if (empty($continents)) {
			self::updateContinentsList();
			$continents = self::getContinents();
		}
		return $countries;
	}
	
	static function saveContinent ($name, $geonameId, $population, $lng, $lat) {
		$name = mysql_real_escape_string($name);
		$geonameId = mysql_real_escape_string($geonameId);
		$population = mysql_real_escape_string(population);
		$lng = mysql_real_escape_string($lng);
		$lat = mysql_real_escape_string($lat);
		$continent = self::getContinentByGeonameId($geonameId);
		if (empty($continent)) {
			Database::query("insert into t_location_continent (name,geonameid,population,lng,lat) values('$name','$geonameId','$population','$lng','$lat')");
		} else {
			Database::query("update t_location_continent set 
				name = '$name', 
				population = '$population', 
				lng = '$lng', 
				lat = '$lat'
				where geonameid = '$geonameId'");
		}
	}
	
	// countries
	
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
    
    static function saveCountry ($name, $geonameId, $population, $countryCode) {
        $name = mysql_real_escape_string($name);
        $geonameId = mysql_real_escape_string($geonameId);
        $population = mysql_real_escape_string(population);
        $countryCode = mysql_real_escape_string($countryCode);
        $country = self::getCountryByGeonameId($geonameId);
        if (empty($country)) {
            Database::query("insert into t_country (name,geonameid,population,countrycode) values('$name','$geonameId','$population','$countryCode')");
        } else {
            Database::query("update t_country set 
            	name = '$name', 
            	population = '$population', 
            	countrycode = '$countryCode' 
            	where geonameid = '$geonameId'");
        }
    }
    
    // states
    // regions
    // city
    
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
    
    static function updateCityList () {
    	
    }
}

?>