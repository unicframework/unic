## Validator

  Validator is a html form-data/user-data and json data validation library.

### Example

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
    'email' => true
  ],
  'password' => [
    'required' => true,
    'minlength' => 6,
    'maxlength' => 15
  ]
]);

//Validate form data
if($this->validator->validate($this->request->post)) {
  //Ok
} else {
  //Display validation errors
  print_r($this->validator->errors();
}
```

### Set validation rules

  Validator has a lots of predefined validation rules.

  - **required** : set required field true or false.
  - **numeric** : validate numeric data type true or false.
  - **string** : validate string data type true or false.
  - **integer** : validate integer data type true or false.
  - **float** : validate float data type true or false.
  - **boolean** : validate boolean data type true or false.
  - **array** : validate array true or false.
  - **object** : validate object true or false.
  - **json** : validate json data type true or false.
  - **minlength** : set minimum length in integer.
  - **maxlength** : set maximum length in integer.
  - **email** : validate email address true or false.
  - **file** : validate uploaded file true or false.
  - **file_mime_type** : set allowed file mime type in array.
  - **file_extension** : set allowed file extension in array.
  - **min_file_size** : set minimum file size in bytes.
  - **max_file_size** : set maximum file size in bytes.
  - **in** : check data match in given array.
  - **not_in** : check data not match in given array.

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
    'email' => true
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

  Validator allows us to set custom error messages.

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
