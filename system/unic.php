<?php
/**
* Unic Framework
*
* A high performance, open source web application framework.
*
* @package : Unic Framework
* @author : Rajkumar Dusad
* @copyright : Unic Framework
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
