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
class CountriesModel {
    
    static function getCountry ($countryId) {
        $countryId = mysql_real_escape_string($countryId);
        return Database::queryAsObject("select * from t_countries where id = '$countryId'");
    }
    
    static function getCountries () {
        return Database::queryAsArray("select * from t_countries order by name asc","id");
    }
}

?>