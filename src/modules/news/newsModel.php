<?php

class NewsModel {
    
    static function getPublisher ($name) {
        
        $name = Database::escape($name);
        
        $result = Database::queryAsObject("select * from t_news_publisher where name = '$name'");
        
        if (empty($result)) {
            
            Database::query("insert into t_news_publisher (name) values ('$name')");
            
            return self::getPublisher($name);
        }
        
        return $result;
    }
    
    static function createNews ($content, $url, $title, $publisher, $imageUrl, $thumbUrl) {
        
        $content = Database::escape($content);
        $url = Database::escape($url);
        $title = Database::escape($title);
        $imageUrl = Database::escape($imageUrl);
        $thumbUrl = Database::escape($thumbUrl);
        
        $publisher = self::getPublisher($publisher);
        
        Database::query("insert into t_news (content,url,title,publisherid,imageurl,thumburl) values ('$content', '$url', '$title', '{$publisher->id}', '$imageUrl', '$thumbUrl')");
        
        $result = Database::queryAsObject("select last_insert_id() as lastid from t_news");
        return $result->newid;
    }
    
    static function getNews ($id) {
        
        $id = Database::escape($id);
        
        return Database::queryAsObject("select * from t_news where id = '$id'");
    }
    
    static function getRecentNews ($amount) {
        
        $amount = (int) $amount;
        
        return Database::queryAsArray("select * from t_news order by newsdate limit $amount");
    }
    
    static function deleteNews ($id) {
        
        $id = Database::escape($id);
        
        Database::query("delete from t_news where id = '$id'");
    }
    
}

?>