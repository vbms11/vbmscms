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
        
    }
    
    function printSearchResultsView () {
        
        $users = UsersModel::search(parent::get("agemin"), parent::get("agemax"), parent::get("country"), parent::get("place"), parent::get("distance"));
        $usersCount = count($users);
        
        $usersPerPage = parent::get("usersPerPage");
        if (empty($usersPerPage)) {
            $usersPerPage = current($this->usersPerPageOptions);
        }
        
        $pagerPages = ceil($usersCount / $usersPerPage);
        
        $page = parent::get("page");
        if (empty($page)) {
            $page = 0;
        }
        
        ?>
        <h1><?php echo parent::getTranslation("user.search.result.title"); ?></h1>
        <?php
        
        if (count($users) > 0) {
            
            ?>
            <p><?php echo parent::getTranslation("user.search.result.description",array("%total%"=>count($users),"%amount%"=>$usersPerPage < count($users) ? $usersPerPage : count($users))); ?></p>
            <div class="usersList">
                <?php
                $iStart = $page * $usersPerPage;
                $iEnd = count($users) > $iStart + $usersPerPage ? $iStart + $usersPerPage : count($users);
                for ($i=$iStart; $i<$iEnd; $i++) {
                    $user = $users[$i];
                    ?>
                    <div class="usersSearchUserDiv shadow">
                        <div class="usersSearchUserImage">
                            <a href="<?php echo parent::staticLink('userProfile',array('userId' => $user->id)); ?>">
                                <img class="imageLink" width="170" height="170" src="<?php echo UsersModel::getUserImageUrl($user->id); ?>" alt=""/>
                            </a>
                        </div>
                        <div class="usersSearchUserDetails">
                            <a href="<?php echo parent::staticLink('userProfile',array('userId' => $user->id)); ?>">
                                <?php echo $user->username; ?>
                                <?php echo ' ('.$user->age.')'; ?>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="clear"></div>
            </div>
            <?php
            if ($pagerPages > 1) {
                ?>
                <div class="userListPager">
                    <?php
                    for ($i=0; $i<$pagerPages; $i++) {
                        echo '<div><a href="'.parent::link(array(
                            "action" => "searchResults",
                            "page" => $i,
                            "agemin" => parent::get("agemin"), 
                            "agemax" => parent::get("agemax"), 
                            "country" => parent::get("country"), 
                            "place" => parent::get("place"), 
                            "distance" => parent::get("distance"),
                            "usersPerPage" => $usersPerPage)).'">'.($i+1).'</div>';
                    }
                    ?>
                </div>
                <div class="userListPages">
                    <label><?php echo parent::getTranslation("users.search.pager.pages"); ?></label>
                    <?php InputFeilds::printSelect("pages", $usersPerPage, array()); ?>
                </div>
                <?php
            }
            ?>
            <div class="clear"></div>
            <?php
            
        } else {
            ?>
            <p><?php echo parent::getTranslation("user.search.result.none"); ?></p>
            <?php
        }
    }
}

?>