<?php

class ProductsPageModel {

    static function setPosition ($id, $position) {
        $id = Database::escape($id);
        $position = Database::escape($position);
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
        $result = Database::queryAsArray("select text, pageid from t_product where $searchSql and lang = '$lang'");
        $obj;
        $results = array();
        foreach ($result as $obj) {
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
        return Database::queryAsObject("select max(id) as max from t_product");
    }

    static function getProducts ($pageId, $lang) {
        $pageId = Database::escape($pageId);
        $lang = Database::escape($lang);
        return Database::queryAsArray("select * from t_product where pageid='$pageId' and lang='$lang' order by position");
    }
    
    function getAllProducts ($lang=null) {
        $lang = Database::escape($lang == null ? Context::getLang() : $lang);
        return Database::queryAsArray("select * from t_product where lang='$lang' order by position");
    }

    static function getProduct ($id, $lang) {
        $id = Database::escape($id);
        $lang = Database::escape($lang);
        return Database::queryAsObject("select * from t_product where id = '$id' and lang = '$lang'");
    }

    static function createProduct ($pageId,$img,$text,$name,$quantity,$price,$minimumAmount,$lang) {
        $pageId = Database::escape($pageId);
        $img = Database::escape($img);
        $text = Database::escape($text);
        $name = Database::escape($name);
        $lang = Database::escape($lang);
        $minimumAmount = Database::escape($minimumAmount);
        $quantity = Database::escape($quantity);
        $price = Database::escape($price);
        $position = ProductsPageModel::getNextPosition();
        Database::query("insert into t_product(img,text,titel,pageid,lang,position,quantity,price,minimum) values('$img','$text','$name','$pageId','$lang','$position','$quantity','$price','$minimumAmount')");
        $newId = Database::query("select max(id) as newid from t_product");
        return $newId->newid;
    }

    static function updateProduct ($id,$pageId,$img,$text,$name,$quantity,$price,$minimumAmount,$lang) {
        $id = Database::escape($id);
        $pageId = Database::escape($pageId);
        $img = Database::escape($img);
        $text = Database::escape($text);
        $name = Database::escape($name);
        $lang = Database::escape($lang);
        $quantity = Database::escape($quantity);
        $price = Database::escape($price);
        $minimumAmount = Database::escape($minimumAmount);
        Database::query("update t_product set img = '$img', titel = '$name', text = '$text', quantity = '$quantity', price = '$price', minimum = '$minimumAmount' where id = '$id'");
    }

    static function deleteProduct ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_product where id = '$id'");
    }

    static function getNextPosition () {
        $result = Database::queryAsObject("select max(position) as max from t_product");
        return $result->max + 1;
    }
}


?>
