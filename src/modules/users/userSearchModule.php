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
            case "search":
                if (Context::hasRole("user.search.view")) {
                    $this->printSearchPanel();
                }
                break;
            case "searchResults":
                if (Context::hasRole("user.search.view")) {
                    $this->printResultsPanel();
                }
                break;
            default:
                if (Context::hasRole("user.search.view")) {
                    $this->printListUsers();
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
    
    function printSearchPanel () {
        ?>
        <div class="usersListSearch">
            <div class="searchTypeTabs">
                <a href="#simpleSearch"><?php echo parent::getTranslation('users.search.tab.simple'); ?></a>
                <div id="simpleSearch">
                    <form method="post" action="<?php echo parent::link(array("action"=>"searchResults")); ?>">
                        <table width="100%"><tr>
                            <td class="contract"><?php echo parent::getTranslation('users.list.search'); ?></td>
                            <td class="expand"><?php InputFeilds::printSelect("country", $_GET['country'], array()); ?></td>
                            <td class="contract"><?php echo parent::getTranslation('users.search.age.min'); ?></td>
                            <td class="expand"><?php InputFeilds::printSlider("agemin", $_GET['agemin'], array()); ?></td>
                        </tr><tr>
                            <td class="contract"><?php echo parent::getTranslation('users.list.search'); ?></td>
                            <td class="expand"><?php InputFeilds::printSelect("region", parent::post('country'), array()); ?></td>
                            <td class="contract"><?php echo parent::getTranslation('users.search.age.max'); ?></td>
                            <td class="expand"><?php InputFeilds::printSlider("agemax", $_GET['agemax'], array()); ?></td>
                        </tr></table>
                        <div class="alignRight">
                            <button class="userSearchSearchButton" value="simpleSearchButton" type="submit"><?php echo parent::getTranslation('users.search.button.search'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <script>
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
    
    function printSearchResultsPanel () {
        
        $users = UsersModel::search($this->getConditions());
        $usersCount = count($users);
        $usersPerPage = $_POST["usersPerPage"];
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
                echo '<div><a href="'.parent::link(array("action"=>"searchResults","page"=>$i)).'">'.$i.'</div>';
            }
            ?>
        </div>
        <div class="userListPages">
            <label><?php echo parent::getTranslation("users.search.pager.pages"); ?></label>
            <?php InputFeilds::printSelect("pages", $_POST['pages'], array()); ?>
        </div>
        <?php
    }
    
    function printListUsers () {
        ?>
        <div class="usersListPanel">
            <div class="usersListSearchToggle"><?php echo parent::getTranslation('users.search.button.toggle'); ?></div>
            <div class="usersSearchContent" align="center">
                <?php $this->printSearchPanel(); ?>
            </div>
            <div class="usersListContent" align="center">
                <?php $this->printSearchResultsPanel(); ?>
            </div>
        </div>
        <?php    
    }
    
}

?>