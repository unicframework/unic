<?php
/**
* Validator Library
* Validator library validates users data and form data, json data.
*
* @package : Validator Library
* @category : Library
* @author : Unic Framework
* @link : https://github.com/unic-framework/unic
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
  * Store predefined rules
  *
  * @var array
  */
  private $predefined_rules;

  function __construct() {
    //Predefined validation rules
    $this->predefined_rules = [
      'required',
      'numeric',
      'string',
      'integer',
      'float',
      'boolean',
      'array',
      'object',
      'json',
      'minlength',
      'maxlength',
      'email',
      'file',
      'file_mime_type',
      'file_extension',
      'min_file_size',
      'max_file_size',
      'in',
      'not_in'
    ];
  }

  /**
  * Validate
  * Validate users data.
  *
  * @param mixed $data
  * @return boolean
  */
  function validate($data) : bool {
    //Check all data is valid or not
    $is_valid = true;

    //Convert data type to array
    if(is_object($data)) {
      $data = (array) $data;
    } else if((is_array($data) ? false : is_array(json_decode($data, true)))) {
      $data = json_decode($data, true);
    } else if(!is_array($data)) {
      $this->errors['error'] = 'Invalid data for validation';
      return false;
    }

    //Validate users data
    foreach($this->rules as $key => $val) {
      if(is_array($key)) {
        $this->errors['error'] = 'Invalid rules for validation';
        return false;
      } else {
        if(is_array($val)) {
          $rules = $val;
          foreach($rules as $rule => $val) {
            if(is_array($rule)) {
              $this->errors['error'] = 'Invalid rules for validation';
              return false;
            } else {
              $rule = strtolower($rule);
              if(in_array($rule, $this->predefined_rules)) {
                if($rule === 'required') {
                  if(!isset($rules['file']) || $rules['file'] === false) {
                    if(!isset($data[$key]) && $val === true  || isset($data[$key]) && empty($data[$key]) && $data[$key] !== 0 && $val === true) {
                      if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                        if(isset($this->messages[$key][$rule])) {
                          $this->errors[$key] = $this->messages[$key][$rule];
                        } else {
                          $this->errors[$key] = $key.' is required.';
                        }
                      } else if(isset($this->messages[$key])) {
                        $this->errors[$key] = $this->messages[$key];
                      } else {
                        $this->errors[$key] = $key.' is required.';
                      }
                      $is_valid = false;
                    }
                  } else if(!isset($_FILES[$key]) && $val === true && $rules['file'] === true || isset($_FILES[$key]) && empty($_FILES[$key]) && $_FILES[$key] !== 0 && $val === true && $rules['file'] === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' is required.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' is required.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'numeric') {
                  if(isset($data[$key]) && !empty($data[$key]) && !is_numeric($data[$key]) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should be numeric.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should be numeric.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && is_numeric($data[$key]) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be numeric.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be numeric.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'string') {
                  if(isset($data[$key]) && !empty($data[$key]) && !is_string($data[$key]) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should be string.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should be string.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && is_string($data[$key]) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be string.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be string.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'integer') {
                  if(isset($data[$key]) && !empty($data[$key]) && !is_int($data[$key]) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should be integer.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should be integer.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && is_int($data[$key]) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be integer.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be integer.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'float') {
                  if(isset($data[$key]) && !empty($data[$key]) && !is_float($data[$key]) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should be float.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should be float.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && is_float($data[$key]) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be float.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be float.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'boolean') {
                  if(isset($data[$key]) && !empty($data[$key]) && !is_bool($data[$key]) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should be boolean.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should be boolean.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && is_bool($data[$key]) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be boolean.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be boolean.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'array') {
                  if(isset($data[$key]) && !empty($data[$key]) && !is_array($data[$key]) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should be array.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should be array.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && is_array($data[$key]) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be array.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be array.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'object') {
                  if(isset($data[$key]) && !empty($data[$key]) && !is_object($data[$key]) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should be object.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should be object.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && is_object($data[$key]) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be object.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be object.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'json') {
                  if(isset($data[$key]) && !empty($data[$key]) && !(is_array($data[$key]) ? false : is_array(json_decode($data[$key], true))) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should be json.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should be json.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && (is_array($data[$key]) ? false : is_array(json_decode($data[$key], true))) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be json.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be json.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'minlength') {
                  if(isset($data[$key]) && !is_string($data[$key]) || isset($data[$key]) && !empty($data[$key]) && !(strlen($data[$key]) >= $val)) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' minimum length should be at least '.$val.' characters.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' minimum length should be at least '.$val.' characters.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'maxlength') {
                  if(isset($data[$key]) && !is_string($data[$key]) || isset($data[$key]) && !empty($data[$key]) && !(strlen($data[$key]) <= $val)) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' maximum length should be '.$val.' characters.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' maximum length should be '.$val.' characters.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'email') {
                  if(isset($data[$key]) && !empty($data[$key]) && !filter_var($data[$key], FILTER_VALIDATE_EMAIL) && $val === true) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = 'Please enter valid email address.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = 'Please enter valid email address.';
                    }
                    $is_valid = false;
                  } else if(isset($data[$key]) && !empty($data[$key]) && filter_var($data[$key], FILTER_VALIDATE_EMAIL) && $val === false) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' should not be email address.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' should not be email address.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'file') {
                  if(isset($_FILES[$key]['tmp_name']) && is_array($_FILES[$key]['tmp_name'])) {
                    foreach($_FILES[$key]['tmp_name'] as $tmp_name) {
                      if(isset($tmp_name) && !empty($tmp_name) && !is_uploaded_file($tmp_name) && $val === true) {
                        if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                          if(isset($this->messages[$key][$rule])) {
                            $this->errors[$key] = $this->messages[$key][$rule];
                          } else {
                            $this->errors[$key] = 'Please upload file';
                          }
                        } else if(isset($this->messages[$key])) {
                          $this->errors[$key] = $this->messages[$key];
                        } else {
                          $this->errors[$key] = 'Please upload file';
                        }
                        $is_valid = false;
                      } else if(isset($tmp_name) && !empty($tmp_name) && is_uploaded_file($tmp_name) && $val === false) {
                        if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                          if(isset($this->messages[$key][$rule])) {
                            $this->errors[$key] = $this->messages[$key][$rule];
                          } else {
                            $this->errors[$key] = $key.' should not be file.';
                          }
                        } else if(isset($this->messages[$key])) {
                          $this->errors[$key] = $this->messages[$key];
                        } else {
                          $this->errors[$key] = $key.' should not be file.';
                        }
                        $is_valid = false;
                      }
                    }
                  } else {
                    if(isset($_FILES[$key]['tmp_name']) && !empty($_FILES[$key]['tmp_name']) && !is_uploaded_file($_FILES[$key]['tmp_name']) && $val === true) {
                      if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                        if(isset($this->messages[$key][$rule])) {
                          $this->errors[$key] = $this->messages[$key][$rule];
                        } else {
                          $this->errors[$key] = 'Please upload file';
                        }
                      } else if(isset($this->messages[$key])) {
                        $this->errors[$key] = $this->messages[$key];
                      } else {
                        $this->errors[$key] = 'Please upload file';
                      }
                      $is_valid = false;
                    } else if(isset($_FILES[$key]['tmp_name']) && !empty($_FILES[$key]['tmp_name']) && is_uploaded_file($_FILES[$key]['tmp_name']) && $val === false) {
                      if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                        if(isset($this->messages[$key][$rule])) {
                          $this->errors[$key] = $this->messages[$key][$rule];
                        } else {
                          $this->errors[$key] = $key.' should not be file.';
                        }
                      } else if(isset($this->messages[$key])) {
                        $this->errors[$key] = $this->messages[$key];
                      } else {
                        $this->errors[$key] = $key.' should not be file.';
                      }
                      $is_valid = false;
                    }
                  }
                } else if($rule === 'file_mime_type') {
                  if(isset($_FILES[$key]['tmp_name']) && is_array($_FILES[$key]['tmp_name'])) {
                    foreach($_FILES[$key]['tmp_name'] as $tmp_name) {
                      if(isset($tmp_name) && !empty($tmp_name) && !(is_array($val) ? in_array(mime_content_type($tmp_name), $val) : is_string($val) && mime_content_type($tmp_name) === $val)) {
                        if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                          if(isset($this->messages[$key][$rule])) {
                            $this->errors[$key] = $this->messages[$key][$rule];
                          } else {
                            $this->errors[$key] = 'Invalid file mime type.';
                          }
                        } else if(isset($this->messages[$key])) {
                          $this->errors[$key] = $this->messages[$key];
                        } else {
                          $this->errors[$key] = 'Invalid file mime type.';
                        }
                        $is_valid = false;
                      }
                    }
                  } else {
                    if(isset($_FILES[$key]['tmp_name']) && !empty($_FILES[$key]['tmp_name']) && !(is_array($val) ? in_array(mime_content_type($_FILES[$key]['tmp_name']), $val) : is_string($val) && mime_content_type($_FILES[$key]['tmp_name']) === $val)) {
                      if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                        if(isset($this->messages[$key][$rule])) {
                          $this->errors[$key] = $this->messages[$key][$rule];
                        } else {
                          $this->errors[$key] = 'Invalid file mime type.';
                        }
                      } else if(isset($this->messages[$key])) {
                        $this->errors[$key] = $this->messages[$key];
                      } else {
                        $this->errors[$key] = 'Invalid file mime type.';
                      }
                      $is_valid = false;
                    }
                  }
                } else if($rule === 'file_extension') {
                  if(isset($_FILES[$key]['name']) && is_array($_FILES[$key]['name'])) {
                    foreach($_FILES[$key]['name'] as $name) {
                      if(isset($name) && !empty($name) && !(is_array($val) ? in_array(strtolower(pathinfo($name, PATHINFO_EXTENSION)), array_map('strtolower', $val)) : is_string($val) && strtolower(pathinfo($name, PATHINFO_EXTENSION)) === strtolower($val))) {
                        if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                          if(isset($this->messages[$key][$rule])) {
                            $this->errors[$key] = $this->messages[$key][$rule];
                          } else {
                            $this->errors[$key] = 'Invalid file extension.';
                          }
                        } else if(isset($this->messages[$key])) {
                          $this->errors[$key] = $this->messages[$key];
                        } else {
                          $this->errors[$key] = 'Invalid file extension.';
                        }
                        $is_valid = false;
                      }
                    }
                  } else {
                    if(isset($_FILES[$key]['name']) && !empty($_FILES[$key]['name']) && !(is_array($val) ? in_array(strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION)), array_map('strtolower', $val)) : is_string($val) && strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION)) === strtolower($val))) {
                      if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                        if(isset($this->messages[$key][$rule])) {
                          $this->errors[$key] = $this->messages[$key][$rule];
                        } else {
                          $this->errors[$key] = 'Invalid file extension.';
                        }
                      } else if(isset($this->messages[$key])) {
                        $this->errors[$key] = $this->messages[$key];
                      } else {
                        $this->errors[$key] = 'Invalid file extension.';
                      }
                      $is_valid = false;
                    }
                  }
                } else if($rule === 'min_file_size') {
                  if(isset($_FILES[$key]['size']) && is_array($_FILES[$key]['size'])) {
                    foreach($_FILES[$key]['size'] as $size) {
                      if(isset($size) && !empty($size) && !($size >= $val)) {
                        if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                          if(isset($this->messages[$key][$rule])) {
                            $this->errors[$key] = $this->messages[$key][$rule];
                          } else {
                            $this->errors[$key] = $key.' minimum file size should be at least '.$val.' bytes.';
                          }
                        } else if(isset($this->messages[$key])) {
                          $this->errors[$key] = $this->messages[$key];
                        } else {
                          $this->errors[$key] = $key.' minimum file size should be at least '.$val.' bytes.';
                        }
                        $is_valid = false;
                      }
                    }
                  } else {
                    if(isset($_FILES[$key]['size']) && !empty($_FILES[$key]['size']) && !($_FILES[$key]['size'] >= $val)) {
                      if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                        if(isset($this->messages[$key][$rule])) {
                          $this->errors[$key] = $this->messages[$key][$rule];
                        } else {
                          $this->errors[$key] = $key.' minimum file size should be at least '.$val.' bytes.';
                        }
                      } else if(isset($this->messages[$key])) {
                        $this->errors[$key] = $this->messages[$key];
                      } else {
                        $this->errors[$key] = $key.' minimum file size should be at least '.$val.' bytes.';
                      }
                      $is_valid = false;
                    }
                  }
                } else if($rule === 'max_file_size') {
                  if(isset($_FILES[$key]['size']) && is_array($_FILES[$key]['size'])) {
                    foreach($_FILES[$key]['size'] as $size) {
                      if(isset($size) && !empty($size) && !($size <= $val)) {
                        if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                          if(isset($this->messages[$key][$rule])) {
                            $this->errors[$key] = $this->messages[$key][$rule];
                          } else {
                            $this->errors[$key] = $key.' maximum file size should be '.$val.' bytes.';
                          }
                        } else if(isset($this->messages[$key])) {
                          $this->errors[$key] = $this->messages[$key];
                        } else {
                          $this->errors[$key] = $key.' maximum file size should be '.$val.' bytes.';
                        }
                        $is_valid = false;
                      }
                    }
                  } else {
                    if(isset($_FILES[$key]['size']) && !empty($_FILES[$key]['size']) && !($_FILES[$key]['size'] <= $val)) {
                      if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                        if(isset($this->messages[$key][$rule])) {
                          $this->errors[$key] = $this->messages[$key][$rule];
                        } else {
                          $this->errors[$key] = $key.' maximum file size should be '.$val.' bytes.';
                        }
                      } else if(isset($this->messages[$key])) {
                        $this->errors[$key] = $this->messages[$key];
                      } else {
                        $this->errors[$key] = $key.' maximum file size should be '.$val.' bytes.';
                      }
                      $is_valid = false;
                    }
                  }
                } else if($rule === 'in') {
                  if(isset($data[$key]) && !empty($data[$key]) && !(is_array($val) ? in_array($data[$key], $val) : is_string($val) && $data[$key] == $val)) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' Invalid data.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' Invalid data.';
                    }
                    $is_valid = false;
                  }
                } else if($rule === 'not_in') {
                  if(isset($data[$key]) && !empty($data[$key]) && (is_array($val) ? in_array($data[$key], $val) : is_string($val) && $data[$key] == $val)) {
                    if(isset($this->messages[$key]) && is_array($this->messages[$key])) {
                      if(isset($this->messages[$key][$rule])) {
                        $this->errors[$key] = $this->messages[$key][$rule];
                      } else {
                        $this->errors[$key] = $key.' Invalid data.';
                      }
                    } else if(isset($this->messages[$key])) {
                      $this->errors[$key] = $this->messages[$key];
                    } else {
                      $this->errors[$key] = $key.' Invalid data.';
                    }
                    $is_valid = false;
                  }
                }
              } else {
                $this->errors['error'] = 'Invalid rules for validation';
                return false;
              }
            }
          }
        } else {
          $this->errors['error'] = 'Invalid rules for validation';
          return false;
        }
      }
    }
    return $is_valid;
  }

  /**
  * Rules
  * Set validation rules.
  *
  * @param array $rules
  * @return void
  */
  function rules(array $rules) {
    $this->rules = $rules;
  }

  /**
  * Messages
  * Set validation error messages.
  *
  * @param array $messages
  * @return void
  */
  function messages(array $messages) {
    $this->messages = $messages;
  }

  /**
  * Errors
  * Validation errors.
  *
  * @param string $error
  * @return string|array|void
  */
  function errors(string $error=NULL) {
    if(isset($error) && is_array($this->errors) && isset($this->errors[$error])) {
      return $this->errors[$error];
    }
    if($error==NULL) {
      return $this->errors;
    }
  }
}