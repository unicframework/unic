<?php
/**
* Unic Framework
*
* A high performance, open source web application framework.
*
* @package : Unic Framework
* @author : Rajkumar Dusad
* @copyright : Rajkumar Dusad
* @license : MIT License
* @link : https://github.com/unic-framework/unic
*/

//System path
define('SYSPATH', rtrim(__DIR__, '/'));

//Application base path
define('BASEPATH', rtrim(dirname(__DIR__), '/'));

//Include system autoloader
include_once(SYSPATH.'/core/autoloader.php');

//Include composer autoloader
if(file_exists(BASEPATH.'/vendor/autoload.php')) {
  include_once(BASEPATH.'/vendor/autoload.php');
}

//Set unic error handler
set_error_handler('handleError');

/**
* Debug setting
* Set the error_reporting directive at runtime.
*/
if($debug === FALSE) {
  //turn off all error reporting.
  error_reporting(0);
  if(function_exists('ini_set')) {
    ini_set('display_errors', 0);
  }
} else {
  //turn on all error reporting.
  //It will display E_ERROR, E_WARNING, and E_PARSE error, it will not display any E_NOTICE and other error. to display all errors use E_ALL or -1 in error_reporting.
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
}

/*
* Unic Framework
* Initialize web application and handle request.
*
* @package : Unic
* @category : System
* @author : Unic Framework
* @link : https://github.com/unic-framework/unic
*/
class unic {
  function __construct() {
    //Create router object
    $this->router = new router();
  }

  /**
  * Run web application
  * Listen request and handle routes.
  */
  function run() {
    //Handle request
    $this->router->handle_routes();
  }
}
