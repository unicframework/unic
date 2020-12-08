<?php
/**
* System Autoloader
* Autoload framework system files.
*
* @package : Autoloader
* @category : System
* @author : Unic Framework
* @link : https://github.com/unic-framework/unic
*/

defined('SYSPATH') OR exit('No direct access allowed');

//Load system files
if(file_exists(SYSPATH.'/core/url_dispatcher.php')) {
  require_once SYSPATH.'/core/url_dispatcher.php';
} else {
  exit('Error : system urls dispatcher not found.');
}

if(file_exists(SYSPATH.'/core/library.php')) {
  require_once SYSPATH.'/core/library.php';
} else {
  exit('Error : system library not found.');
}

if(file_exists(SYSPATH.'/core/file_handler.php')) {
  require_once SYSPATH.'/core/file_handler.php';
} else {
  exit('Error : system file handler not found.');
}

if(file_exists(SYSPATH.'/core/request.php')) {
  require_once SYSPATH.'/core/request.php';
} else {
  exit('Error : system request not found.');
}

if(file_exists(SYSPATH.'/core/response.php')) {
  require_once SYSPATH.'/core/response.php';
} else {
  exit('Error : system response not found.');
}

if(file_exists(SYSPATH.'/core/models.php')) {
  require_once SYSPATH.'/core/models.php';
} else {
  exit('Error : system model not found.');
}

if(file_exists(SYSPATH.'/core/views.php')) {
  require_once SYSPATH.'/core/views.php';
} else {
  exit('Error : system view not found.');
}

if(file_exists(SYSPATH.'/core/session.php')) {
  require_once SYSPATH.'/core/session.php';
} else {
  exit('Error : system session not found.');
}

if(file_exists(SYSPATH.'/core/cookie.php')) {
  require_once SYSPATH.'/core/cookie.php';
} else {
  exit('Error : system cookie not found.');
}

if(file_exists(SYSPATH.'/core/middleware.php')) {
  require_once SYSPATH.'/core/middleware.php';
} else {
  exit('Error : system middleware not found.');
}

if(file_exists(SYSPATH.'/core/router.php')) {
  require_once SYSPATH.'/core/router.php';
} else {
  exit('Error : system router not found.');
}


//Load application urls file
if(file_exists(BASEPATH.'/application/urls.php')) {
  require_once BASEPATH.'/application/urls.php';
} else {
  exit('Error : application urls file not found.');
}

//Load application settings file
if(file_exists(BASEPATH.'/application/settings.php')) {
  require_once BASEPATH.'/application/settings.php';
} else {
  exit('Error : application settings file not found.');
}

//Load system error handler
if(file_exists(SYSPATH.'/core/error_handler.php')) {
  require_once SYSPATH.'/core/error_handler.php';
} else {
  exit('Error : system error handler not found.');
}