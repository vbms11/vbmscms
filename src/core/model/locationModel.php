<?php

class LocationModel {
    private static $countries;
    private static $regions;
    private static $cities;
    static function getContries () {
        return $this->countries;
    }
    static function getRegions ($country = null) {
        if ($country == null) {
            $allRegions = array();
            foreach (self::$regions as $region) {
                $allRegions = array_merge($region, $allRegions);
            }
            return $allRegions;
        } else {
            return self::$regions[$country];
        }
    }
    static function getCities ($region = null) {
        if ($region == null) {
            $allCities = array();
            foreach (self::$regions as $region) {
                $allCities = array_merge(self::$cities[$region], $allCities);
            }
            return $allCities;
        } else {
            return self::$cities[$region];
        }
    }
}

?>