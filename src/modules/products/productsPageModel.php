<?php

class ProductsPageModel {

    static function setPosition ($id, $position) {
        $id = mysql_real_escape_string($id);
        $position = mysql_real_escape_string($position);
        $result = Database::query("update t_product set position = '$position' where id = '$id'");
    }

    static function moveUp ($id) {
        // select the product
        $product = ProductsPageModel::getProduct($id);
        // find the selected article
        $article;
        $articleAbove = null;
        $articles = ProductsPageModel::getProducts($product->groupId,Context::getLang());
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

    static function moveDown ($id) {
        // select the product
        $product = ProductsPageModel::getProduct($id);
        // find the selected article
        $article;
        $articleBelow = null;
        $articles = ProductsPageModel::getProducts($product->groupId,Context::getLang());
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
        // get products that contain search phrase
        $searchSql1 = SearchModel::makeSearchSql($searchText, "c1.value");
        $searchSql2 = SearchModel::makeSearchSql($searchText, "c2.value");
        $searchSql3 = SearchModel::makeSearchSql($searchText, "c3.value");
        $query = "
            select pgm.moduleid as moduleid, c1.value as text, c2.value as titel, c3.value as shorttext, p.groupid as groupid, p.id as id
            from t_product p
            left join t_code c1 on c1.code = p.textcode and c1.lang = '$lang'
            left join t_code c2 on c2.code = p.titelcode and c2.lang = '$lang'
            left join t_code c3 on c3.code = p.shorttextcode and c3.lang = '$lang'
            join t_product_group_module pgm on pgm.groupid = p.groupid
            where $searchSql1 or $searchSql2 or $searchSql3";
        // echo $query;
        $results = Database::queryAsArray($query);
        // 
        $obj;
        $ret = array();
        foreach ($results as $obj) {
            $contentTitel = SearchModel::cleanPreviewText($obj->titel,$searchText);
            $contentText = SearchModel::cleanPreviewText($obj->text,$searchText);
            //$pageId = PagesModel::getPageIdFromIncludeId($obj->moduleid);
            // $title = PagesModel::getPageNameInMenu($pageId,$lang);
            $ret[] = SearchResult::moduleResult($obj->moduleid,array("action"=>"viewProduct","id"=>$obj->id),$contentText,$contentTitel);
        }
        // var_dump($ret);
        return $ret;
    }

    static function getProducts ($groupId, $lang=null) {
        $groupId = mysql_real_escape_string($groupId);
        $lang = mysql_real_escape_string($lang == null ? Context::getLang() : $lang);
        return Database::queryAsArray("select c1.value as titel, c2.value as text, c3.value as shortext, p.* from t_product p
                                        left join t_code c1 on p.titelcode = c1.code and c1.lang = '$lang'
                                        left join t_code c2 on p.textcode = c2.code and c2.lang = '$lang'
                                        left join t_code c3 on p.shorttextcode = c3.code and c3.lang = '$lang'
                                        where p.groupid = '$groupId' order by p.position");
    }
    
    function getAllProducts ($lang=null) {
        $lang = mysql_real_escape_string($lang == null ? Context::getLang() : $lang);
        return Database::queryAsArray("select c1.value as titel, c2.value as text, c3.value as shortext, p.* from t_product p
                                        left join t_code c1 on p.titelcode = c1.code and c1.lang = '$lang'
                                        left join t_code c2 on p.textcode = c2.code and c2.lang = '$lang'
                                        left join t_code c3 on p.shorttextcode = c3.code and c3.lang = '$lang'
                                        where order by p.position");
    }

    static function getProduct ($id, $lang=null) {
        $id = mysql_real_escape_string($id);
        if ($lang == null) {
            $lang = Context::getLang();
        }
        $lang = mysql_real_escape_string($lang);
        $result = Database::query("select c1.value as titel, c2.value as text, c3.value as shorttext, p.* from t_product p
                                    left join t_code c1 on p.titelcode = c1.code and c1.lang = '$lang'
                                    left join t_code c2 on p.textcode = c2.code and c2.lang = '$lang'
                                    left join t_code c3 on p.shorttextcode = c3.code and c3.lang = '$lang'
                                    where p.id = '$id'");
        return mysql_fetch_object($result);
    }

    static function createProduct ($groupId,$img,$shortText,$text,$name,$quantity,$price,$shipping,$weight,$minimumAmount,$galleryId,$lang) {
        //
        $shortTextCode = CodeModel::createCode($lang, $shortText);
        $textCode = CodeModel::createCode($lang, $text);
        $titelCode = CodeModel::createCode($lang, $name);
        //
        $position = ProductsPageModel::getNextPosition();
        //
        $groupId = mysql_real_escape_string($groupId);
        $img = mysql_real_escape_string($img);
        $quantity = mysql_real_escape_string($quantity);
        $price = mysql_real_escape_string($price);
        $shipping = mysql_real_escape_string($shipping);
        $weight = mysql_real_escape_string($weight);
        $minimumAmount = mysql_real_escape_string($minimumAmount);
        $galleryId = mysql_real_escape_string($galleryId);
        Database::query("insert into t_product(img,shorttextcode,textcode,titelcode,groupid,position,quantity,price,shipping,weight,minimum,galleryid)
            values('$img','$shortTextCode','$textCode','$titelCode','$groupId','$position','$quantity','$price','$shipping','$weight','$minimumAmount','$galleryId')");
        $newId = Database::query("select last_insert_id() as newid from t_product");
        return $newId->newid;
    }

    static function updateProduct ($id,$groupId,$img,$shortText,$text,$name,$quantity,$price,$shipping,$weight,$minimumAmount,$galleryId,$lang) {
        //
        $product = ProductsPageModel::getProduct($id,$lang);
        CodeModel::setCode($product->shorttextcode, $lang, $shortText);
        CodeModel::setCode($product->textcode, $lang, $text);
        CodeModel::setCode($product->titelcode, $lang, $name);
        //
        $id = mysql_real_escape_string($id);
        $groupId = mysql_real_escape_string($groupId);
        $img = mysql_real_escape_string($img);
        $quantity = mysql_real_escape_string($quantity);
        $price = mysql_real_escape_string($price);
        $minimumAmount = mysql_real_escape_string($minimumAmount);
        $galleryId = mysql_real_escape_string($galleryId);
        Database::query("update t_product set 
            img = '$img', quantity = '$quantity', price = '$price', minimum = '$minimumAmount', groupid = '$groupId',
            shipping = '$shipping', weight = '$weight', galleryid = '$galleryId' where id = '$id'");
    }

    static function deleteProduct ($id) {
        //
        $product = ProductsPageModel::getProduct($id);
        CodeModel::deleteCode($product->shorttextcode);
        CodeModel::deleteCode($product->textcode);
        CodeModel::deleteCode($product->titelcode);
        // 
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_product where id = '$id'");
    }

    static function getNextPosition () {
        $result = Database::query("select max(position) as max from t_product");
        return mysql_fetch_object($result)->max + 1;
    }

    /* product groups */

    static function getGroup ($id) {
        $id = mysql_real_escape_string($id);
        $lang = mysql_real_escape_string(Context::getLang());
        return Database::queryAsObject("select c.value as name, g.* from t_product_group g left join t_code c on c.code = g.namecode and c.lang = '$lang' where g.id = '$id'");
    }

    static function createGroup ($name, $group = null) {
        $parentSql = "null";
        if ($parent != null) {
            $parentSql = "'".mysql_real_escape_string($parent)."'";
        }
        $nameCode = CodeModel::createCode(Context::getLang(), $name);
        Database::query("insert into t_product_group(namecode,parent) values('$nameCode',$parentSql)");
        $obj = Database::queryAsObject("select last_insert_id() as newid");
        return $obj->newid;
    }

    static function updateGroup ($id, $name, $parent = null) {
        $id = mysql_real_escape_string($id);
        $parentSql = "null";
        if ($parent != null) {
            $parentSql = "'".mysql_real_escape_string($parent)."'";
        }
        $obj = Database::queryAsObject("select namecode from t_product_group where id = '$id'");
        CodeModel::setCode($obj->namecode,Context::getLang(), $name);
        Database::query("update t_product_group set parent = $parentSql where id = '$id'");
    }

    static function getGroups ($parent = null, $siteId = null) {
        if (empty($siteId)) {
            $siteId = Context::getSiteId();
        }
        $lang = mysql_real_escape_string(Context::getLang());
        if ($parent == null) {
            return Database::queryAsArray("select c.value as name, g.* from t_product_group g left join t_code c on c.code = g.namecode and c.lang = '$lang'");
        }
        $parent = mysql_real_escape_string($parent);
        return Database::queryAsArray("select c.value as name, g.* from t_product_group g left join t_code c on c.code = g.namecode and c.lang = '$lang' where g.parent = '$parent'");
    }

    static function deleteGroup ($id) {
        $id = mysql_real_escape_string($id);
        // delete the products
        Database::query("delete from t_product_group where id = '$id'");
    }

    static function setModuleProductGroup ($moduleId, $groupId) {
        $moduleId = mysql_real_escape_string($moduleId);
        $groupId = mysql_real_escape_string($groupId);
        $obj = Database::queryAsObject("select * from t_product_group_module where moduleid = '$moduleId'");
        if ($obj != null) {
            Database::query("update t_product_group_module set groupid = '$groupId' where moduleid = '$moduleId'");
        } else {
            Database::query("insert into t_product_group_module (groupid,moduleid) values('$groupId','$moduleId')");
        }
    }
    
}


?>
