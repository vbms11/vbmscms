<?php

class ArticleModel {
	
	const visibility_private = 0;
	const visibility_public = 1;
	const visibility_friends = 2;
	
	function createArticle ($name, $description, $content, $imageId, $userId = null, $siteId = null) {
		
		$name = Database::escape($name);
		$description = Database::escape($description);
		$content = Database::escape($content);
		
		if ($userId = null) {
			$userId = "'".Database::escape(Context::getUserId())."'";
		} else {
			$userId = "'".Database::escape($userId)."'";
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

		$id = Database::escape($id);
		$name = Database::escape($name);
		$description = Database::escape($description);
		$content = Database::escape($content);
		
		if ($userId = null) {
			$userId = "'".Database::escape(Context::getUserId())."'";
		} else {
			$userId = "'".Database::escape($userId)."'";
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
		
		$id = Database::escape($id);
		
		Database::query("delete from t_article where id = '$id'");
	}
	
	function getArticle ($id) {
		
		$id = Database::escape($id);
		
		return Database::queryAsObject("select * from t_article where id = '$id'");
	}
	
	function getArticles ($visibility = null, $userId = null, $siteId = null) {
		
		if ($visibility == null) {
			$visibility = self::visibility_public;
		} else {
			$visibility = Database::escape($visibility);
		}
		
		if ($userId = null) {
			$userId = "";
		} else {
			$userId = "and userid = '".Database::escape($userId)."'";
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
			$keywords[$key] = Database::escape($value);
		}
		
		$keywordsSql = "'".implode($keywords, "','")."'";
		
		Database::query("select articleid from t_article_keyword ak where ak.keywordid in ($keywordsSql)");
	}
	
	function getArticleKeywords ($articleId) {
		
		$articleId = Database::escape($articleId);
		
		return Database::queryAsArray("select k.*, ak.articleId as articleId from t_keyword k join t_article_keyword ak where ak.articleId = '$articleId'");
	}
	
}

?>