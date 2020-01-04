<?php

try {
	
	require_once 'core/includes.php';
	
	// start the request context
	Context::startRequest();
	
	try {
	
		// show the page the user is on
		if (Context::getPage() != null) {
	
			// process any module or system actions that need to be run
			ModuleController::processActions();
	
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
			ModuleController::processService(Context::getService());
	
			// render the return value or service
			if (Context::getReturnValue() == null) {
				ModuleController::renderService(Context::getService());
			} else {
				echo Context::getReturnValue();
			}
	
		} else {
			 
			// if the user hasent set a startpage the help page is displayed
			TemplateModel::renderSetupPage();
		}
	
	} catch (Exception $e) {
            printStackTrace($e);
	}
	
	// end the request context
	Context::endRequest();
	
} catch (Exception $e) {
    printStackTrace($e);
}

?>