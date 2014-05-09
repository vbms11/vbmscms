<?php

require_once('core/plugin.php');
require_once('modules/gallery/galleryModel.php');

class UserSearchModule extends XModule {
    
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
    
    function getConditions () {
        $conditions = array();
        if (parent::post("simpleSearchButton") == "simpleSearchButton") {
            $conditions["country"] = parent::post("country");
            $conditions["agemin"] = parent::post("country");
            $conditions["agemax"] = parent::post("country");
            $conditions["country"] = parent::post("country");
        }
        
    }
    
    function printEditView () {
        
    }
    
    function printSearchPanel () {
        ?>
        <div class="usersListSearch">
            <div class="searchTypeTabs">
                <ul>
                    <li><a href="#simpleSearch"><?php echo parent::getTranslation('users.search.tab.simple'); ?></a></li>
                </ul>
                
            </div>
            <script>
            $(".searchTypeTabs").tabs();
            $(".searchToggle button").click(function(e){
                $(".usersListSearch").toggle();
            });
            $(".usersSearchSearchButton").click(function(e){
                var searchParams;
                $("#simpleSearch select, #simpleSearch input").each(function(index,object){
                    searchParams[$(object).attr("name")] = $(object).val();
                });
                $(".usersListContent").slideUp(function(){
                    $.ajax({
                        type: "POST",
                        url: "<?php echo parent::ajaxLink(array("action"=>"searchResults")); ?>",
                        data: searchParams
                    }).done(function(msg) {
                        $(".usersListContent").html(msg).slideDown();
                    });
                });
                return false;
            });
            </script>
        </div>
        <?php
    }
    
    function printSearchView () {
        ?>
        <div class="usersSearchPanel">
            <form method="get" action="<?php echo parent::link(array("action"=>"searchResults")); ?>">
                <table>
                <tr>
                    <td><?php echo parent::getTranslation('users.search.gender'); ?></td>
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
                    <td><?php InputFeilds::printSpinner("agemin", parent::get('agemin') ? parent::get('agemin') : 16); ?></td>
                    <td><?php echo parent::getTranslation('users.search.ageto'); ?></td>
                    <td><?php InputFeilds::printSpinner("agemax", parent::get('agemax') ? parent::get('agemax') : 99); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation('users.search.country'); ?></td>
                    <td><?php InputFeilds::printSelect("country", parent::get('country'), array()); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation('users.search.place'); ?></td>
                    <td><?php InputFeilds::printSelect("place", parent::get('place'), array()); ?></td>
                </tr><tr>
                    <td><?php echo parent::getTranslation('users.search.distance'); ?></td>
                    <td><?php InputFeilds::printSelect("place", parent::get('place'), array()); ?></td>
                </tr></table>
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