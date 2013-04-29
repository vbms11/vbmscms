<?php

require_once("core/model/menuModel.php");

class MenuStylesModule extends XModule {

    function onProcess () {
        switch (parent::getAction()) {
            default:
        }
    }

    function onView () {
        switch (parent::getAction()) {
            default:
                $this->printMainView();
        }
    }

    function getRoles () {
        return array();
    }

    function getStyles () {
        return array();
    }

    function getScripts () {
        return array();
    }

    function printMainView () {
        header('Content-type: text/css');
        $menuStyles = MenuModel::getMenuStyles();
        foreach ($menuStyles as $menuStyle) {
            echo $menuStyle->cssstyle.PHP_EOL;
        }
    }
}

?>