<?php

require_once('core/plugin.php');
require_once('modules/users/userSearchBaseModule.php');

class UserSearchResultModule extends UserSearchBaseModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                parent::blur();
                parent::redirect();
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
                    $this->printSearchResultsView();
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
        <div class="panel usersProfilePanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function printSearchResultsView () {
        $users = UsersModel::search(parent::get("agemin"), parent::get("agemax"), parent::get("country"), parent::get("place"), parent::get("distance"), parent::get("gender"), parent::get("x"), parent::get("y"));
        $linkParams = array("agemin"=>parent::get("agemin"), "agemax"=>parent::get("agemax"), "country"=>parent::get("country"), "place"=>parent::get("place"), "distance"=>parent::get("distance"), "x"=>parent::get("x"), "y"=>parent::get("y"));
        $usersPerPage = parent::getUsersPerPage();
      	  
        ?>
        <h1><?php echo parent::getTranslation("user.search.result.title"); ?></h1>
        <?php
        if (count($users) > 0) {
            ?>
            <p><?php echo parent::getTranslation("user.search.result.description",array("%total%"=>count($users),"%amount%"=>$usersPerPage < count($users) ? $usersPerPage : count($users))); ?></p>
            <?php
            parent::listUsers($users,$linkParams);
        } else {
            ?>
            <p><?php echo parent::getTranslation("user.search.result.none"); ?></p>
            <?php
        }
    }
}

?>