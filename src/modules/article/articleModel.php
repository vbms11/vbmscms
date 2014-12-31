<?php

class ArticleModel {
	
	const visibility_private = 0;
	const visibility_public = 1;
	const visibility_friends = 2;
	
	function createArticle ($name, $description, $content, $imageId, $userId = null, $siteId = null) {
		
		$name = mysql_real_escape_string($name);
		$description = mysql_real_escape_string($description);
		$content = mysql_real_escape_string($content);
		
		if ($userId = null) {
			$userId = "'".mysql_real_escape_string(Context::getUserId())."'";
		} else {
			$userId = "'".mysql_real_escape_string($userId)."'";
		}
		
		if ($siteId == null) {
			$siteId = Context::getSiteId();
		}
		
		Database::query("insert into t_article 
				(name, description, content, createdate, modifydate, userid, siteid)
				values('$name', '$description', '$content', now(), now(), '$userid', '$siteid')");
		
		$lastInsert = Database::query("select last_insert_id() as id from t_article");
	}
	
	function saveArticle ($id, $name, $description, $content, $userId = null, $siteId = null) {

		$id = mysql_real_escape_string($id);
		$name = mysql_real_escape_string($name);
		$description = mysql_real_escape_string($description);
		$content = mysql_real_escape_string($content);
		
		if ($userId = null) {
			$userId = "'".mysql_real_escape_string(Context::getUserId())."'";
		} else {
			$userId = "'".mysql_real_escape_string($userId)."'";
		}
		
		if ($siteId == null) {
			$siteId = Context::getSiteId();
		}
		
		Database::query("update t_article set
			name = '$name', 
			description = '$description', 
			content = '$content', 
			modifydate = now(), 
			siteid = '$siteId', 
			userid = $userId,
			where id = '$id'");
	}
	
	function deleteArticle ($id) {
		
		$id = mysql_real_escape_string($id);
		
		Database::query("delete from t_article where id = '$id'");
	}
	
	function getArticle ($id) {
		
		$id = mysql_real_escape_string($id);
		
		return Database::queryAsObject("select * from t_article where id = '$id'");
	}
	
	function getArticles ($visibility = null, $userId = null, $siteId = null) {
		
		if ($visibility == null) {
			$visibility = self::visibility_public;
		} else {
			$visibility = mysql_real_escape_string($visibility);
		}
		
		if ($userId = null) {
			$userId = "";
		} else {
			$userId = "and userid = '".mysql_real_escape_string($userId)."'";
		}
		
		if ($siteId == null) {
			$siteId = Context::getSiteId();
		}
		
		Database::queryAsArray("select * from t_article where visibility = '$visibility' and siteid = '$siteId' $userId");
	}
	
	function getArticlesByKeywords ($keywords) {
		
		$keywordIds = array();
		for ($keywords as $keyword) {
			
			$keywordObj = KeywordModel::getKeywordByValue($keyword);
			if (empty($keywordObj)) {
				return array();
			}
			$keywordIds []= $keywordObj->id;
		}
		
		return self::getArticleByKeywordIds($keywordIds);
	}
	
	function getArticleByKeywordIds ($keywords) {
		
		foreach ($keywords as $key => $value) {
			$keywords[$key] = mysql_real_escape_string($value);
		}
		
		$keywordsSql = "'".implode($keywords, "','")."'";
		
		Database::query("select articleid from t_article_keyword ak where ak.keywordid in ($keywordsSql)");
	}
	
	function getArticleKeywords ($articleId) {
		
		$articleId = mysql_real_escape_string($articleId);
		
		return Database::queryAsArray("select k.*, ak.articleId as articleId from t_keyword k join t_article_keyword ak where ak.articleId = '$articleId'");
	}
	
}

?>