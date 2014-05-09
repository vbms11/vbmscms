<?php

class ProductsPageModel {

    static function setPosition ($id, $position) {
        $id = mysql_real_escape_string($id);
        $position = mysql_real_escape_string($position);
        $result = Database::query("update t_product set position = '$position' where id = '$id'");
    }

    static function moveUp ($pageId, $id) {
        // find the selected article
        $article;
        $articleAbove = null;
        $articles = ProductsPageModel::getProducts($pageId,Context::getLang());
        for ($i=0; $i<count($articles); $i+=1) {
            if ($articles[$i]->id == $id) {
                $article = $articles[$i];
                if ($i != 0) {
                    $articleAbove = $articles[$i-1];
                }
            }
        }
        if ($articleAbove != null) {
            // swap the order keys
            ProductsPageModel::setPosition($articleAbove->id, $article->position);
            ProductsPageModel::setPosition($article->id, $articleAbove->position);
        }
    }

    static function moveDown ($pageId, $id) {
        // find the selected article
        $article;
        $articleBelow = null;
        $articles = ProductsPageModel::getProducts($pageId,Context::getLang());
        for ($i=0; $i<count($articles); $i+=1) {
            if ($articles[$i]->id == $id) {
                $article = $articles[$i];
                if ($i != count($articles)-1) {
                    $articleBelow = $articles[$i+1];
                }
            }
        }
        if ($articleBelow != null) {
            // swap the order keys
            ProductsPageModel::setPosition($articleBelow->id, $article->position);
            ProductsPageModel::setPosition($article->id, $articleBelow->position);
        }
    }

    static function search ($searchText,$lang) {
        $searchSql = SearchModel::makeSearchSql($searchText, "text");
        $result = Database::query("select text, pageid from t_product where $searchSql and lang = '$lang'");
        $obj;
        $results = array();
        while (($obj = mysql_fetch_object($result)) != null) {
            $pageId = PagesModel::getPageIdFromModuleId($obj->pageid);
            $content = SearchModel::cleanPreviewText($obj->text,$searchText);
            $title = PagesModel::getPageNameInMenu($pageId,$lang);
            if ($pageId == null || $title == null)
                continue;
            $results[] = new SearchResult($pageId,$content,$title);
        }
        return $results;
    }

    static function getMaxProductId () {
        $result = Database::query("select max(id) as max from t_product");
        return mysql_fetch_object($result)->max;
    }

    static function getProducts ($pageId, $lang) {
        $pageId = mysql_real_escape_string($pageId);
        $lang = mysql_real_escape_string($lang);
        return Database::queryAsArray("select * from t_product where pageid='$pageId' and lang='$lang' order by position");
    }
    
    function getAllProducts ($lang=null) {
        $lang = mysql_real_escape_string($lang == null ? Context::getLang() : $lang);
        return Database::queryAsArray("select * from t_product where lang='$lang' order by position");
    }

    static function getProduct ($id, $lang) {
        $id = mysql_real_escape_string($id);
        $lang = mysql_real_escape_string($lang);
        $result = Database::query("select * from t_product where id = '$id' and lang = '$lang'");
        return mysql_fetch_object($result);
    }

    static function createProduct ($pageId,$img,$text,$name,$quantity,$price,$minimumAmount,$lang) {
        $pageId = mysql_real_escape_string($pageId);
        $img = mysql_real_escape_string($img);
        $text = mysql_real_escape_string($text);
        $name = mysql_real_escape_string($name);
        $lang = mysql_real_escape_string($lang);
        $minimumAmount = mysql_real_escape_string($minimumAmount);
        $quantity = mysql_real_escape_string($quantity);
        $price = mysql_real_escape_string($price);
        $position = ProductsPageModel::getNextPosition();
        Database::query("insert into t_product(img,text,titel,pageid,lang,position,quantity,price,minimum) values('$img','$text','$name','$pageId','$lang','$position','$quantity','$price','$minimumAmount')");
        $newId = Database::query("select last_insert_id() as newid from t_product");
        return $newId->newid;
    }

    static function updateProduct ($id,$pageId,$img,$text,$name,$quantity,$price,$minimumAmount,$lang) {
        $id = mysql_real_escape_string($id);
        $pageId = mysql_real_escape_string($pageId);
        $img = mysql_real_escape_string($img);
        $text = mysql_real_escape_string($text);
        $name = mysql_real_escape_string($name);
        $lang = mysql_real_escape_string($lang);
        $quantity = mysql_real_escape_string($quantity);
        $price = mysql_real_escape_string($price);
        $minimumAmount = mysql_real_escape_string($minimumAmount);
        Database::query("update t_product set img = '$img', titel = '$name', text = '$text', quantity = '$quantity', price = '$price', minimum = '$minimumAmount' where id = '$id'");
    }

    static function deleteProduct ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_product where id = '$id'");
    }

    static function getNextPosition () {
        $result = Database::query("select max(position) as max from t_product");
        return mysql_fetch_object($result)->max + 1;
    }
}


?>
