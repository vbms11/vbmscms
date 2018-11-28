<?php

require_once('core/plugin.php');
require_once('modules/company/companySearchBaseModule.php');

class CompanySearchModule extends CompanySearchBaseModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                parent::blur();
                parent::redirect();
                break;
            case "search":
                parent::redirect("companySearchResult", array("name"=>parent::get("name"),"country"=>parent::get("country")));
                break;
            case "searchResults":
                break;
            default:
                break;
        }
    }
    
    function onView () {
	
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("company.search.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("company.search.view")) {
                    $this->printSearchView();
                }
                break;
        }
    }
    
    function getScripts () {
        return array();
    }
    
    function getStyles () {
        return array("css/companySearch.css");
    }
    
    function getRoles () {
        return array("company.search.edit","company.search.view");
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
        
        /*
        $countryOptions = array();
        $countires = CountryModel::getCountries();
        foreach ($countires as $country) {
            $countryOptions[$country->geonameid] = htmlentities($country->name,ENT_QUOTES);
        }
        */
        
        ?>
        <div class="panel comapnySearchPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"search")); ?>" name="companySearchForm">
		<div>
                    <table><tr>
                        <td><?php echo parent::getTranslation('company.search.name'); ?></td>
                    </tr><tr>
                        <td><?php InputFeilds::printTextFeild("name", parent::get('name')); ?></td>
                    </tr>
                    <?php /*
                    <tr>
                        <td><?php echo parent::getTranslation('company.search.country'); ?></td>
                    </tr><tr>
                        <td><?php 
                        $countryId = parent::get('country');
                        echo "<select name='country'>";
                        if (empty($countryId)) {
                            echo "<option style='display:none;' selected='selected' value=''>(Please Select)</option>";
                        }
                        foreach ($countryOptions as $key => $valueNames) {
                            if (!empty($countryId) && $key == $countryId) {
                                echo "<option value='".Common::htmlEscape($key)."' selected='selected'>".Common::htmlEscape($valueNames)."</option>";
                            } else {
                                echo "<option value='".Common::htmlEscape($key)."'>".Common::htmlEscape($valueNames)."</option>";
                            }

                        }
                        echo "</select>";
                        ?></td>
                    </tr>
                    */ ?>
                    </table>
                </div>
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton companySearchSearchButton" value="simpleSearchButton" type="submit">
                        <?php echo parent::getTranslation('company.search.button.search'); ?>
                    </button>
                </div>
            </form>
        </div>
        <?php    
    }
    
}

?>