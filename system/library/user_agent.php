<?php
/**
* User Agent Library
* Parse user_agent information.
*
* @package : User Agent Library
* @category : Library
* @author : Unic Framework
* @link : https://github.com/unic-framework/unic
*/

defined('SYSPATH') OR exit('No direct access allowed');

class user_agent{
  public $ip;
  public $os;
  public $os_version;
  public $browser;
  public $browser_version;
  public $device_type;
  public $device_brand;
  public $referrer;
  public $is_referred;
  public $agent;

  //Initialize all variable
  function __construct() {
    $this->agent = $_SERVER['HTTP_USER_AGENT'];
    $this->ip = $this->get_ip();
    $this->os = $this->get_os();
    $this->os_version = $this->get_os_version();
    $this->browser = $this->get_browser();
    $this->browser_version = $this->get_browser_version();
    $this->device_type = $this->get_device_type();
    $this->device_brand = $this->get_device_brand();
    $this->referrer = $this->get_referrer();
    $this->is_referred = isset($_SERVER['HTTP_REFERER']) ? TRUE : FALSE;
  }

  /**
  * Get IP
  * retrieve user ip address.
  */
  function get_ip() {
    if (isset($_SERVER['HTTP_X_REAL_IP'])){
      $ip = $_SERVER['HTTP_X_REAL_IP'];
    } else if (isset($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED'];
    } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if(isset($_SERVER['HTTP_FORWARDED'])) {
      $ip = $_SERVER['HTTP_FORWARDED'];
    } else if(isset($_SERVER['REMOTE_ADDR'])) {
      $ip = $_SERVER['REMOTE_ADDR'];
    } else {
      $ip = 'UNKNOWN';
    }
    return $ip;
  }

  //parse os from user_agent
  function get_os(){
    $data = array(
      '/android/i' => 'Android',
      '/windows|win32/i' => 'Windows',
      '/iphone|ipod|ipad|iOS/i' => 'iOS',
      '/macintosh|mac os x|mac_powerpc/i' => 'Mac OS',
      '/blackberry|BB/i' => 'BlackBerry',
      '/webos/i' => 'Mobile',
      '/ubuntu/i' => 'Ubuntu',
      '/linux/i' => 'Linux',
      '/unix/i' => 'Unix',
    );
    //Match pattern from User Agent
    foreach($data as $pattern => $os){
      if(preg_match($pattern, $this->agent)){
        return $os;
      }
    }
    return 'UNKNOWN';
  }

  //parse os version from user_agent
  function get_os_version() {
    if ($this->os == 'Android') {
      $data = array(
        '/android 10/i' => '10 Q',
        '/android 9.0/i' => '9.0 Pie',
        '/android 8.1.0/i' => '8.1.0 Oreo',
        '/android 8.1/i' => '8.1 Oreo',
        '/android 8.0/i' => '8.0 Oreo',
        '/android 7.1.2/i' => '7.1.2 Nougat',
        '/android 7.1.1/i' => '7.1.1 Nougat',
        '/android 7.1/i' => '7.1 Nougat',
        '/android 7.0/i' => '7.0 Nougat',
        '/android 6.0.1/i' => '6.0.1 Marshmallow',
        '/android 6.0/i' => '6.0 Marshmallow',
        '/android 5.1.1/i' => '5.1.1 Lollipop',
        '/android 5.1/i' => '5.1 Lollipop',
        '/android 5.0.2/i' => '5.0.2 Lollipop',
        '/android 5.0/i' => '5.0 Lollipop',
        '/android 4.4.4/i' => '4.4.4 KitKat',
        '/android 4.4.2/i' => '4.4.2 KitKat',
        '/android 4.4/i' => '4.4 KitKat',
        '/android 4.3/i' => '4.3 Jelly Bean',
        '/android 4.2.2/i' => '4.2.2 Jelly Bean',
        '/android 4.2/i' => '4.2 Jelly Bean',
        '/android 4.0.4/i' => '4.0.4 IceCream Sandwich',
        '/android 4.0/i' => '4.0 IceCream Sandwich',
        '/android 4.1/i' => '4.1 Jelly Bean',
        '/android 2.3.7/i' => '2.3.7 Gingerbread',
        '/android 2.3.7/i' => '2.3.6 Gingerbread',
        '/android 2.3/i' => '2.3 Gingerbread',
        '/android 2.2.3/i' => '2.2.3 Froyo',
        '/android 2.2/i' => '2.2 Froyo',
      );
      foreach($data as $pattern => $version){
        if(preg_match($pattern, $this->agent)){
          return $version;
        }
      }
      return 'UNKNOWN';
    } else if ($this->os == 'iOS') {
      $data = array(
        '/OS 13/i' => 'iOS 13',
        '/OS 12_0/i' => 'iOS 12',
        '/OS 12/i' => 'iOS 12',
        '/OS 11_0/i' => 'iOS 11',
        '/OS 11/i' => 'iOS 11',
        '/OS 10_3_3/i' => 'iOS 10.3.3',
        '/OS 10_3/i' => 'iOS 10.3',
        '/OS 10_0_1/i' => 'iOS 10.0.1',
        '/OS 10_0/i' => 'iOS 10',
        '/OS 10/i' => 'iOS 10',
        '/OS 9_3_5/i' => 'iOS 9.3.5',
        '/OS 9_3_3/i' => 'iOS 9.3.3',
        '/OS 9_3_2/i' => 'iOS 9.3.2',
        '/OS 9_2_1/i' => 'iOS 9.2.1',
        '/OS 9_2/i' => 'iOS 9.2',
        '/OS 9_1/i' => 'iOS 9.1',
        '/OS 9_0_2/i' => 'iOS 9.0.2',
        '/OS 9_0_1/i' => 'iOS 9.0.1',
        '/OS 9_0/i' => 'iOS 9',
        '/OS 9/i' => 'iOS 9',
        '/OS 8_4_1/i' => 'iOS 8.4.1',
        '/OS 8_4/i' => 'iOS 8.4',
        '/OS 8_3/i' => 'iOS 8.3',
        '/OS 8_2_2/i' => 'iOS 8.2.2',
        '/OS 8_2/i' => 'iOS 8.2',
        '/OS 8_1_3/i' => 'iOS 8.1.3',
        '/OS 8_1_2/i' => 'iOS 8.1.2',
        '/OS 8_1_1/i' => 'iOS 8.1.1',
        '/OS 8_1/i' => 'iOS 8.1',
        '/OS 8_0_2/i' => 'iOS 8.0.2',
        '/OS 8_0/i' => 'iOS 8',
        '/OS 8/i' => 'iOS 8',
        '/OS 7_1_6/i' => 'iOS 7.1.6',
        '/OS 7_1_2/i' => 'iOS 7.1.2',
        '/OS 7_1_1/i' => 'iOS 7.1.1',
        '/OS 7_1/i' => 'iOS 7.1',
        '/OS 7_0_6/i' => 'iOS 7.0.6',
        '/OS 7_0_5/i' => 'iOS 7.0.5',
        '/OS 7_0_4/i' => 'iOS 7.0.4',
        '/OS 7_0_3/i' => 'iOS 7.0.3',
        '/OS 7_0_2/i' => 'iOS 7.0.2',
        '/OS 7_0_1/i' => 'iOS 7.0.1',
        '/OS 7_0/i' => 'iOS 7',
        '/OS 7/i' => 'iOS 7',
        '/OS 6_1_6/i' => 'iOS 6.1.6',
        '/OS 6_0/i' => 'iOS 6',
        '/OS 6/i' => 'iOS 6',
        '/OS 5_1_1/i' => 'iOS 5.1.1',
        '/OS 5_1/i' => 'iOS 5.1',
        '/OS 5_0_1/i' => 'iOS 5.0.1',
        '/OS 5_0/i' => 'iOS 5',
        '/OS 5/i' => 'iOS 5',
        '/OS 4_3_5/i' => 'iOS 4.3.5',
        '/OS 4_3_3/i' => 'iOS 4.3.3',
        '/OS 4_3_2/i' => 'iOS 4.3.2',
        '/OS 4_2_1/i' => 'iOS 4.2.1',
        '/OS 4_2/i' => 'iOS 4.2',
        '/OS 4_0/i' => 'iOS 4',
        '/OS 4/i' => 'iOS 4',
        '/OS 3_2_2/i' => 'iOS 3.2.2',
        '/OS 3_2_1/i' => 'iOS 3.2.1',
        '/OS 3_2/i' => 'iOS 3.2',
        '/OS 3_1_3/i' => 'iOS 3.1.3',
        '/OS 3_0/i' => 'iOS 3',
        '/OS 3/i' => 'iOS 3',
        '/OS 2_1_1/i' => 'iOS 2.2.1',
        '/iPhone/i' => 'iOS',
        '/iPad/i' => 'iOS',
      );
      foreach($data as $pattern => $version){
        if(preg_match($pattern, $this->agent)){
          return $version;
        }
      }
      return 'UNKNOWN';
    } else if($this->os == 'Windows') {
      $data= array(
        '/windows nt 10.0/i' => 'Windows 10',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows xp/i' => 'Windows XP',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
      );
      foreach($data as $pattern => $version){
        if(preg_match($pattern, $this->agent)){
          return $version;
        }
      }
      return 'UNKNOWN';
    } else {
      $data = array(
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux X86_64/i' => 'Linux 64-Bit',
        '/linux i386/i' => 'Linux 32-Bit',
        '/linux i686/i' => 'Linux 32-Bit'
      );
      foreach($data as $pattern => $version){
        if(preg_match($pattern, $this->agent)){
          return $version;
        }
      }
      return 'UNKNOWN';
    }
  }

  //parse browser from user_agent
  function get_browser() {
    $data = array (
      '/msie/i' => 'Internet Explorer',
      '/edge/i' => 'Edge',
      '/firefox/i' => 'Firefox',
      '/SamsungBrowser/i' => 'SamsungBrowser',
      '/UCBrowser/i' => 'UCBrowser',
      '/MiuiBrowser/i' => 'MiuiBrowser',
      '/opera/i' => 'Opera',
      '/netscape/i' => 'Netscape',
      '/maxthon/i' => 'Maxthon',
      '/konqueror/i' => 'Konqueror',
      '/YaBrowser/i' =>  'Yandex Browser',
      '/MxBrowser/i' =>  'MxBrowser',
      '/Chrome/i' =>  'Chrome',
      '/safari/i' => 'Safari',
      '/mobile/i' => 'Handheld Browser'
    );

    foreach($data as $pattern => $browser){
      if(preg_match($pattern, $this->agent)){
        return $browser;
      }
    }
    return 'UNKNOWN';
  }

  //parse browser version from user_agent
  function get_browser_version() {
    $browser = $this->browser;
    $known = array('version', $browser, 'other');
    $pattern = '#(?<browser>'. join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';

    if (!preg_match_all($pattern, $this->agent, $matches)) {
      // we have no matching number just continue
    }

    //see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
      if (strripos($this->agent, 'version') < strripos($this->agent, $browser)){
        $version = $matches['version'][0];
      } else {
        $version = $matches['version'][1];
      }
    } else {
      $version = $matches['version'][0];
    }

    if ($version == null || $version == '') {
      return 'UNKNOWN';
    } else {
      return $version;
    }
  }

