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
    
    function printEditView () {
        
    }
    
    function printSearchPanel () {
        ?>
        <div class="usersListSearch">
            <div class="searchTypeTabs">
                <ul>
                    <li><a href="#simpleSearch"><?php echo parent::getTranslation('users.search.tab.simple'); ?></a></li>
                </ul>
                <div id="simpleSearch">
                    <form method="get" action="<?php echo parent::link(array("action"=>"searchResults")); ?>">
                        <table><tr>
                            <td><?php echo parent::getTranslation('users.search.country'); ?></td>
                            <td><?php InputFeilds::printSelect("country", parent::get('country'), array()); ?></td>
                            <td><?php echo parent::getTranslation('users.search.age.min'); ?></td>
                            <td><?php InputFeilds::printSpinner("agemin", parent::get('agemin') ? parent::get('agemin') : 18); ?></td>
                        </tr><tr>
                            <td><?php echo parent::getTranslation('users.search.region'); ?></td>
                            <td><?php InputFeilds::printSelect("region", parent::get('region'), array()); ?></td>
                            <td><?php echo parent::getTranslation('users.search.age.max'); ?></td>
                            <td><?php InputFeilds::printSpinner("agemax", parent::get('agemax') ? parent::get('agemax') : 50); ?></td>
                        </tr></table>
                        <div class="alignRight">
                            <button class="userSearchSearchButton jquiButton" value="simpleSearchButton" type="submit">
                                <?php echo parent::getTranslation('users.search.button.search'); ?>
                            </button>
                        </div>
                    </form>
                </div>
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
    
    function printSearchResultsPanel () {
        return;
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
            <div class="usersSearchContent">
                <?php $this->printSearchPanel(); ?>
            </div>
            <div class="usersListContent">
                <?php $this->printSearchResultsPanel(); ?>
            </div>
        </div>
        <?php    
    }
    
}

?>