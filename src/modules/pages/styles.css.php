<?php

header('Content-type: text/css');

require_once("../../config.php");
require_once("../../core/util/database.php");
require_once("../../core/model/menuModel.php");

$menuStyles = MenuModel::getMenuStyles();

foreach ($menuStyles as $menuStyle) {
    echo $menuStyle->cssstyle.PHP_EOL;
}

?>