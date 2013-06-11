<?php

require_once 'core/common.php';
require_once 'core/model/pagesModel.php';
require_once 'core/model/moduleModel.php';
require_once 'core/model/templateModel.php';

// start the request context
Context::startRequest();

// show the page the user is on
if (Context::getPage() != null) {
    
    // process any module or system actions that need to be run
    ModuleModel::processActions();
    
    // check if a return value is already known
    if (Context::getReturnValue() !== null) {
        // render the return value
        echo Context::getReturnValue();
    } else {
        // render the page using selected template
        Context::getRenderer()->invokeRender();
    }

} else if (Context::getService() != null) {
    
    // run the service
    ModuleModel::processService(Context::getService());
    
    // render the return value or service
    if (Context::getReturnValue() == null) {
        ModuleModel::renderService(Context::getService());
    } else {
        echo Context::getReturnValue();
    }
    
} else {
    
    // if the user hasent set a startpage the help page is displayed
    TemplateModel::renderSetupPage();
}

// end the request context
Context::endRequest();

?>