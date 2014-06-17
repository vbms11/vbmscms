<?php

require_once('core/plugin.php');

class UserSearchBaseModule extends XModule {
    
    public $usersPerPageOptions = array("50","100","200");
    public $distanceOptions = array("10"=>"10 km","20"=>"20 km","50"=>"50 km","100"=>"100 km","200"=>"200 km");
    
    function getUsersPerPage () {
        
        $usersPerPage = parent::get("usersPerPage");
        if (empty($usersPerPage)) {
            $usersPerPage = current($this->usersPerPageOptions);
        }
        return $usersPerPage;
    }
    
    function listUsers ($users, $linkParams = array()) {
        
        $usersCount = count($users);
        
        $usersPerPage = $this->getUsersPerPage();
        
        $pagerPages = ceil($usersCount / $usersPerPage);
        
        $page = parent::get("page");
        if (empty($page)) {
            $page = 0;
        }
        
        $iStart = $page * $usersPerPage;
        $iEnd = count($users) > $iStart + $usersPerPage ? $iStart + $usersPerPage : count($users);
        
        ?>
        <div class="usersList">
            <?php
            for ($i=$iStart; $i<$iEnd; $i++) {
                $user = $users[$i];
                ?>
                <div class="userListUserDiv shadow">
                    <div class="userListUserImage">
                        <a href="<?php echo NavigationModel::createStaticPageLink('userProfile', array('userId' => $user->id), true, false); ?>" title="<?php echo $user->username; ?>">
                            <img width="170" height="170" src="<?php echo UsersModel::getUserImageUrl($user->id); ?>" alt="<?php echo $user->username; ?>"/>
                        </a>
                    </div>
                    <div class="userListUserDetails">
                        <a href="<?php echo NavigationModel::createStaticPageLink('userProfile', array('userId' => $user->id), true, false); ?>">
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
                    ?>
                    <div>
                        <a href="<?php echo parent::link(array_merge($linkParams,array("page" => $i))); ?>">
                            <?php echo $i + 1; ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="clear"></div>
            <?php
        }
    }
    
}

?>