<?php

require_once('core/plugin.php');

class UserSearchBaseModule extends XModule {
    
    public $usersPerPageOptions = array("20","50","100");
    public $distanceOptions = array("10"=>"10 km","20"=>"20 km","50"=>"50 km","100"=>"100 km","200"=>"200 km");
    
}

?>