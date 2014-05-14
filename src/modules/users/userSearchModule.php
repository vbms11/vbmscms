<?php

require_once('core/plugin.php');
require_once('modules/users/userSearchBaseModule.php');

class UserSearchModule extends UserSearchBaseModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                parent::param("","");
                parent::param("","");
                parent::param("","");
                parent::blur();
                parent::redirect();
                break;
            case "search":
                break;
            case "searchResults":
                break;
            default:
                break;
        }
    }
    
    function onView () {
        
        switch ($this->getAction()) {
            case "edit":
                if (Context::hasRole("user.search.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("user.search.view")) {
                    $this->printSearchView();
                }
                break;
        }
    }
    
    function getScripts () {
        return array("js/userSearch.js");
    }
    
    function getStyles () {
        return array("css/userSearch.css");
    }
    
    function getRoles () {
        return array("user.search.edit","user.search.view");
    }
    
    function printEditView () {
        ?>
        <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
            <hr/>
            <button><?php echo parent::getTranslation("common.save"); ?></button>
        </form>
        <?php
    }
    
    function printSearchView () {
        
        $countryOptions = array();
        $countires = CountryModel::getCountries();
        foreach ($countires as $country) {
            $countryOptions[$country->geonameid] = htmlentities($country->name,ENT_QUOTES);
        }
        
        $ageOptions = array();
        for ($i=16; $i<100; $i++) {
            $ageOptions[$i] = $i;
        }
        
        ?>
        <div class="usersSearchPanel">
            <form method="get" action="">
                <input type="hidden" name="static" value="userSearchResult" />
                <table><tr>
                    <td><?php echo parent::getTranslation('users.search.gender'); ?></td>
                </tr><tr>
                    <td><?php 
                        $selectedValue = "0";
                        $user = Context::getUser();
                        if (!empty($user)) {
                            if ($user->gender == "0") {
                                $selectedValue = "1";
                            }
                        }
                        InputFeilds::printSelect("gender", $selectedValue, array("0" => parent::getTranslation("common.female"), "1" => parent::getTranslation("common.male")));
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation('users.search.age'); ?></td>
                </tr><tr>
                    <td><?php InputFeilds::printSelect("agemin", parent::get('agemin') ? parent::get('agemin') : 16, $ageOptions); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation('users.search.ageto'); ?></td>
                </tr><tr>
                    <td><?php InputFeilds::printSelect("agemax", parent::get('agemax') ? parent::get('agemax') : 99, $ageOptions); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation('users.search.country'); ?></td>
                </tr><tr>
                    <td><?php 
                    $countryId = parent::get('country');
                    echo "<select name='country'>";
                    if (empty($countryId)) {
                        echo "<option style='display:none;' selected='true'>(Please Select)</option>";
                    }
                    foreach ($countryOptions as $key => $valueNames) {
                        if (!empty($countryId) && $key == $countryId) {
                            echo "<option value='".Common::htmlEscape($key)."' selected='true'>".Common::htmlEscape($valueNames)."</option>";
                        } else {
                            echo "<option value='".Common::htmlEscape($key)."'>".Common::htmlEscape($valueNames)."</option>";
                        }
                        
                    }
                    echo "</select>";
                    ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation('users.search.place'); ?></td>
                </tr><tr>
                    <td><?php InputFeilds::printTextFeild("place", parent::get('place'), array()); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation('users.search.distance'); ?></td>
                </tr><tr>
                    <td><?php InputFeilds::printSelect("distance", parent::get('distance'), $this->distanceOptions); ?></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <button class="userSearchSearchButton jquiButton" value="simpleSearchButton" type="submit">
                        <?php echo parent::getTranslation('users.search.button.search'); ?>
                    </button>
                </div>
            </form>
        </div>
        <?php    
    }
    
}

?>