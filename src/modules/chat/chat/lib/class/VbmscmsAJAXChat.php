<?php

class VbmscmsAJAXChat extends AJAXChat {

    // Returns an associative array containing userName, userID and userRole
    // Returns null if login is invalid
    function getValidLoginUserData() {

        $user = null;
        
        if (isset($_GET['authkey'])) {
            $sql = 'select id, username from t_user where authkey = '.$this->db->makeSafe($_GET['authkey']).';';
            $result = $this->db->sqlQuery($sql);
            $user = $result->fetch();
        }
        
        if ($user != null) {
            
            $sql = 'select roleid from t_roles where userid = '.$this->db->makeSafe($user["id"]).';';
            $result = $this->db->sqlQuery($sql);
            
            $roleIds = array();
            while (($role = $result->fetch()) != null) {
                $roleIds[] = $role["roleid"];
            }
            
            $userData = array();
            $userData['userID'] = $user["id"];
            $userData['userName'] = $user["username"];

            $role = AJAX_CHAT_USER;
            if (in_array(10, $roleIds)) {
                $role = AJAX_CHAT_ADMIN;
            } else if (in_array(9, $roleIds)) {
                $role = AJAX_CHAT_MODERATOR;
            }
            $userData['userRole'] = $role;

            return $userData;
        }

        return null;
    }

    // Store the channels the current user has access to
    // Make sure channel names don't contain any whitespace
    function &getChannels() {
        if($this->_channels === null) {
            $this->_channels = array('Public' => 0);
        }
        return $this->_channels;
    }

    // Store all existing channels
    // Make sure channel names don't contain any whitespace
    function &getAllChannels() {
        if($this->_allChannels === null) {
            // Get all existing channels:
            $this->_allChannels = array('Public' => 0);
        }
        return $this->_allChannels;
    }

}