<?php

class ProductsPageModel {

    static function setPosition ($id, $position) {
        $id = Database::escape($id);
        $position = Database::escape($position);
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
        $groupId = Database::escape($groupId);
        $lang = Database::escape($lang == null ? Context::getLang() : $lang);
        return Database::queryAsArray("select c1.value as titel, c2.value as text, c3.value as shortext, p.* from t_product p
                                        left join t_code c1 on p.titelcode = c1.code and c1.lang = '$lang'
                                        left join t_code c2 on p.textcode = c2.code and c2.lang = '$lang'
                                        left join t_code c3 on p.shorttextcode = c3.code and c3.lang = '$lang'
                                        where p.groupid = '$groupId' order by p.position");
    }
    
    function getAllProducts ($lang=null) {
        $lang = Database::escape($lang == null ? Context::getLang() : $lang);
        return Database::queryAsArray("select c1.value as titel, c2.value as text, c3.value as shortext, p.* from t_product p
                                        left join t_code c1 on p.titelcode = c1.code and c1.lang = '$lang'
                                        left join t_code c2 on p.textcode = c2.code and c2.lang = '$lang'
                                        left join t_code c3 on p.shorttextcode = c3.code and c3.lang = '$lang'
                                        where order by p.position");
    }

    static function getProduct ($id, $lang=null) {
        $id = Database::escape($id);
        if ($lang == null) {
            $lang = Context::getLang();
        }
        $lang = Database::escape($lang);
        return Database::queryAsObject("select c1.value as titel, c2.value as text, c3.value as shorttext, p.* from t_product p
                                    left join t_code c1 on p.titelcode = c1.code and c1.lang = '$lang'
                                    left join t_code c2 on p.textcode = c2.code and c2.lang = '$lang'
                                    left join t_code c3 on p.shorttextcode = c3.code and c3.lang = '$lang'
                                    where p.id = '$id'");
    }

    static function createProduct ($groupId,$img,$shortText,$text,$name,$quantity,$price,$shipping,$weight,$minimumAmount,$galleryId,$lang) {
        //
        $shortTextCode = CodeModel::createCode($lang, $shortText);
        $textCode = CodeModel::createCode($lang, $text);
        $titelCode = CodeModel::createCode($lang, $name);
        //
        $position = ProductsPageModel::getNextPosition();
        //
        $groupId = Database::escape($groupId);
        $img = Database::escape($img);
        $quantity = Database::escape($quantity);
        $price = Database::escape($price);
        $shipping = Database::escape($shipping);
        $weight = Database::escape($weight);
        $minimumAmount = Database::escape($minimumAmount);
        $galleryId = Database::escape($galleryId);
        Database::query("insert into t_product(img,shorttextcode,textcode,titelcode,groupid,position,quantity,price,shipping,weight,minimum,galleryid)
            values('$img','$shortTextCode','$textCode','$titelCode','$groupId','$position','$quantity','$price','$shipping','$weight','$minimumAmount','$galleryId')");
        $newId = Database::query("select max(id) as newid from t_product");
        return $newId->newid;
    }

    static function updateProduct ($id,$groupId,$img,$shortText,$text,$name,$quantity,$price,$shipping,$weight,$minimumAmount,$galleryId,$lang) {
        //
        $product = ProductsPageModel::getProduct($id,$lang);
        CodeModel::setCode($product->shorttextcode, $lang, $shortText);
        CodeModel::setCode($product->textcode, $lang, $text);
        CodeModel::setCode($product->titelcode, $lang, $name);
        //
        $id = Database::escape($id);
        $groupId = Database::escape($groupId);
        $img = Database::escape($img);
        $quantity = Database::escape($quantity);
        $price = Database::escape($price);
        $minimumAmount = Database::escape($minimumAmount);
        $galleryId = Database::escape($galleryId);
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
        $id = Database::escape($id);
        Database::query("delete from t_product where id = '$id'");
    }

    static function getNextPosition () {
        $result = Database::queryAsObject("select max(position) as max from t_product");
        return $result->max + 1;
    }

    /* product groups */

    static function getGroup ($id) {
        $id = Database::escape($id);
        $lang = Database::escape(Context::getLang());
        return Database::queryAsObject("select c.value as name, g.* from t_product_group g left join t_code c on c.code = g.namecode and c.lang = '$lang' where g.id = '$id'");
    }

    static function createGroup ($name, $group = null) {
        $parentSql = "null";
        if ($parent != null) {
            $parentSql = "'".Database::escape($parent)."'";
        }
        $nameCode = CodeModel::createCode(Context::getLang(), $name);
        Database::query("insert into t_product_group(namecode,parent) values('$nameCode',$parentSql)");
        $obj = Database::queryAsObject("select max(id) as newid");
        return $obj->newid;
    }

    static function updateGroup ($id, $name, $parent = null) {
        $id = Database::escape($id);
        $parentSql = "null";
        if ($parent != null) {
            $parentSql = "'".Database::escape($parent)."'";
        }
        $obj = Database::queryAsObject("select namecode from t_product_group where id = '$id'");
        CodeModel::setCode($obj->namecode,Context::getLang(), $name);
        Database::query("update t_product_group set parent = $parentSql where id = '$id'");
    }

    static function getGroups ($parent = null, $siteId = null) {
        if (empty($siteId)) {
            $siteId = Context::getSiteId();
        }
        $lang = Database::escape(Context::getLang());
        if ($parent == null) {
            return Database::queryAsArray("select c.value as name, g.* from t_product_group g left join t_code c on c.code = g.namecode and c.lang = '$lang'");
        }
        $parent = Database::escape($parent);
        return Database::queryAsArray("select c.value as name, g.* from t_product_group g left join t_code c on c.code = g.namecode and c.lang = '$lang' where g.parent = '$parent'");
    }

    static function deleteGroup ($id) {
        $id = Database::escape($id);
        // delete the products
        Database::query("delete from t_product_group where id = '$id'");
    }

    static function setModuleProductGroup ($moduleId, $groupId) {
        $moduleId = Database::escape($moduleId);
        $groupId = Database::escape($groupId);
        $obj = Database::queryAsObject("select * from t_product_group_module where moduleid = '$moduleId'");
        if ($obj != null) {
            Database::query("update t_product_group_module set groupid = '$groupId' where moduleid = '$moduleId'");
        } else {
            Database::query("insert into t_product_group_module (groupid,moduleid) values('$groupId','$moduleId')");
        }
    }
    
}


?>
