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
    
	public $updateType_geonameId;
	public $updateType_googlePlaces;
	
	
	// continents
	
	static function getContinent ($continentId) {
		$continentId = mysql_real_escape_string($continentId);
		return Database::queryAsObject("select * from t_geo_continent where id = '$continentId'");
	}
	
	static function getContinentByGeonameId ($geonameId) {
		$geonameId = mysql_real_escape_string($geonameId);
		return Database::queryAsObject("select * from t_geo_continent where geonameid = '$geonameId'");
	}
	
	static function getContinents () {
		$continents = Database::queryAsArray("select * from t_geo_continent order by name asc","geonameid");
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
			Database::query("insert into t_geo_continent (name,geonameid,population,lng,lat) values('$name','$geonameId','$population','$lng','$lat')");
		} else {
			Database::query("update t_geo_continent set 
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
        return Database::queryAsObject("select * from t_geo_country where id = '$countryId'");
    }
    
    static function getCountryByGeonameId ($geonameId) {
        $geonameId = mysql_real_escape_string($geonameId);
        return Database::queryAsObject("select * from t_geo_country where geonameid = '$geonameId'");
    }
    
    static function getCountries () {
        $countries = Database::queryAsArray("select * from t_geo_country order by name asc","geonameid");
        if (empty($countries)) {
            self::updateCountriesList();
            $countries = self::getCountries();
        }
        return $countries;
    }
    
    static function saveCountry ($name, $longName, $geonameId, $population, $countryCode, $countryId, $lng, $lat) {
    	
        $name = mysql_real_escape_string($name);
        $longName = mysql_real_escape_string($longName);
        $geonameId = mysql_real_escape_string($geonameId);
        $population = mysql_real_escape_string(population);
        $countryCode = mysql_real_escape_string($countryCode);
        $countryId = mysql_real_escape_string($countryId);
		$lng = mysql_real_escape_string($lng);
		$lat = mysql_real_escape_string($lat);
		$continentId = mysql_real_escape_string($continentId);
		
		$country = self::getCountryByGeonameId($geonameId);
        if (empty($country)) {
            Database::query("insert into t_geo_country (name,longname,geonameid,population,countrycode,countryId,lng,lat,continentid) values('$name','$longName','$geonameId','$population','$countryCode','$countryId','$lng','$lat','$continentId')");
        } else {
            Database::query("update t_geo_country set 
            	name = '$name', 
            	longname = '$longName', 
            	population = '$population', 
            	countrycode = '$countryCode', 
            	countryid = '$countryId', 
            	lng = '$lng', 
            	lat = '$lat', 
            	continentid = '$continentId' 
            	where geonameid = '$geonameId'");
        }
    }
    
    // states
    
    static function getState ($stateId) {
        $stateId = mysql_real_escape_string($stateId);
        return Database::queryAsObject("select * from t_geo_state where id = '$stateId'");
    }
    
    static function getStateByGeonameId ($geonameId) {
        $geonameId = mysql_real_escape_string($geonameId);
        return Database::queryAsObject("select * from t_geo_state where geonameid = '$geonameId'");
    }
    
    static function getStates () {
        $states = Database::queryAsArray("select * from t_geo_state order by name asc","geonameid");
        return $states;
    }
    
    static function saveState ($name, $longName, $geonameId, $population, $countryId, $lng, $lat) {
    	 
    	$name = mysql_real_escape_string($name);
    	$longName = mysql_real_escape_string($longName);
    	$geonameId = mysql_real_escape_string($geonameId);
    	$population = mysql_real_escape_string(population);
    	$countryId = mysql_real_escape_string($countryId);
    	$lng = mysql_real_escape_string($lng);
    	$lat = mysql_real_escape_string($lat);
    
    	$country = self::getStateByGeonameId($geonameId);
    	if (empty($country)) {
    		Database::query("insert into t_geo_state (name,longname,geonameid,population,countryid,lng,lat) values('$name','$longName','$geonameId','$population','$countryId','$lng','$lat')");
    	} else {
    		Database::query("update t_geo_state set
    		name = '$name',
    		longname = '$longName',
    		population = '$population',
    		countryid = '$countryId',
    		lng = '$lng',
    		lat = '$lat'
    		where geonameid = '$geonameId'");
    	}
    }
    
    // regions
    
    static function getRegion ($regionId) {
        $regionId = mysql_real_escape_string($regionId);
        return Database::queryAsObject("select * from t_geo_region where id = '$regionId'");
    }
    
    static function getRegionByGeonameId ($geonameId) {
        $geonameId = mysql_real_escape_string($geonameId);
        return Database::queryAsObject("select * from t_geo_region where geonameid = '$geonameId'");
    }
    
    static function getRegions () {
        $regions = Database::queryAsArray("select * from t_geo_region order by name asc","geonameid");
        return $regions;
    }
    
    static function saveRegion($name, $longName, $geonameId, $population, $stateId, $lng, $lat) {
    	
    	$name = mysql_real_escape_string($name);
    	$longName = mysql_real_escape_string($longName);
    	$geonameId = mysql_real_escape_string($geonameId);
    	$population = mysql_real_escape_string(population);
    	$stateId = mysql_real_escape_string($stateId);
    	$lng = mysql_real_escape_string($lng);
    	$lat = mysql_real_escape_string($lat);
    	
    	$region = self::getRegionByGeonameId($geonameId);
    	if (empty($country)) {
    		Database::query("insert into t_geo_region (name,longname,geonameid,population,stateid,lng,lat) values('$name','$longName','$geonameId','$population','$stateId','$lng','$lat')");
    	} else {
    		Database::query("update t_geo_region set
    		name = '$name',
    		longname = '$longName',
    		population = '$population',
    		stateid = '$stateId',
    		lng = '$lng',
    		lat = '$lat'
    		where geonameid = '$geonameId'");
    	}
    	
    }

    // city
    
    static function getCity ($cityId) {
        $cityId = mysql_real_escape_string($cityId);
        return Database::queryAsObject("select * from t_geo_city where id = '$cityId'");
    }
    
    static function getCityByGeonameId ($geonameId) {
        $geonameId = mysql_real_escape_string($geonameId);
        return Database::queryAsObject("select * from t_geo_city where geonameid = '$geonameId'");
    }
    
    static function getCitys () {
        $citys = Database::queryAsArray("select * from t_geo_city order by name asc","geonameid");
        return $citys;
    }
    
    static function saveCity ($name, $longName, $geonameId, $population, $regionId, $lng, $lat) {
    	 
    	$name = mysql_real_escape_string($name);
    	$longName = mysql_real_escape_string($longName);
    	$geonameId = mysql_real_escape_string($geonameId);
    	$population = mysql_real_escape_string(population);
    	$regionId = mysql_real_escape_string($regionId);
    	$lng = mysql_real_escape_string($lng);
    	$lat = mysql_real_escape_string($lat);
    	 
    	$region = self::getCityByGeonameId($geonameId);
    	if (empty($country)) {
    		Database::query("insert into t_geo_city (name,longname,geonameid,population,region,lng,lat) values('$name','$longName','$geonameId','$population','$regionId','$lng','$lat')");
    	} else {
    		Database::query("update t_geo_city set
    		name = '$name',
    		longname = '$longName',
    		population = '$population',
    		stateid = '$stateId',
    		lng = '$lng',
    		lat = '$lat'
    		where geonameid = '$geonameId'");
    	}
    	 
    }
    
    static function savePlace ($type, $typeId) {
    	
    }
    
    
    protected $continentsCode = "6295630";
    protected $geoDataUrl = "http://www.geonames.org/childrenJSON?geonameId=";
    
    static function updateContinentList () {
    	
    	$continentsJson = Http::getContent($this->geoDataUrl.$this->continentsCode);
    	$continents = json_decode($continentsJson);
    	foreach ($continents->geonames as $continent) {
    		
    		self::saveContinent($country->name,$continent->geonameId);
    		
    	}
    }
    
    static function updateCountriesList () {
        
        $continentsJson = Http::getContent($this->geoDataUrl.$this->continentsCode);
        $continents = json_decode($continentsJson);
        foreach ($continents->geonames as $continent) {
            
            $countriesJson = Http::getContent($geoDataUrl.$continent->geonameId);
            $countries = json_decode($countriesJson);
            
            foreach ($countries->geonames as $country) {
                
            	self::saveCountry($country->name,$country->geonameId);
            }
        }
        
    }
    
    static function updateStateList ($country) {
    	
    	$continentsJson = Http::getContent($this->geoDataUrl.$country->geonameid);
    	$continents = json_decode($continentsJson);
    	foreach ($continents->geonames as $continent) {
    	
    		self::saveContinent($country->name,$continent->geonameId);
    	
    	}
    }
    
    static function updateRegionList ($country) {
    	
    	$continentsJson = Http::getContent($this->geoDataUrl.$country->geonameid);
    	$continents = json_decode($continentsJson);
    	foreach ($continents->geonames as $continent) {
    	
    		self::saveContinent($country->name,$continent->geonameId);
    	
    	}
    }
    
    static function updateCityList ($region) {
    	
    	$continentsJson = Http::getContent($this->geoDataUrl.$region->geonameid);
    	$continents = json_decode($continentsJson);
    	foreach ($continents->geonames as $continent) {
    	
    		self::saveContinent($country->name,$continent->geonameId);
    	
    	}
    }
    
    static function updatePlace ($type, $geonameId, $data) {
    	
    	// depending on type set feilds that have been updated
    	switch ($type) {
    		
    		case "continent":
    			
    			foreach ($data["geonames"] as $continent) {
    				self::saveContinent($continent->name, $continent->geonameId, $continent->population, $continent->lng, $continent->lat);
    			}
    			
    			break;
    		case "country":
    			
    			foreach ($data["geonames"] as $country) {
    				self::saveCountry($country->name, $country->toponymName, $country->geonameId, $country->population, $country->countryCode, $country->countryId, $country->lng, $country->lat);
    			}
    			
    			break;
    		case "state":
    			
    			foreach ($data["geonames"] as $state) {
    				self::saveState($state->name, $state->toponymName, $state->geonameId, $state->population, $data["geonameId"], $state->lng, $state->lat);
    			}
    			
    			break;
    		case "region":

    			foreach ($data["geonames"] as $region) {
    				self::saveRegion($region->name, $region->toponymName, $region->geonameId, $region->population, $data["geonameId"], $region->lng, $region->lat);
    			}
    			 
    			break;
    		case "city":
    			
    			foreach ($data["geonames"] as $city) {
    				self::saveCity($city->name, $city->toponymName, $city->geonameId, $city->population, $data["geonameId"], $city->lng, $city->lat);
    			}
    			
    			break;
    		
    	}
    	
    }
    
    static function getPlacesThatNeedUpdating ($amount, $type) {
    	
    	$update = array("status" => "none", "geonameIds" => array());
    	
    	$amount = mysql_real_escape_string($amount);
    	
    	// get places that need upting do we have each of them then what is missing?
    	
    	$continents = self::getContinents();
    	if (empty($continents)) {
    		$update["task"] = "geocodeId";
    		$update["type"] = "continent";
    		$update["geocodeIds"][] = 6295630;
    	} else {
    		 
    		// get continents that need updating
    		
    		$continents = Database::queryAsArray("select geonameid from t_geo_continent where collected = '0' and collection_scheduled = null limit '$amount'");
    		
    		if (!empty($continents)) {
    			
    			$update["type"] = "country";
    			foreach ($continents as $continent) {
    				$update["geocodeIds"][] = mysql_real_escape_string($continent->geonameid);
    			}
    			Database::query("update t_geo_continent set collection_scheduled = now() where geonameid in ('".implode("','",$update["geocodeIds"])."')");
    			
    		} else {
    			
    			// get countries that need updating
    			
    			$countries = Database::queryAsArray("select geonameid from t_geo_country where collected = '0' and collection_scheduled = null limit '$amount'");
    			
    			if (!empty($countries)) {
    				
    				$update["type"] = "state";
    				foreach ($countries as $country) {
    					$update["geocodeIds"][] = mysql_real_escape_string($country->geonameid);
    				}
    				Database::query("update t_geo_country set collection_scheduled = now() where geonameid in ('".implode("','",$update["geocodeIds"])."')");
    				
    			} else {
    				
    				// get states that need updating
    				
    				$states = Database::queryAsArray("select geonameid from t_geo_state where collected = '0' and collection_scheduled = null limit '$amount'");
    				
    				if (!empty($states)) {
    					
    					$update["type"] = "region";
    					foreach ($states as $state) {
    						$update["geocodeIds"][] = mysql_real_escape_string($state->geonameid);
    					}
    					Database::query("update t_geo_state set collection_scheduled = now() where geonameid in ('".implode("','",$update["geocodeIds"])."')");
    					
    				} else {
    					
    					// get regions that need updating
    					
    					$regions = Database::queryAsArray("select geonameid from t_geo_region where collected = '0' and collection_scheduled = null limit '$amount'");
    				
    					if (!empty($regions)) {
    						
    						$update["type"] = "city";
    						foreach ($regions as $region) {
    							$update["geocodeIds"][] = mysql_real_escape_string($region->geonameid);
    						}
    						Database::query("update t_geo_region set collection_scheduled = now() where geonameid in ('".implode("','",$update["geocodeIds"])."')");
    						
    					} else {
    					    
    					    self::updatePollScheduled();
    					    //TODO we could update for cities
    					    /*
        			    	$citys = Database::queryAsArray("select geonameid from t_geo_city where collected = '0' and collection_scheduled = null limit '$amount'");
        					if (!empty($citys)) {
    						
    	    					$update["type"] = "city";
    		    				foreach ($regions as $region) {
    			    				$update["geocodeIds"][] = mysql_real_escape_string($region->geonameid);
    				    		}
    					    	Database::query("update t_geo_region set collection_scheduled = now() where geonameid in ('".implode("','",$update["geocodeIds"])."')");
    				        }
    				        */
    					}
    					
    					
    				}
    			}
    		}
    	}
    	
    	if (!isset($update["type"])) {
    		
    		// do google places search
    		
    		// continents
    		Database::queryAsArray("select gc.geonameid as geonameid, gc.name as name, gp.id as id from t_geo_place gp join t_geo_continent gc on gc.id = gp.typeid where gp.type = '1' gp.collected = '0' and gp.collection_scheduled = null limit '$amount'");
    		
    		
    		
    		
    		// no updates
    		$update["status"] = "finnished!";
    	}
    	
    	return $update;
    }
    
    function updatePollScheduled () {
        
        $rowsUpdated = 0;
        
        $result = Database::query("update geo_continent set collection_scheduled = null where collection_scheduled != null and collection_scheduled < now() - houre(1)");
		$rowsUpdated += Database::affectedRows($result);
		
		$result = Database::query("update geo_country set collection_scheduled = null where collection_scheduled != null and collection_scheduled < now() - houre(1)");
		$rowsUpdated += Database::affectedRows();
		
		$result = Database::query("update geo_region set collection_scheduled = null where collection_scheduled != null and collection_scheduled < now() - houre(1)");
		$rowsUpdated += Database::affectedRows();
		
		$result = Database::query("update geo_state set collection_scheduled = null where collection_scheduled != null and collection_scheduled < now() - houre(1)");
		$rowsUpdated += Database::affectedRows();
		
		return $rowsUpdated;
	}
}

?>