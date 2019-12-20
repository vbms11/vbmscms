<?php

class CategoryModel {
    
    static function getCategory ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_category where id = '$id'");
    }
    
    static function getCategorys ($siteId) {
        $siteId = Database::escape($siteId);
        return Database::queryAsArray("select * from t_category where siteid = '$siteId'");
    }
    
    static function deleteCategory ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_category_image where categoryid = '$id'");
        Database::query("delete from t_category_video where categoryid = '$id'");
        Database::query("delete from t_category where id = '$id'");
    }
    
    static function createCategory ($name,$siteId) {
        $name = Database::escape($name);
        $siteId = Database::escape($siteId);
        Database::query("insert into t_category (name,siteid) values ('$name','$siteId')");
    }
    
    // all
    
    static function getCategorysAssigned () {
        "select distinct c.id, c.name from t_category c right join t_category_assign ca on c.id = ca.categoryid where 1 "
    }
    
    
    // image
    
    static function getCategoryImageIds ($categoryId) {
        $categoryId = Database::escape($categoryId);
        return Database::queryAsArray("select imageid from t_category_image where categoryid = '$categoryId'");
    }
    
    // video
}

?>