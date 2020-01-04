<?php



function createUniqueId ($name) {
    $name = Database::escape($name);
    Database::query("select maxid from t_uniqueid u where u.name = '$name'");
}


