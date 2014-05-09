<?php

require_once('core/plugin.php');
require_once('modules/gallery/galleryModel.php');

class UserSearchResultModule extends XModule {
    
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
        
    }
    
    function printSearchResults () {
        
        $users = UsersModel::search(parent::get("agemin"), parent::get("agemax"), parent::get("country"), parent::get("place"), parent::get("distance"));
        $usersCount = count($users);
        
        $usersPerPageOptions = array("20","50","100");
        $usersPerPage = parent::get("usersPerPage");
        if (empty($usersPerPage)) {
            $usersPerPage = current($usersPerPageOptions);
        }
        
        $pagerPages = ceil($usersCount / $usersPerPage);
        ?>
        <div class="usersList" align="center">
            <?php
            foreach ($users as $user) {
                ?>
                <div class="usersSearchUserDiv shadow">
                    <div class="usersSearchUserImage">
                        <a href="<?php echo parent::staticLink('profile',array('id' => $user->getId())); ?>">
                            <img class="imageLink" width="170" height="170" src="<?php echo $user->getImage()->getPreviewUrl(parent::param('previewSize')); ?>" alt=""/>
                        </a>
                    </div>
                    <div class="usersSearchUserDetails">
                        <a href="<?php echo parent::staticLink('profile',array('id' => $user->getId())); ?>">
                            <?php echo $user->getObjectDisplayName(); ?>
                            <?php echo ' ('.$user->getAgeYears().')'; ?>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
            <div clear="both"></div>
        </div>
        <div class="userListPager">
            <?php
            for ($i=1; $i<=$pagerPages; $i++) {
                echo '<div><a href="'.parent::link(array(
                    "action" => "searchResults",
                    "page" => $i,
                    "agemin" => parent::get("agemin"), 
                    "agemax" => parent::get("agemax"), 
                    "country" => parent::get("country"), 
                    "place" => parent::get("place"), 
                    "distance" => parent::get("distance"),
                    "usersPerPage" => $usersPerPage)).'">'.$i.'</div>';
            }
            ?>
        </div>
        <div class="userListPages">
            <label><?php echo parent::getTranslation("users.search.pager.pages"); ?></label>
            <?php InputFeilds::printSelect("pages", $_POST['pages'], array()); ?>
        </div>
        <?php
    }
}

?>