<?php
/**
* Validator Library
* Validator library validates users data and form data, json data.
*
* @package : Validator Library
* @category : Library
* @author : Unic Framework
* @link : https://github.com/unicframework/unic
*/

defined('SYSPATH') OR exit('No direct access allowed');

class validator {
  /**
  * Store validation errors
  *
  * @var array
  */
  private $errors;

  /**
  * Store validation rules
  *
  * @var array
  */
  private $rules;

  /**
  * Store error messages
  *
  * @var array
  */
  private $message;

  /**
  * Store default error messages
  *
  * @var array
  */
  private $default_message;

  /**
  * Store predefined rules
  *
  * @var array
  */
  private $predefined_rules;

  /**
  * Check all data is valid or not
  *
  * @var boolean
  */
  protected $is_valid;

  function __construct() {
    //Predefined data validation rules
    $this->predefined_rules = [
      'required',
      'alphabet',
      'numeric',
      'alphanumeric',
      'lowercase',
      'uppercase',
      'string',
      'integer',
      'float',
      'boolean',
      'array',
      'object',
      'json',
      'minlength',
      'maxlength',
      'min',
      'max',
      'email',
      'file',
      'file_mime_type',
      'file_extension',
      'min_file_size',
      'max_file_size',
      'in',
      'not_in',
      'equal',
      'not_equal',
      'callback',
      'rules'
    ];
  }

  /**
  * Validate
  * Validate users data.
  *
  * @param mixed $data
  * @return boolean
  */
  public function validate($data) : bool {
    $this->is_valid = true;

    //Convert users data type to array
    if(is_object($data)) {
      $data = (array) $data;
    } else if((is_array($data) ? false : is_array(json_decode($data, true)))) {
      $data = json_decode($data, true);
    } else if(!is_array($data)) {
      $this->errors['error'] = 'Invalid data for validation';
      return false;
    }

    //Validate users data
    foreach($this->rules as $key => $value) {
      if(is_array($value)) {
        $rules = $value;
        foreach($rules as $rule => $value) {
          $rule = strtolower($rule);
          if(in_array($rule, $this->predefined_rules)) {
            $func = "validate_".$rule;
            if($this->$func($data, $key, $rules) === false) {
              $this->is_valid = false;
            }
          } else {
            $this->errors['error'] = 'Invalid rules for validation';
            return false;
          }
        }
      } else {
        $this->errors['error'] = 'Invalid rules for validation';
        return false;
      }
    }
    return $this->is_valid;
  }

  /**
  * Set Rules
  * Set validation rules.
  *
  * @param array $rules
  * @return void
  */
  public function rules(array $rules) {
    $this->rules = $rules;
  }

  /**
  * Set Messages
  * Set validation error messages.
  *
  * @param array $messages
  * @return void
  */
  public function messages(array $messages) {
    $this->messages = $messages;
  }

  /**
  * Errors
  * Validation errors.
  *
  * @param string $error
  * @return string|array|void
  */
  public function errors(string $error=NULL) {
    if(isset($error) && is_array($this->errors) && isset($this->errors[$error])) {
      return $this->errors[$error];
    }
    if($error==NULL) {
      return $this->errors;
    }
  }

