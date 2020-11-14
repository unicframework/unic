<?php
/**
* Models
* Model Class is handle all the database settings and database transactions.
*
* @package : Model
* @category : System
* @author : Unic Framework
* @link : https://github.com/unic-framework/unic
*/

defined('SYSPATH') OR exit('No direct access allowed');

//Live database connections
$live_connections = array();

class Models {

  /**
  * Connect
  * Initialize database connection manually.
  *
  * @param array $db_name
  * @return void
  */
  protected function connect(...$db_name) {
    global $db, $live_connections;

    //Parse dbname
    if(!is_array($db_name)) {
      $db_name = array($db_name);
    }

    foreach($db_name as $name) {
      //Check db connection already exists or not
      if($live_connections[$name] != false) {
        //Already connected
        $this->$name = $live_connections[$name];
      } else {
        //Check db settings
        if(is_array($db)) {
          $db_setting_array = $db;
        } else {
          exit('Invalid database setting');
        }

        //Parse database settings
        $db_setting = $this->parse_db($db_setting_array, $db_name);

        //Initialize database connection
        $this->load_driver($db_setting, $db_name);
      }
    }
  }

  /**
  * Load Driver
  * Load database driver.
  *
  * @param array $db_setting
  * @param array $connect
  * @return mixed
  */
  private function load_driver(array $db_setting, array $connect) {
    global $live_connections;
    //Check db driver exists or not
    foreach($connect as $name) {
      //Check database setting exists or not
      if(array_key_exists($name, $db_setting)) {
        $driver_name = strtolower($db_setting[$name]['driver']);
        if(file_exists(SYSPATH.'/database/'.$driver_name.'_driver.php')) {
          include_once(SYSPATH.'/database/'.$driver_name.'_driver.php');
          $driver = $driver_name.'_db_driver';
          if(class_exists($driver)) {
            $live_connections[$name]=new $driver($db_setting, $name);
            $this->$name = &$live_connections[$name];
          } else {
             exit("'".$db_setting[$name]['driver']."' : Database driver not found");
          }
        } else {
          exit("'".$db_setting[$name]['driver']."' : Database driver not found");
        }
      } else {
          exit("'".$name."' : Database setting not found");
      }
    }
  }

  /**
  * Parse DB
  * Parse database connection settings.
  *
  * @param array $db
  * @param array $connect
  * @return array
  */
  private function parse_db(array $db, array $connect) : array {
    //Set db_config default data type.
    $db_config=array();
    foreach($connect as $name) {
      //Check database setting exists or not
      if(array_key_exists($name, $db)) {
        if($db[$name]['dsn']==NULL) {
          $db_config[$name]['dsn']=NULL;
        } else {
          $db_config[$name]['dsn']=$db[$name]['dsn'];
        }
        if($db[$name]['hostname']==NULL) {
          $db_config[$name]['hostname']=NULL;
        } else {
          $db_config[$name]['hostname']=$db[$name]['hostname'];
        }
        if($db[$name]['port']==NULL) {
          $db_config[$name]['port']=NULL;
        } else {
          $db_config[$name]['port']=$db[$name]['port'];
        }
        if($db[$name]['username']==NULL) {
          $db_config[$name]['username']=NULL;
        } else {
          $db_config[$name]['username']=$db[$name]['username'];
        }
        if($db[$name]['password']==NULL) {
          $db_config[$name]['password']=NULL;
        } else {
          $db_config[$name]['password']=$db[$name]['password'];
        }
        if($db[$name]['database']==NULL) {
          $db_config[$name]['database']=NULL;
        } else {
          $db_config[$name]['database']=$db[$name]['database'];
        }
        if($db[$name]['driver']==NULL) {
          $db_config[$name]['driver']=NULL;
        } else {
          $db_config[$name]['driver']=$db[$name]['driver'];
        }
        if($db[$name]['char_set']==NULL) {
          $db_config[$name]['char_set']=NULL;
        } else {
          $db_config[$name]['char_set']=$db[$name]['char_set'];
        }
      } else {
        exit("'".$name."' : Database setting not found");
      }
    }
    return $db_config;
  }
}
