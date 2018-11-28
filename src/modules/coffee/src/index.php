<?php 

require_once("server/includes.php");

Request::start();

switch (Request::getResource()) {
    case "css":
        UI::printCss();
        break;
    case "js":
        UI::printJs();
        break;
    default:
        $view = Request::getView();
        $view->process();
        UI::handelView($view);
}

Request::end();

?>