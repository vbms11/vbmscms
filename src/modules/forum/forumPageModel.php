<?php

require_once('core/plugin.php');

class ForumPageModel {

    static function search ($searchText,$lang) {
        return $results;
    }

    static function viewTopic ($topicId) {
        $topicId = Database::escape($topicId);
        Database::query("update t_forum_topic set views = views + 1 where id = '$topicId'");
    }

    static function viewThread ($threadId) {
        $threadId = Database::escape($threadId);
        Database::query("update t_forum_thread set views = views + 1 where id = '$threadId'");
    }
    
    static function viewPm ($pmId) {
        $pmId = Database::escape($pmId);
        Database::query("update t_user_message set opened = '1' where id = '$pmId'");
    }

    static function getThread ($threadId) {
        $threadId = Database::escape($threadId);
        return Database::queryAsObject("select t.*, u.username as username from t_forum_thread t left join t_user u on u.id = t.userid where t.id = '$threadId'");
    }

    static function getTopic ($topicId) {
        $topicId = Database::escape($topicId);
        return Database::queryAsObject("select t.*, u.username as username from t_forum_topic t left join t_user u on u.id = t.userid where t.id = '$topicId'");
    }

    static function getPost ($postId) {
        $postId = Database::escape($postId);
        return Database::queryAsObject("select t.*, u.username as username from t_forum_post t left join t_user u on u.id = t.userid where t.id = '$postId'");
    }
    
    static function getPm ($pmId) {
        $pmId = Database::escape($pmId);
        return Database::queryAsObject("select m.*, srcu.username as srcusername, dstu.username as dstusername from t_user_message as m left join t_user as srcu on srcu.id = m.srcuser left join t_user as dstu on dstu.id = m.dstuser where m.id = '$pmId'");
    }

    static function getThreads ($parentTopic) {
        $parentTopic = Database::escape($parentTopic);
        return Database::queryAsArray("select t.*, u.username as username from t_forum_thread t left join t_user u on u.id = t.userid where parent = '$parentTopic'");
    }

    static function getTopics ($parentTopic) {
        $parentTopic = Database::escape($parentTopic);
        return Database::queryAsArray("select t.*, u.username as username from t_forum_topic t left join t_user u on t.userid = u.id where parent = '$parentTopic'");
    }

    static function getPosts ($threadId) {
        $threadId = Database::escape($threadId);
        return Database::queryAsArray("select p.*, u.username as username from t_forum_post p left join t_user u on u.id = p.userid where threadid = '$threadId'");
    }
    
    static function getPms ($userId) {
        $userId = Database::escape($userId);
        return Database::queryAsArray("select m.*, srcu.username as srcusername, dstu.username as dstusername from t_user_message as m left join t_user as srcu on srcu.id = m.srcuser left join t_user as dstu on dstu.id = m.dstuser where m.dstuser = '$userId'");
    }
    
    static function getUserTotalPosts ($userId) {
    	$userId = Database::escape($userId);
    	$result = Database::queryAsObject("select sum(amount) as sum from(
			SELECT count(*) as amount FROM t_forum_thread as t where t.userid = '$userId'
		    union
			SELECT count(*) as amount FROM t_forum_post as p where p.userid = '$userId'
		) as s");
		return $result->sum;
    }

    static function getForumPage ($pageId) {
        $pageId = Database::escape($pageId);
        $result = Database::queryAsObject("select * from forum_page where pageid = '$pageId'");
        if ($result == null) {
            // Database::query("insert into forum_page topic = $topicId");
            // $this->getForumPage($pageId);
        }
        // return $obj;
    }

    static function saveTopic ($parentTopic, $topicId, $topicName, $userId) {
        $parentTopic = Database::escape($parentTopic);
        $topicName = Database::escape($topicName);
        $topicId = Database::escape($topicId);
        $userId = Database::escape($userId);
        if (Common::isEmpty($topicId)) {
            Database::query("insert into t_forum_topic (parent,name,createdate,userid) values ('$parentTopic','$topicName',now(),'$userId')");
        } else {
            Database::query("update t_forum_topic set parent = '$parentTopic', name = '$topicName' where id = '$topicId'");
        }
    }

    static function saveThread ($parentTopic, $threadId, $threadTitel, $threadMessage) {
        $parentTopic = Database::escape($parentTopic);
        $threadId = Database::escape($threadId);
        $threadTitel = Database::escape($threadTitel);
        $threadMessage = Database::escape($threadMessage);
        $userId = Context::getUserId();
        if (Common::isEmpty($threadId)) {
            Database::query("insert into t_forum_thread (parent,name,message,createdate,userid) values ('$parentTopic','$threadTitel','$threadMessage',now(),$userId)");
        } else {
            Database::query("update t_forum_thread set parent = '$parentTopic', name = '$threadTitel', message = '$threadMessage' where id = '$threadId'");
        }
    }

    static function savePost ($threadId, $postId, $postMessage, $userId) {
        $threadId = Database::escape($threadId);
        $postId = Database::escape($postId);
        $postMessage = Database::escape($postMessage);
        $userId = Database::escape($userId);
        if (Common::isEmpty($postId)) {
            Database::query("insert into t_forum_post (threadid,message,userid,createdate) values ('$threadId','$postMessage','$userId',now())");
        } else {
            Database::query("update t_forum_post set threadid = '$threadId', message = '$postMessage' where id = '$postId'");
        }
    }
    
    static function savePm ($srcUserId, $dstUserId, $title, $message) {
        $srcUserId = Database::escape($srcUserId);
        $dstUserId = Database::escape($dstUserId);
        $message = Database::escape($message);
        $title = Database::escape($title);
        Database::query("insert into t_user_message (srcuser,dstuser,subject,message,senddate) values ('$srcUserId','$dstUserId','$title','$message',now())");
        $result = Database::queryAsObject("select max(id) as newid from t_user_message");
        return $result->newid;
    }

    static function deleteTopic ($topicId) {
        $topicId = Database::escape($topicId);
        Database::query("delete from t_forum_topic where id = '$topicId'");
    }

    static function deleteThread ($threadId) {
        $threadId = Database::escape($threadId);
        Database::query("delete from t_forum_thread where id = '$threadId'");
    }

    static function deletePost ($postId) {
        $postId = Database::escape($postId);
        Database::query("delete from t_forum_thread where id = '$postId'");
    }

    static function deletePm ($pmId) {
        $pmId = Database::escape($pmId);
        Database::query("delete from t_user_message where id = '$pmId'");
    }
    
    static function validatePm ($subject, $message) {
        
        $errors = array();
        
        $subject = Database::escape($subject);
        if (strlen($subject) == 0) {
            $errors["subject"] = "This feild cannot be empty!";
        }
        if (strlen($subject) > 100) {
            $errors["subject"] = "Maximum 100 characters!";
        }
        
        $message = Database::escape($message);
        if (strlen($message) == 0) {
            $errors["message"] = "This feild cannot be empty!";
        }
        if (strlen($message) > 5000) {
            $errors["message"] = "Maximum 5000 characters!";
        }
        
        return $errors;
    }
}
?>