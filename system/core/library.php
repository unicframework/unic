<?php
/**
* Library
* Library middleware is system default middleware, this middleware handle application libraries.
*
* @package : Library
* @category : System Middleware
* @author : Unic Framework
* @link : https://github.com/unic-framework/unic
*/

defined('SYSPATH') OR exit('No direct access allowed');

//Global library
$library_list = array();

class library {

  /**
  * Store all libraries array.
  *
  * @var array
  */
  private $libraries;

  function __construct() {
    global $libraries;
    if(isset($libraries)) {
      $this->libraries = $this->parse_library($libraries);
    } else {
      $this->libraries = array();
    }
  }

  /**
  * Parse Library
  *
  * @param array $libraries
  * @return array
  */
  private function parse_library($libraries) {
    $library_list = array();
    //Parse user libraries
    if(is_array($libraries)) {
      if(!empty($libraries)) {
        foreach($libraries as $lib_path => $obj) {
          //Check if library has object name
          if(!is_int($lib_path)) {
            //Check system libraries
            list($system, $library) = explode('.', $lib_path);
            if(strtolower($system) === 'system') {
              //Get library name
              $class_name = $library;
              //Get library alias name
              $object_name = $obj;
              //Get library path
              $file_path = SYSPATH.'/library/'.trim($library).'.php';
            } else {
              //Get library name
              $class_name = basename($lib_path);
              //Get library alias name
              $object_name = $obj;
              //Get library path
              $file_path = BASEPATH.'/application/'.trim($lib_path, '/').'.php';
            }
          } else {
            //Check system libraries
            list($system, $library) = explode('.', $obj);
            if(strtolower($system) === 'system') {
              //Get library name
              $class_name = $library;
              //Get library alias name
              $object_name = $library;
              //Get library path
              $file_path = SYSPATH.'/library/'.trim($library).'.php';
            } else {
              //Get library name
              $class_name = basename($obj);
              //Get library alias name
              $object_name = $class_name;
              //Get library path
              $file_path = BASEPATH.'/application/'.trim($obj, '/').'.php';
            }
          }
          $library_list[] = [
            'path' => $file_path,
            'class' => $class_name,
            'object' => $object_name,
          ];
        }
      }
    } else {
      exit("Error : 'library' invalid format");
    }
    return $library_list;
  }

  /**
  * Load Library
  * Load application libraries.
  *
  * @return void
  */
  public function load_library() {
    global $library_list;
    foreach($this->libraries as $library) {
      //Check library exists or not
      if(file_exists($library['path'])) {
        require_once($library['path']);
        if(class_exists($library['class'])) {
          $library_list[$library['object']] = new $library['class']();
        } else {
          exit("Error : '".$library['class']."' library class not found");
        }
      } else {
        exit("Error : '".$library['path']."' library file not found");
      }
    }
  }
}