  /**
  * Set Error
  * Set data validation error.
  *
  * @param string $data_key
  * @param array $rules
  * @param string $rule
  * @param string $custom_rule
  * @return void
  */
  private function set_error(string $data_key, array $rules, string $rule, $custom_rule=NULL) {
    //Default error messages
    $this->default_messages = [
      'required' => $data_key.' is required.',
      'alphabet' => [
        'true' => $data_key.' should be alphabet.',
        'false' => $data_key.' should not be alphabet.'
      ],
      'numeric' => [
        'true' => $data_key.' should be numeric.',
        'false' => $data_key.' should not be numeric.'
      ],
      'alphanumeric' => [
        'true' => $data_key.' should be alphanumeric.',
        'false' => $data_key.' should not be alphanumeric.'
      ],
      'lowercase' => [
        'true' => $data_key.' should be lowercase string.',
        'false' => $data_key.' should not be lowercase string.'
      ],
      'uppercase' => [
        'true' => $data_key.' should be uppercase string.',
        'false' => $data_key.' should not be uppercase string.'
      ],
      'string' => [
        'true' => $data_key.' should be string.',
        'false' => $data_key.' should not be string.'
      ],
      'integer' => [
        'true' => $data_key.' should be integer.',
        'false' => $data_key.' should not be integer.'
      ],
      'float' => [
        'true' => $data_key.' should be float.',
        'false' => $data_key.' should not be float.'
      ],
      'boolean' => [
        'true' => $data_key.' should be boolean.',
        'false' => $data_key.' should not be boolean.'
      ],
      'array' => [
        'true' => $data_key.' should be array.',
        'false' => $data_key.' should not be array.'
      ],
      'object' => [
        'true' => $data_key.' should be object.',
        'false' => $data_key.' should not be object.'
      ],
      'json' => [
        'true' => $data_key.' should be json.',
        'false' => $data_key.' should not be json.'
      ],
      'minlength' => $data_key.' minimum length should be at least '.(isset($rules['minlength']) ? $rules['minlength'] : '').' characters.',
      'maxlength' => $data_key.' maximum length should be '.(isset($rules['maxlength']) ? $rules['maxlength'] : '').' characters.',
      'min' => $data_key.' minimum value should be at least '.(isset($rules['min']) ? $rules['min'] : ''),
      'max' => $data_key.' maximum value should be '.(isset($rules['max']) ? $rules['max'] : ''),
      'email' => [
        'true' => 'Please enter valid email address.',
        'false' => $data_key.' should not be email address.'
      ],
      'file' => [
        'true' => 'Please upload file',
        'false' => $data_key.' should not be file.'
      ],
      'file_mime_type' => $data_key.' invalid file mime type.',
      'file_extension' => $data_key.' invalid file extension.',
      'min_file_size' => $data_key.' minimum file size should be at least '.(isset($rules['min_file_size']) ? $rules['min_file_size'] : '').' bytes.',
      'max_file_size' => $data_key.' maximum file size should be '.(isset($rules['max_file_size']) ? $rules['max_file_size'] : '').' bytes.',
      'in' => $data_key.' invalid data.',
      'not_in' => $data_key.' invalid data.',
      'equal' => $data_key.' invalid data.',
      'not_equal' => $data_key.' invalid data.',
      'callback' => 'Callback function not found.',
      'rules' => $data_key.' invalid data.'
    ];

    if(isset($this->messages[$data_key]) && is_array($this->messages[$data_key])) {
      //Set users custom error messages
      if(isset($this->messages[$data_key][$rule])) {
        if(isset($this->messages[$data_key][$rule][$custom_rule])) {
          $this->errors[$data_key] = $this->messages[$data_key][$rule][$custom_rule];
        } else {
          $this->errors[$data_key] = $this->messages[$data_key][$rule];
        }
      } else {
        //Set default error messages
        if($rules[$rule] === true && is_array($this->default_messages[$rule]) && isset($this->default_messages[$rule]['true'])) {
          $this->errors[$data_key] = $this->default_messages[$rule]['true'];
        } else if($rules[$rule] === false && is_array($this->default_messages[$rule]) && isset($this->default_messages[$rule]['false'])) {
          $this->errors[$data_key] = $this->default_messages[$rule]['false'];
        } else {
          $this->errors[$data_key] = $this->default_messages[$rule];
        }
      }
    //Set users custom error messages
    } else if(isset($this->messages[$data_key])) {
      $this->errors[$data_key] = $this->messages[$data_key];
    } else {
      //Set default error messages
      if($rules[$rule] === true && is_array($this->default_messages[$rule]) && isset($this->default_messages[$rule]['true'])) {
        $this->errors[$data_key] = $this->default_messages[$rule]['true'];
      } else if($rules[$rule] === false && is_array($this->default_messages[$rule]) && isset($this->default_messages[$rule]['false'])) {
        $this->errors[$data_key] = $this->default_messages[$rule]['false'];
      } else {
        $this->errors[$data_key] = $this->default_messages[$rule];
      }
    }
  }

