<?php

/**
 * Description of socialController
 *
 * @author vbms
 */
class SocialController {
    
    static function notifyMessageSent ($messageId) {
        
        $applicationInfo = self::getApplicationInfo();
        
        $pm = ForumPageModel::getPm($messageId);
        $pmName = htmlentities($pm->name,ENT_QUOTES);
        $pmMessage = htmlentities($pm->message,ENT_QUOTES);
        $pmSendDate = htmlentities(Common::toUiDate($pm->senddate),ENT_QUOTES);
        $viewMessageLink = NavigationModel::createStaticPageLink('userMessage',array('action' => 'view','id' => $messageId), true, false);
        
        $srcUserInfo = self::getUserInfo($pm->srcuser);
        $dstUserInfo = self::getUserInfo($pm->dstuser);
        
        $socialConfig = SocialNotificationsModel::get();
        
        $messageTitle = self::replaceMessageTokens($socialConfig->message_received_title,array(
            "messageName"           => $pmName,
            "messageDate"           => $pmSendDate,
            "srcUsername"           => $srcUserInfo["username"],
            "srcUserAge"            => $srcUserInfo["userAge"]
        ));
            
        $messageBody = self::replaceMessageTokens($socialConfig->message_received,array(
            "applicationLink"       => $applicationInfo["applicationPath"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "messageName"           => $pmName,
            "messageMessage"        => $pmMessage,
            "messageDate"           => $pmSendDate,
            "messageLink"           => $viewMessageLink."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUsername"           => $srcUserInfo["username"],
            "srcUserProfileLink"    => $srcUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUserAge"            => $srcUserInfo["userAge"],
            "srcUserCountry"        => $srcUserInfo["userCountry"],
            "srcUserRegion"         => $srcUserInfo["userRegion"],
            "srcUserCity"           => $srcUserInfo["userCity"],
            "srcUserAddress"        => $srcUserInfo["userAddress"],
            "srcUserPostCode"       => $srcUserInfo["userPostCode"],
            "dstUsername"           => $dstUserInfo["username"],
            "dstUserProfileLink"    => $dstUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "dstUserAge"            => $dstUserInfo["userAge"],
            "dstUserCountry"        => $dstUserInfo["userCountry"],
            "dstUserRegion"         => $dstUserInfo["userRegion"],
            "dstUserCity"           => $dstUserInfo["userCity"],
            "dstUserAddress"        => $dstUserInfo["userAddress"],
            "dstUserPostCode"       => $dstUserInfo["userPostCode"],
        ));
        
        EmailUtil::sendHtmlEmail($dstUserInfo["email"], $messageTitle, $messageBody, $socialConfig->sender_email);
    }
    
    static function notifyFriendRequest ($friendRequestId) {
                
        $applicationInfo = self::getApplicationInfo();
        
        $fr = UserFriendModel::getFriendRequest($friendRequestId);
        
        $requestDate = htmlentities(Common::toUiDate($fr->createdate),ENT_QUOTES);
        $confirmLink = NavigationModel::createStaticPageLink('userFriendRequest',array('action' => 'accept','id' => $friendRequestId), true, false);
        
        $srcUserInfo = self::getUserInfo($fr->srcuserid);
        $dstUserInfo = self::getUserInfo($fr->dstuserid);
        
        $socialConfig = SocialNotificationsModel::get();
        
        $messageTitle = self::replaceMessageTokens($socialConfig->friend_request_title,array(
            "srcUsername"           => $srcUserInfo["username"],
            "srcUserAge"            => $srcUserInfo["userAge"],
            "dstUsername"           => $dstUserInfo["username"]
        ));
        
        $messageBody = self::replaceMessageTokens($socialConfig->friend_request,array(
            "applicationLink"       => $applicationInfo["applicationPath"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "requestDate"           => $requestDate,
            "confirmLink"           => $confirmLink."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUsername"           => $srcUserInfo["username"],
            "srcUserProfileLink"    => $srcUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUserAge"            => $srcUserInfo["userAge"],
            "srcUserCountry"        => $srcUserInfo["userCountry"],
            "srcUserRegion"         => $srcUserInfo["userRegion"],
            "srcUserCity"           => $srcUserInfo["userCity"],
            "srcUserAddress"        => $srcUserInfo["userAddress"],
            "srcUserPostCode"       => $srcUserInfo["userPostCode"],
            "dstUsername"           => $dstUserInfo["username"],
            "dstUserProfileLink"    => $dstUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "dstUserAge"            => $dstUserInfo["userAge"],
            "dstUserCountry"        => $dstUserInfo["userCountry"],
            "dstUserRegion"         => $dstUserInfo["userRegion"],
            "dstUserCity"           => $dstUserInfo["userCity"],
            "dstUserAddress"        => $dstUserInfo["userAddress"],
            "dstUserPostCode"       => $dstUserInfo["userPostCode"],
        ));
        
        EmailUtil::sendHtmlEmail($dstUserInfo["email"], $messageTitle, $messageBody, $socialConfig->sender_email);
    }
    
    static function notifyFriendAccepted ($friendRequestId) {
                
        $applicationInfo = self::getApplicationInfo();
        
        $fr = UserFriendModel::getFriendRequest($friendRequestId);
        
        $srcUserInfo = self::getUserInfo($fr->srcuserid);
        $dstUserInfo = self::getUserInfo($fr->dstuserid);
        
        $socialConfig = SocialNotificationsModel::get();
        
        $messageTitle = self::replaceMessageTokens($socialConfig->friend_confirmed_title,array(
            "srcUsername"           => $srcUserInfo["username"],
            "dstUsername"           => $dstUserInfo["username"],
            "srcUserAge"            => $dstUserInfo["userAge"]
        ));
        
        $messageBody = self::replaceMessageTokens($socialConfig->friend_confirmed,array(
            "applicationLink"       => $applicationInfo["applicationPath"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUsername"           => $srcUserInfo["username"],
            "srcUserProfileLink"    => $srcUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUserAge"            => $srcUserInfo["userAge"],
            "srcUserCountry"        => $srcUserInfo["userCountry"],
            "srcUserRegion"         => $srcUserInfo["userRegion"],
            "srcUserCity"           => $srcUserInfo["userCity"],
            "srcUserAddress"        => $srcUserInfo["userAddress"],
            "srcUserPostCode"       => $srcUserInfo["userPostCode"],
            "dstUsername"           => $dstUserInfo["username"],
            "dstUserProfileLink"    => $dstUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "dstUserAge"            => $dstUserInfo["userAge"],
            "dstUserCountry"        => $dstUserInfo["userCountry"],
            "dstUserRegion"         => $dstUserInfo["userRegion"],
            "dstUserCity"           => $dstUserInfo["userCity"],
            "dstUserAddress"        => $dstUserInfo["userAddress"],
            "dstUserPostCode"       => $dstUserInfo["userPostCode"],
        ));
        
        EmailUtil::sendHtmlEmail($srcUserInfo["email"], $messageTitle, $messageBody, $socialConfig->sender_email);
    }
    
    static function notifyWallPost ($wallPostId) {
                
        $applicationInfo = self::getApplicationInfo();
        
        $wp = UserWallModel::getUserPost($wallPostId);
        $wpMessage = htmlentities($wp->comment,ENT_QUOTES);
        $wpSendDate = htmlentities(Common::toUiDate($wp->date),ENT_QUOTES);
        $viewMessageLink = NavigationModel::createStaticPageLink('userWall',null, true, false);
        
        switch ($wp->type) {
            case UserWallModel::type_wall:
                $dstUserId = $wp->typeid;
                break;
        }
        
        $dstUserInfo = self::getUserInfo($dstUserId);
        $srcUserInfo = self::getUserInfo($wp->srcuserid);
        
        $socialConfig = SocialNotificationsModel::get();
        
        $messageTitle = self::replaceMessageTokens($socialConfig->wall_post_title,array(
            "srcUsername"           => $srcUserInfo["username"],
            "dstUsername"           => $dstUserInfo["username"],
            "srcUserAge"            => $dstUserInfo["userAge"],
            "messageDate"           => $wpSendDate
        ));
        
        $messageBody = self::replaceMessageTokens($socialConfig->wall_post,array(
            "applicationLink"       => $applicationInfo["applicationPath"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "messageMessage"        => $wpMessage,
            "messageDate"           => $wpSendDate,
            "messageLink"           => $viewMessageLink."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUsername"           => $srcUserInfo["username"],
            "srcUserProfileLink"    => $srcUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUserAge"            => $srcUserInfo["userAge"],
            "srcUserCountry"        => $srcUserInfo["userCountry"],
            "srcUserRegion"         => $srcUserInfo["userRegion"],
            "srcUserCity"           => $srcUserInfo["userCity"],
            "srcUserAddress"        => $srcUserInfo["userAddress"],
            "srcUserPostCode"       => $srcUserInfo["userPostCode"],
            "dstUsername"           => $dstUserInfo["username"],
            "dstUserProfileLink"    => $dstUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "dstUserAge"            => $dstUserInfo["userAge"],
            "dstUserCountry"        => $dstUserInfo["userCountry"],
            "dstUserRegion"         => $dstUserInfo["userRegion"],
            "dstUserCity"           => $dstUserInfo["userCity"],
            "dstUserAddress"        => $dstUserInfo["userAddress"],
            "dstUserPostCode"       => $dstUserInfo["userPostCode"],
        ));
        
        EmailUtil::sendHtmlEmail($dstUserInfo["email"], $messageTitle, $messageBody, $socialConfig->sender_email);
    }
    
    static function notifyWallReply ($wallPostId) {
                
        $applicationInfo = self::getApplicationInfo();
        
        $wp = UserWallModel::getUserPost($wallPostId);
        $wpMessage = htmlentities($wp->comment,ENT_QUOTES);
        $wpSendDate = htmlentities(Common::toUiDate($wp->date),ENT_QUOTES);
        $viewMessageLink = NavigationModel::createStaticPageLink('userWall',null, true, false);
        
        switch ($wp->type) {
            case UserWallModel::type_wall:
                $dstUserId = $wp->typeid;
                break;
        }
        
        $dstUserInfo = self::getUserInfo($dstUserId);
        $srcUserInfo = self::getUserInfo($wp->srcuserid);
        
        $socialConfig = SocialNotificationsModel::get();
        
        $messageTitle = self::replaceMessageTokens($socialConfig->wall_post_title,array(
            "srcUsername"           => $srcUserInfo["username"],
            "dstUsername"           => $dstUserInfo["username"],
            "srcUserAge"            => $dstUserInfo["userAge"],
            "messageDate"           => $wpSendDate
        ));
        
        $messageBody = self::replaceMessageTokens($socialConfig->wall_post,array(
            "applicationLink"       => $applicationInfo["applicationPath"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "messageMessage"        => $wpMessage,
            "messageDate"           => $wpSendDate,
            "messageLink"           => $viewMessageLink."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUsername"           => $srcUserInfo["username"],
            "srcUserProfileLink"    => $srcUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "srcUserAge"            => $srcUserInfo["userAge"],
            "srcUserCountry"        => $srcUserInfo["userCountry"],
            "srcUserRegion"         => $srcUserInfo["userRegion"],
            "srcUserCity"           => $srcUserInfo["userCity"],
            "srcUserAddress"        => $srcUserInfo["userAddress"],
            "srcUserPostCode"       => $srcUserInfo["userPostCode"],
            "dstUsername"           => $dstUserInfo["username"],
            "dstUserProfileLink"    => $dstUserInfo["userProfileLink"]."&ampuserAuthKey".$dstUserInfo["authKey"],
            "dstUserAge"            => $dstUserInfo["userAge"],
            "dstUserCountry"        => $dstUserInfo["userCountry"],
            "dstUserRegion"         => $dstUserInfo["userRegion"],
            "dstUserCity"           => $dstUserInfo["userCity"],
            "dstUserAddress"        => $dstUserInfo["userAddress"],
            "dstUserPostCode"       => $dstUserInfo["userPostCode"],
        ));
        
        EmailUtil::sendHtmlEmail($dstUserInfo["email"], $messageTitle, $messageBody, $socialConfig->sender_email);        
    }
    
    private static function getApplicationInfo () {
        
        $applicationLink = NavigationModel::getSitePath()."/";
        return array(
            "applicationPath" => $applicationLink
        );
    }
    
    private static function getUserInfo ($userId) {
        
        $user = UsersModel::getUser($userId);
        $userLink = NavigationModel::createStaticPageLink('userProfile',array('userId' => $user->id), true, false);
        $userAddress = UserAddressModel::getUserAddressByUserId($userId);
        
        $userInfo = array(
            "username"          => htmlentities($user->username,ENT_QUOTES),
            "userProfileLink"   => $userLink,
            "userAge"           => htmlentities($user->age,ENT_QUOTES),
            "authKey"           => $user->authkey,
            "email"             => $user->email
        );
        
        if (!empty($userAddress)) {
            $userInfo["userCountry"]    = htmlentities($userAddress->country,ENT_QUOTES);
            $userInfo["userRegion"]     = htmlentities($userAddress->region,ENT_QUOTES);
            $userInfo["userCity"]       = htmlentities($userAddress->city,ENT_QUOTES);
            $userInfo["userAddress"]    = htmlentities($userAddress->address,ENT_QUOTES);
            $userInfo["userPostCode"]   = htmlentities($userAddress->postcode,ENT_QUOTES);
        }
        
        return $userInfo;
    }
    
    private static function replaceMessageTokens ($message, $tokens) {
        
        foreach ($tokens as $key => $value) {
            $message = str_replace("%".$key."%", $value, $message);
        }
        return $message;
    }
}

?>
