<?php

/* This file registers error handlers. Errors are printed then exit is called
 * 
 * @author: vbms
 */

function print_error ($errno, $errstr, $errfile = "", $errline = -1, $errcontext = array()) {
	
	$error = error_get_last();

	if( $error !== NULL) {
		$errno   = $error["type"];
		$errfile = $error["file"];
		$errline = $error["line"];
		$errstr  = $error["message"];
	}

}

function error_handler () {

}

function fatal_error_handler () {

}

// set_error_handler("error_handler");
// register_shutdown_function('fatal_error_handler');

?>