  //parse device type from user_agent
  function get_device_type() {
    $data = array(
      '/iphone/i' => 'iPhone',
      '/ipod/i' => 'iPod',
      '/ipad/i' => 'iPad',
      '/blackberry|BB/i' => 'Phone',
      '/webos/i' => 'Mobile',
      '/tablet/i' => 'Tablet',
      '/android/i' => 'Phone',
      '/windows|win32/i' => 'Computer',
      '/macintosh|mac os x|mac_powerpc/i' => 'Computer',
      '/linux/i' => 'Computer',
    );
    foreach($data as $pattern => $type){
      if(preg_match($pattern, $this->agent)){
        return $type;
      }
    }
    return 'UNKNOWN';
  }

  //parse device brand from user_agent
  function get_device_brand() {
    $data = array(
      '/iPhone|iPad|iPod/i' => 'Apple',
      '/macintosh/i' => 'Apple',
      '/SAMSUNG|SM-/i' => 'Samsung',
      '/Sony/i' => 'Sony',
      '/LG/i' => 'LG',
      '/Xiaomi|Redmi/i' => 'Xiaomi',
      '/realme|RMX/i' => 'Realme',
      '/Oppo/i' => 'Oppo',
      '/Vivo/i' => 'Vivo',
      '/Lenovo/i' => 'Lenovo',
      '/karbonn/i' => 'Karbonn',
      '/Panasonic/i' => 'Panasonic',
      '/OnePlus/i' => 'OnePlus',
      '/Nokia/i' => 'Nokia',
      '/Motorola|Moto/i' => 'Motorola',
      '/Meizu/i' => 'Meizu',
      '/Lava/i' => 'Lava',
      '/Intex/i' => 'intex',
      '/HTC/i' => 'HTC',
      '/Google|Pixel/i' => 'Google',
      '/Nexus/i' => 'Nexus',
      '/Gionee/i' => 'Gionee',
      '/BlackBerry|BB/i' => 'BlackBerry',
      '/Asus/i' => 'Asus',
      '/Huawei/i' => 'Huawei',
      '/Micromax/i' => 'Micromax',
      '/Lyf/i' => 'Lyf',
      '/Infinix/i' => 'Infinix',
      '/Tecno/i' => 'Tecno',
      '/ZTE/i' => 'ZTE',
    );
    foreach($data as $pattern => $brand){
      if(preg_match($pattern, $this->agent)){
        return $brand;
      }
    }
    return 'UNKNOWN';
  }

  //checking user is referred or not
  function get_referrer() {
    if ($_SERVER['HTTP_REFERER'] == '') {
      return false;
     } else {
      return $_SERVER['HTTP_REFERER'];
     }
  }

}
