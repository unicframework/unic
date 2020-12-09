<?php
/**
* Security Library
* Security Library provide security to the web application.
* This Library provide XSS, CSRF protection.
*
* @package : Security Library
* @category : Library
* @author : Unic Framework
* @link : https://github.com/unicframework/unic
*/

defined('SYSPATH') OR exit('No direct access allowed');

class security {
  /**
  * Get csrf_token
  * Generate csrf token and get csrf token.
  *
  * @return string|boolean
  */
  public function get_csrf_token() {
    //Check csrf token is already generated or not
    if(isset($_COOKIE['csrf_token'])) {
      return $_COOKIE['csrf_token'];
    } else if(isset($_SESSION['csrf_token'])) {
      return $_SESSION['csrf_token'];
    } else {
      //Generate csrf token
      if(function_exists('random_bytes')) {
        $token = bin2hex(random_bytes(32));
      } else {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
      }
      //Set csrf_token in cookie or session
      if(isset($token)) {
        //Set csrf_token cookie
        setcookie('csrf_token', '', time()+(60*30), '/');
        if(isset($_COOKIE['csrf_token'])) {
          $_COOKIE['csrf_token'] = $token;
        } else {
          if(!session_id()) {
            session_start();
          }
          $_SESSION['csrf_token'] = $token;
        }
      }
      //Check token is generated or not
      if((isset($_COOKIE['csrf_token']) && isset($token) || isset($_SESSION['csrf_token'])) && isset($token)) {
        return $token;
      } else {
        return FALSE;
      }
    }
  }

  /**
  * Generate csrf_token
  * Get csrf token form input.
  *
  * @return void
  */
  public function csrf_token() {
    //Check csrf token is already generated or not
    if(isset($_COOKIE['csrf_token'])) {
      echo '<input type="text" name="csrf_token" value="'.$_COOKIE['csrf_token'].'" hidden>';
    } else if(isset($_SESSION['csrf_token'])) {
      echo '<input type="text" name="csrf_token" value="'.$_SESSION['csrf_token'].'" hidden>';
    } else {
      //Generate csrf token
      if(function_exists('random_bytes')) {
        $token = bin2hex(random_bytes(32));
      } else {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
      }
      //Set csrf_token in cookie or session
      if(isset($token)) {
        //Set csrf_token cookie
        setcookie('csrf_token', '', time()+(60*30), '/');
        if(isset($_COOKIE['csrf_token'])) {
          $_COOKIE['csrf_token'] = $token;
        } else {
          if(!session_id()) {
            session_start();
          }
          $_SESSION['csrf_token'] = $token;
        }
      }
      //Check token is generated or not
      if((isset($_COOKIE['csrf_token']) && isset($token) || isset($_SESSION['csrf_token'])) && isset($token)) {
        echo '<input type="text" name="csrf_token" value="'.$token.'" hidden>';
      }
    }
  }

  /**
  * Verify csrf_token
  * Validate csrf token.
  *
  * @param string $csrf_var
  * @return boolean
  */
  public function csrf_verify(string $csrf_var=NULL) : bool {
    //Check csrf_token variable is set or not
    if(!$csrf_var) {
      $csrf_var='csrf_token';
    }
    //Get request method
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    //Get csrf token
    if(isset($_COOKIE['csrf_token'])) {
      $token = $_COOKIE['csrf_token'];
      unset($_COOKIE['csrf_token']);
      setcookie('csrf_token', '', -1, '/');
    } else {
      if(!session_id()) {
        session_start();
      }
      if(isset($_SESSION['csrf_token'])) {
        $token = $_SESSION['csrf_token'];
        unset($_SESSION['csrf_token']);
      }
    }
    //Get csrf token from request
    if($method === 'POST' && isset($_POST[$csrf_var])) {
      $token_var = $_POST[$csrf_var];
    } else if($method === 'GET' && isset($_GET[$csrf_var])) {
      $token_var = $_GET[$csrf_var];
    } else {
      //Parse any request data
      parse_str(file_get_contents('php://input'), $request_data);
      if(isset($request_data[$csrf_var])) {
        $token_var = $request_data[$csrf_var];
      } else {
        $token_var = NULL;
      }
    }
    //Verify csrf token
    if(isset($token_var) && isset($token) && hash_equals($token_var, $token)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }


  /**
  * XSS Protection
  * Provide XSS Protection with XSS Clean.
  *
  * @param string $xss_string
  * @return string
  */
  public function xss_clean(string $xss_string) {
    //Convert all characters to HTML entities
    return htmlentities($xss_string, ENT_QUOTES | ENT_IGNORE);
  }

  /**
  * Encrypt
  * AES-256-CBC encryption.
  *
  * @param mixed $plaintext
  * @param mixed $secret_key
  * @param string $encoding
  * @return string
  */
  function encrypt($plaintext, $secret_key, $encoding = 'base64') {
    $iv = openssl_random_pseudo_bytes(16);
    $ciphertext = openssl_encrypt($plaintext, 'AES-256-CBC', hash('sha256', $secret_key, true), OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext.$iv, hash('sha256', $secret_key, true), true);
    return $encoding == 'hex' ? bin2hex($iv.$hmac.$ciphertext) : ($encoding == 'base64' ? base64_encode($iv.$hmac.$ciphertext) : $iv.$hmac.$ciphertext);
  }

  /**
  * Decrypt
  * Decrypt encrypted ciphertext.
  *
  * @param string $ciphertext
  * @param mixed $secret_key
  * @param string $encoding
  * @return string
  */
  function decrypt($ciphertext, $secret_key, $encoding = 'base64') {
    $ciphertext = $encoding == 'hex' ? hex2bin($ciphertext) : ($encoding == 'base64' ? base64_decode($ciphertext) : $ciphertext);
    if(!hash_equals(hash_hmac('sha256', substr($ciphertext, 48).substr($ciphertext, 0, 16), hash('sha256', $secret_key, true), true), substr($ciphertext, 16, 32))) {
      return null;
    } else {
      return openssl_decrypt(substr($ciphertext, 48), "AES-256-CBC", hash('sha256', $secret_key, true), OPENSSL_RAW_DATA, substr($ciphertext, 0, 16));
    }
  }
}
