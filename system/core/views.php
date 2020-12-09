<?php
/**
* View
* View middleware is system default middleware, this middleware handle application views and response.
*
* @package : Views
* @category : System Middleware
* @author : Unic Framework
* @link : https://github.com/unicframework/unic
*/

defined('SYSPATH') OR exit('No direct access allowed');

class Views extends response {
  /**
  * Application base url
  *
  * @var string
  */
  protected $base_url;

  /**
  * Application static files base url
  *
  * @var string
  */
  protected $static_url;

  protected function __construct() {
    global $library_list;
    parent::__construct();

    //Get application base url
    $this->base_url = $this->url();

    //Get static dir base url
    $this->static_url = $this->static();

    foreach($library_list as $obj => $library) {
      $this->$obj = &$library_list[$obj];
    }
  }

  /**
  * Base URL
  * Base URL generate the absolute url of any path and it will also return site base url.
  *
  * @param string $path
  * @return string
  */
  protected function url(string $path=NULL) {
    $base_url = ((isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS'])!== 'off') ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/';
    if(isset($path)) {
      $path = ltrim($path, '/');
      return rtrim($base_url, '/').'/'.$path;
    } else {
      return $base_url;
    }
  }

  /**
  * Static URL
  * Static URL return static files URL and generate absolute URL of any path.
  *
  * @param string $path
  * @retutn string
  */
  protected function static(string $path=NULL) {
    global $static_url;
    $static = rtrim($this->url(), '/').'/'.ltrim($static_url, '/');
    if(isset($path)) {
      $path = ltrim($path, '/');
      return rtrim($static, '/').'/'.$path;
    } else {
      return $static;
    }
  }

  /**
  * Raise
  * Raise user defined custom error.
  *
  * @param string $errstr
  * @param integer $error
  * @return void
  */
  protected function raise(string $errstr, $error = E_USER_ERROR) {
    trigger_error($errstr, $error);
  }
}
