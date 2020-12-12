## Validator

  Validator is a html form-data/user-data and json data validation library.

### Example

  Load validator library in unic framework.

```php
//Set validation rules
$this->validator->rules([
  'name' => [
    'required' => true,
    'string' => true
  ],
  'gender' => [
    'required' => true,
    'string' => true,
    'lowercase' => true,
    'in' => ['male', 'female', 'other']
  ],
  'email' => [
    'required' => true,
    'email' => true,
    'callback' => function() {
      //Convert email to lowercase
      $_POST['email'] = strtolower($_POST['email']);
    }
  ],
  'password' => [
    'required' => true,
    'minlength' => 6,
    'maxlength' => 15,
    'callback' => function() {
      //Encrypt password
      $_POST['password'] = base64_encode($_POST['password']);
    }
  ]
]);

//Validate form data
if($this->validator->validate($_POST)) {
  //Ok data is valid
} else {
  //Display validation errors
  print_r($this->validator->errors();
}
```

### Set validation rules

  Validator has a lots of predefined validation rules.

| Rules          | Value    | Description |
|----------------|----------|-------------|
| required       | boolean  | set required fields, required fields can not be null or empty. |
| alphabet       | boolean  | match alphabetical data. use `true` for alphabetical and `false` for non alphabetical values. |
| numeric        | boolean  | match numeric data. use `true` for numeric and `false` for non numeric values. |
| alphanumeric   | boolean  | match alphanumeric data. use `true` for alphanumeric and `false` for non alphanumeric values. |
| lowercase      | boolean  | match case of string. use `true` for lowercase and `false` for non lowercase values. |
| uppercase      | boolean  | match case of string. use `true` for uppercase and `false` for non uppercase values. |
| string         | boolean  | match string data type. use `true` for string and `false` for non string values. |
| integer        | boolean  | match integer data type. use `true` for integer and `false` for non integer values. |
| float          | boolean  | match float data type. use `true` for float and `false` for non float values. |
| boolean        | boolean  | match boolean data type. use `true` for boolean and `false` for non boolean values. |
| array          | boolean  | match array data type. use `true` for array and `false` for non array values. |
| object         | boolean  | match object data type. use `true` for object and `false` for non object values. |
| json           | boolean  | match json data type. use `true` for json and `false` for non json values. |
| minlength      | integer  | match minimum length of string. |
| maxlength      | integer  | match maximum length of string. |
| min            | integer  | match minimum value of number. |
| max            | integer  | match maximum value of number. |
| email          | boolean  | check given email is valid email address or not. |
| file           | boolean  | check data is uploaded file or not. |
| file_mime_type | array    | match file mime type in given array. |
| file_extension | array    | match file extension in given array. |
| min_file_size  | bytes    | match minimum file size. |
| max_file_size  | bytes    | match maximum file size. |
| in             | array    | match data in given array. |
| not_in         | array    | match data in given array. |
| equal          | mixed    | it will match data with given data. |
| not_equal      | mixed    | it will match data with given data. |
| is_true        | boolean  | is_true is used to validate true values. it will throw an error when it will find true value. |
| is_false       | boolean  | is_false is used to validate false values. it will throw an error when it will find false value. |
| callback       | function | pass callback function. callback function is called during validation of field. |


  We can set rules for data validation.

```php
//Set validation rules
$this->validator->rules([
  'name' => [
    'required' => true,
    'string' => true
  ],
  'gender' => [
    'required' => true,
    'string' => true,
    'in' => ['male', 'female', 'other']
  ],
  'email' => [
    'required' => true,
    'email' => true,
    'callback' => function() {
      //Convert email to lowercase
      $_POST['email'] = strtolower($_POST['email']);
    }
  ],
  'password' => [
    'required' => true,
    'minlength' => 6,
    'maxlength' => 15
  ],
  'profile_image' => [
    'file' => true,
    'max_file_size' => 2000000,
    'file_extension' => ['jpg', 'png']
  ]
]);
```

### Set error messages

  Validator allows us to set custom error messages for validation rules.

```php
//Set error messages
$this->validator->messages([
  'name' => [
    'required' => 'Please enter your name.',
    'string' => 'Your name should be in string.'
  ],
  'gender' => [
    'required' => 'Please enter gender.',
    'in' => 'Please enter valid gender.'
  ],
  'email' => [
    'required' => 'Please enter email address.',
    'email' => 'Please enter valid email address.'
  ]
]);
```
