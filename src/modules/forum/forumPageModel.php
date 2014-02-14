<?php

require_once('core/plugin.php');

class ForumPageModel {

    static function search ($searchText,$lang) {
        return $results;
    }

    static function viewTopic ($topicId) {
        $topicId = mysql_real_escape_string($topicId);
        Database::query("update t_forum_topic set views = views + 1 where id = '$topicId'");
    }

    static function viewThread ($threadId) {
        $threadId = mysql_real_escape_string($threadId);
        Database::query("update t_forum_thread set views = views + 1 where id = '$threadId'");
    }
    
    static function viewPm ($pmId) {
        $pmId = mysql_real_escape_string($pmId);
        Database::query("update t_message set opened = '1' where id = '$pmId'");
    }

    static function getThread ($threadId) {
        $threadId = mysql_real_escape_string($threadId);
        $result = Database::query("select t.*, u.username as username from t_forum_thread t left join t_users u on u.id = t.userid where t.id = '$threadId'");
        return mysql_fetch_object($result);
    }

    static function getTopic ($topicId) {
        $topicId = mysql_real_escape_string($topicId);
        $result = Database::query("select t.*, u.username as username from t_forum_topic t left join t_users u on u.id = t.userid where t.id = '$topicId'");
        return mysql_fetch_object($result);
    }

    static function getPost ($postId) {
        $postId = mysql_real_escape_string($postId);
        $result = Database::query("select t.*, u.username as username from t_forum_post t left join t_users u on u.id = t.userid where t.id = '$postId'");
        return mysql_fetch_object($result);
    }
    
    static function getPm ($pmId) {
        $pmId = mysql_real_escape_string($pmId);
        $result = Database::query("select m.*, srcu.username as srcusername, dstu.username as dstusername from t_message as m left join t_users as srcu on srcu.id = m.srcuser left join t_users as dstu on dstu.id = m.dstuser where m.id = '$pmId'");
        return mysql_fetch_object($result);
    }

    static function getThreads ($parentTopic) {
        $parentTopic = mysql_real_escape_string($parentTopic);
        $result = Database::query("select t.*, u.username as username from t_forum_thread t left join t_users u on u.id = t.userid where parent = '$parentTopic'");
        $threads = array();
        $obj;
        while (($obj = mysql_fetch_object($result))) {
            $threads[] = $obj;
        }
        return $threads;
    }

    static function getTopics ($parentTopic) {
        $parentTopic = mysql_real_escape_string($parentTopic);
        $result = Database::query("select t.*, u.username as username from t_forum_topic t left join t_users u on t.userid = u.id where parent = '$parentTopic'");
        $topics = array(); $obj;
        while (($obj = mysql_fetch_object($result)))
            $topics[] = $obj;
        return $topics;
    }

    static function getPosts ($threadId) {
        $threadId = mysql_real_escape_string($threadId);
        $result = Database::query("select p.*, u.username as username from t_forum_post p left join t_users u on u.id = p.userid where threadid = '$threadId'");
        $posts = array(); $obj;
        while (($obj = mysql_fetch_object($result)))
            $posts[] = $obj;
        return $posts;
    }
    
    static function getPms ($userId) {
        $userId = mysql_real_escape_string($userId);
        $result = Database::query("select m.*, srcu.username as srcusername, dstu.username as dstusername from t_message as m left join t_users as srcu on srcu.id = m.srcuser left join t_users as dstu on dstu.id = m.dstuser where m.dstuser = '$userId'");
        $pms = array();
        while ($obj = mysql_fetch_object($result))
            $pms[] = $obj;
        return $pms;
    }

    static function getForumPage ($pageId) {
        $pageId = mysql_real_escape_string($pageId);
        $result = Database::query("select * from forum_page where pageid = '$pageId'");
        $obj = mysql_fetch_object($result);
        if ($obj == null) {
            Database::query("insert into forum_page topic = $topicId");
            $this->getForumPage($pageId);
        }
        return $obj;
    }

    static function saveTopic ($parentTopic, $topicId, $topicName, $userId) {
        $parentTopic = mysql_real_escape_string($parentTopic);
        $topicName = mysql_real_escape_string($topicName);
        $topicId = mysql_real_escape_string($topicId);
        $userId = mysql_real_escape_string($userId);
        if (Common::isEmpty($topicId)) {
            Database::query("insert into t_forum_topic (parent,name,createdate,userid) values ('$parentTopic','$topicName',now(),'$userId')");
        } else {
            Database::query("update t_forum_topic set parent = '$parentTopic', name = '$topicName' where id = '$topicId'");
        }
    }

    static function saveThread ($parentTopic, $threadId, $threadTitel, $threadMessage) {
        $parentTopic = mysql_real_escape_string($parentTopic);
        $threadId = mysql_real_escape_string($threadId);
        $threadTitel = mysql_real_escape_string($threadTitel);
        $threadMessage = mysql_real_escape_string($threadMessage);
        $userId = Context::getUserId();
        if (Common::isEmpty($threadId)) {
            Database::query("insert into t_forum_thread (parent,name,message,createdate,userid) values ('$parentTopic','$threadTitel','$threadMessage',now(),$userId)");
        } else {
            Database::query("update t_forum_thread set parent = '$parentTopic', name = '$threadTitel', message = '$threadMessage' where id = '$threadId'");
        }
    }

    static function savePost ($threadId, $postId, $postMessage, $userId) {
        $threadId = mysql_real_escape_string($threadId);
        $postId = mysql_real_escape_string($postId);
        $postMessage = mysql_real_escape_string($postMessage);
        $userId = mysql_real_escape_string($userId);
        if (Common::isEmpty($postId)) {
            Database::query("insert into t_forum_post (threadid,message,userid,createdate) values ('$threadId','$postMessage','$userId',now())");
        } else {
            Database::query("update t_forum_post set threadid = '$threadId', message = '$postMessage' where id = '$postId'");
        }
    }
    
    static function savePm ($srcUserId, $dstUserId, $title, $message) {
        $srcUserId = mysql_real_escape_string($srcUserId);
        $dstUserId = mysql_real_escape_string($dstUserId);
        $message = mysql_real_escape_string($message);
        $title = mysql_real_escape_string($title);
        Database::query("insert into t_message (srcuser,dstuser,subject,message,senddate) values ('$srcUserId','$dstUserId','$title','$message',now())");
    }

    static function deleteTopic ($topicId) {
        $topicId = mysql_real_escape_string($topicId);
        Database::query("delete from t_forum_topic where id = '$topicId'");
    }

    static function deleteThread ($threadId) {
        $threadId = mysql_real_escape_string($threadId);
        Database::query("delete from t_forum_thread where id = '$threadId'");
    }

    static function deletePost ($postId) {
        $postId = mysql_real_escape_string($postId);
        Database::query("delete from t_forum_thread where id = '$postId'");
    }

    static function deletePm ($pmId) {
        $pmId = mysql_real_escape_string($pmId);
        Database::query("delete from t_message where id = '$pmId'");
    }
}
?>