  /**
  * Validate required fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_required(array $data, string $data_key, array $rules) : bool {
    if(!isset($rules['file']) || $rules['file'] === false) {
      if((!isset($data[$data_key]) && $rules['required'] === true)  || (isset($data[$data_key]) && empty($data[$data_key]) && $data[$data_key] !== 0 && $rules['required'] === true)) {
        $this->set_error($data_key, $rules, 'required');
        return false;
      } else {
        return true;
      }
    } else if((!isset($_FILES[$data_key]) && $rules['required'] === true && $rules['file'] === true) || (isset($_FILES[$data_key]) && empty($_FILES[$data_key]) && $_FILES[$data_key] !== 0 && $rules['required'] === true && $rules['file'] === true)) {
      $this->set_error($data_key, $rules, 'required');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate alphabet fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_alphabet(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !ctype_alpha($data[$data_key]) && $rules['alphabet'] === true) {
      $this->set_error($data_key, $rules, 'alphabet');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && ctype_alpha($data[$data_key]) && $rules['alphabet'] === false) {
      $this->set_error($data_key, $rules, 'alphabet');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate numeric fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_numeric(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !is_numeric($data[$data_key]) && $rules['numeric'] === true) {
      $this->set_error($data_key, $rules, 'numeric');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && is_numeric($data[$data_key]) && $rules['numeric'] === false) {
      $this->set_error($data_key, $rules, 'numeric');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate alphanumeric fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_alphanumeric(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !ctype_alnum($data[$data_key]) && $rules['alphanumeric'] === true) {
      $this->set_error($data_key, $rules, 'alphanumeric');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && ctype_alnum($data[$data_key]) && $rules['alphanumeric'] === false) {
      $this->set_error($data_key, $rules, 'alphanumeric');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate lowercase fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_lowercase(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !ctype_lower($data[$data_key]) && $rules['lowercase'] === true) {
      $this->set_error($data_key, $rules, 'lowercase');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && ctype_lower($data[$data_key]) && $rules['lowercase'] === false) {
      $this->set_error($data_key, $rules, 'lowercase');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate uppercase fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_uppercase(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !ctype_upper($data[$data_key]) && $rules['uppercase'] === true) {
      $this->set_error($data_key, $rules, 'uppercase');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && ctype_upper($data[$data_key]) && $rules['uppercase'] === false) {
      $this->set_error($data_key, $rules, 'uppercase');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate string fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_string(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !is_string($data[$data_key]) && $rules['string'] === true) {
      $this->set_error($data_key, $rules, 'string');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && is_string($data[$data_key]) && $rules['string'] === false) {
      $this->set_error($data_key, $rules, 'string');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate integer fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_integer(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !is_int($data[$data_key]) && $rules['integer'] === true) {
      $this->set_error($data_key, $rules, 'integer');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && is_int($data[$data_key]) && $rules['integer'] === false) {
      $this->set_error($data_key, $rules, 'integer');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate float fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_float(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !is_float($data[$data_key]) && $rules['float'] === true) {
      $this->set_error($data_key, $rules, 'float');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && is_float($data[$data_key]) && $rules['float'] === false) {
      $this->set_error($data_key, $rules, 'float');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate boolean fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_boolean(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !is_bool($data[$data_key]) && $rules['boolean'] === true) {
      $this->set_error($data_key, $rules, 'boolean');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && is_bool($data[$data_key]) && $rules['boolean'] === false) {
      $this->set_error($data_key, $rules, 'boolean');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate array fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_array(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !is_array($data[$data_key]) && $rules['array'] === true) {
      $this->set_error($data_key, $rules, 'array');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && is_array($data[$data_key]) && $rules['array'] === false) {
      $this->set_error($data_key, $rules, 'array');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate object fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_object(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !is_object($data[$data_key]) && $rules['object'] === true) {
      $this->set_error($data_key, $rules, 'object');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && is_object($data[$data_key]) && $rules['object'] === false) {
      $this->set_error($data_key, $rules, 'object');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate json fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_json(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !(is_array($data[$data_key]) ? false : is_array(json_decode($data[$data_key], true))) && $rules['json'] === true) {
      $this->set_error($data_key, $rules, 'json');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && (is_array($data[$data_key]) ? false : is_array(json_decode($data[$data_key], true))) && $rules['json'] === false) {
      $this->set_error($data_key, $rules, 'json');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate minlength fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_minlength(array $data, string $data_key, array $rules) : bool {
    if((isset($data[$data_key]) && !is_string($data[$data_key])) || (isset($data[$data_key]) && !empty($data[$data_key]) && !(strlen($data[$data_key]) >= $rules['minlength']))) {
      $this->set_error($data_key, $rules, 'minlength');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate maxlength fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_maxlength(array $data, string $data_key, array $rules) : bool {
    if((isset($data[$data_key]) && !is_string($data[$data_key])) || (isset($data[$data_key]) && !empty($data[$data_key]) && !(strlen($data[$data_key]) <= $rules['maxlength']))) {
      $this->set_error($data_key, $rules, 'maxlength');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate min fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_min(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && is_numeric($data[$data_key]) && !($data[$data_key] >= $rules['min'])) {
      $this->set_error($data_key, $rules, 'min');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate max fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_max(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && is_numeric($data[$data_key]) && !($data[$data_key] <= $rules['max'])) {
      $this->set_error($data_key, $rules, 'max');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate email fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_email(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !filter_var($data[$data_key], FILTER_VALIDATE_EMAIL) && $rules['email'] === true) {
      $this->set_error($data_key, $rules, 'email');
      return false;
    } else if(isset($data[$data_key]) && !empty($data[$data_key]) && filter_var($data[$data_key], FILTER_VALIDATE_EMAIL) && $rules['email'] === false) {
      $this->set_error($data_key, $rules, 'email');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate file fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_file(array $data, string $data_key, array $rules) : bool {
    $is_valid = true;
    if(isset($_FILES[$data_key]['tmp_name']) && is_array($_FILES[$data_key]['tmp_name'])) {
      foreach($_FILES[$data_key]['tmp_name'] as $tmp_name) {
        if(isset($tmp_name) && !empty($tmp_name) && !is_uploaded_file($tmp_name) && $rules['file'] === true) {
          $this->set_error($data_key, $rules, 'file');
          $is_valid = false;
        } else if(isset($tmp_name) && !empty($tmp_name) && is_uploaded_file($tmp_name) && $rules['file'] === false) {
          $this->set_error($data_key, $rules, 'file');
          $is_valid = false;
        }
      }
    } else {
      if(isset($_FILES[$data_key]['tmp_name']) && !empty($_FILES[$data_key]['tmp_name']) && !is_uploaded_file($_FILES[$data_key]['tmp_name']) && $rules['file'] === true) {
        $this->set_error($data_key, $rules, 'file');
        $is_valid = false;
      } else if(isset($_FILES[$data_key]['tmp_name']) && !empty($_FILES[$data_key]['tmp_name']) && is_uploaded_file($_FILES[$data_key]['tmp_name']) && $rules['file'] === false) {
        $this->set_error($data_key, $rules, 'file');
        $is_valid = false;
      }
    }
    return $is_valid;
  }

  /**
  * Validate file mime type fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_file_mime_type(array $data, string $data_key, array $rules) : bool {
    $is_valid = true;
    if(isset($_FILES[$data_key]['tmp_name']) && is_array($_FILES[$data_key]['tmp_name'])) {
      foreach($_FILES[$data_key]['tmp_name'] as $name) {
        if(isset($name) && !empty($name) && !(is_array($rules['file_mime_type']) ? in_array(strtolower(mime_content_type($name)), array_map('strtolower', $rules['file_mime_type'])) : is_string($rules['file_mime_type']) && strtolower(mime_content_type($name)) === strtolower($rules['file_mime_type']))) {
          $this->set_error($data_key, $rules, 'file_mime_type');
          $is_valid = false;
        }
      }
    } else {
      if(isset($_FILES[$data_key]['tmp_name']) && !empty($_FILES[$data_key]['tmp_name']) && !(is_array($rules['file_mime_type']) ? in_array(strtolower(mime_content_type($_FILES[$data_key]['tmp_name'])), array_map('strtolower', $rules['file_mime_type'])) : is_string($rules['file_mime_type']) && strtolower(mime_content_type($_FILES[$data_key]['tmp_name'])) === strtolower($rules['file_mime_type']))) {
        $this->set_error($data_key, $rules, 'file_mime_type');
        $is_valid = false;
      }
    }
    return $is_valid;
  }

  /**
  * Validate file extension fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_file_extension(array $data, string $data_key, array $rules) : bool {
    $is_valid = true;
    if(isset($_FILES[$data_key]['name']) && is_array($_FILES[$data_key]['name'])) {
      foreach($_FILES[$data_key]['name'] as $name) {
        if(isset($name) && !empty($name) && !(is_array($rules['file_extension']) ? in_array(strtolower(pathinfo($name, PATHINFO_EXTENSION)), array_map('strtolower', $rules['file_extension'])) : is_string($rules['file_extension']) && strtolower(pathinfo($name, PATHINFO_EXTENSION)) === strtolower($rules['file_extension']))) {
          $this->set_error($data_key, $rules, 'file_extension');
          $is_valid = false;
        }
      }
    } else {
      if(isset($_FILES[$data_key]['name']) && !empty($_FILES[$data_key]['name']) && !(is_array($rules['file_extension']) ? in_array(strtolower(pathinfo($_FILES[$data_key]['name'], PATHINFO_EXTENSION)), array_map('strtolower', $rules['file_extension'])) : is_string($rules['file_extension']) && strtolower(pathinfo($_FILES[$data_key]['name'], PATHINFO_EXTENSION)) === strtolower($rules['file_extension']))) {
        $this->set_error($data_key, $rules, 'file_extension');
        $is_valid = false;
      }
    }
    return $is_valid;
  }

  /**
  * Validate min file size fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_min_file_size(array $data, string $data_key, array $rules) : bool {
    $is_valid = true;
    if(isset($_FILES[$data_key]['size']) && is_array($_FILES[$data_key]['size'])) {
      foreach($_FILES[$data_key]['size'] as $size) {
        if(isset($size) && !empty($size) && !($size >= $rules['min_file_size'])) {
          $this->set_error($data_key, $rules, 'min_file_size');
          $is_valid = false;
        }
      }
    } else {
      if(isset($_FILES[$data_key]['size']) && !empty($_FILES[$data_key]['size']) && !($_FILES[$data_key]['size'] >= $rules['min_file_size'])) {
        $this->set_error($data_key, $rules, 'min_file_size');
        $is_valid = false;
      }
    }
    return $is_valid;
  }

  /**
  * Validate max file size fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_max_file_size(array $data, string $data_key, array $rules) : bool {
    $is_valid = true;
    if(isset($_FILES[$data_key]['size']) && is_array($_FILES[$data_key]['size'])) {
      foreach($_FILES[$data_key]['size'] as $size) {
        if(isset($size) && !empty($size) && !($size <= $rules['max_file_size'])) {
          $this->set_error($data_key, $rules, 'max_file_size');
          $is_valid = false;
        }
      }
    } else {
      if(isset($_FILES[$data_key]['size']) && !empty($_FILES[$data_key]['size']) && !($_FILES[$data_key]['size'] <= $rules['max_file_size'])) {
        $this->set_error($data_key, $rules, 'max_file_size');
        $is_valid = false;
      }
    }
    return $is_valid;
  }

  /**
  * Validate in fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_in(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && !(is_array($rules['in']) ? in_array($data[$data_key], $rules['in']) : $data[$data_key] == $rules['in'])) {
      $this->set_error($data_key, $rules, 'in');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate not in fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_not_in(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && (is_array($rules['not_in']) ? in_array($data[$data_key], $rules['not_in']) : $data[$data_key] === $rules['not_in'])) {
      $this->set_error($data_key, $rules, 'not_in');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate equal fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_equal(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && $data[$data_key] !== $rules['equal']) {
      $this->set_error($data_key, $rules, 'equal');
      return false;
    } else {
      return true;
    }
  }

  /**
  * Validate not equal fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_not_equal(array $data, string $data_key, array $rules) : bool {
    if(isset($data[$data_key]) && !empty($data[$data_key]) && $data[$data_key] === $rules['not_equal']) {
      $this->set_error($data_key, $rules, 'not_equal');
      return false;
    } else {
      return true;
    }
  }

  /**
  *  Call callback function
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_callback(array $data, string $data_key, array $rules) : bool {
    $is_valid = true;
    if(isset($rules['callback']) && !empty($rules['callback']) && is_array($rules['callback'])) {
      foreach($rules['callback'] as $callback) {
        if(is_callable($callback)) {
          $callback();
        } else if(function_exists($callback)) {
          $callback();
        } else {
          $this->set_error($data_key, $rules, 'callback');
          $is_valid = false;
        }
      }
    } else if(isset($rules['callback']) && !empty($rules['callback']) && is_string($rules['callback'])) {
      if(is_callable($rules['callback'])) {
        $rules['callback']();
      } else if(function_exists($rules['callback'])) {
        $rules['callback']();
      } else {
        $this->set_error($data_key, $rules, 'callback');
        $is_valid = false;
      }
    } else if(is_callable($rules['callback'])) {
      $rules['callback']();
    }
    return $is_valid;
  }

  /**
  * Validate custom fields.
  *
  * @param array $data
  * @param string $data_key
  * @param array $rules
  * @return boolean
  */
  private function validate_rules(array $data, string $data_key, array $rules) : bool {
    $is_valid = true;
    if(isset($data[$data_key]) && !empty($data[$data_key])) {
      if(is_array($rules['rules'])) {
        foreach($rules['rules'] as $custom_rule => $value) {
          if($value !== true) {
            $this->set_error($data_key, $rules, 'rules', $custom_rule);
            $is_valid = false;
          }
        }
      }
    }
    return $is_valid;
  }
}
