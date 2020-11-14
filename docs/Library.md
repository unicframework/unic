## Libraries

#### What is Library

  Libraries are classes that can be used in web application.

#### Create Libraries

  user's can create their own libraries in Unic framework.

  - **Create your library**

  create `hello.php` in library directory and put the following php code in it.

```php
//hello world library
class hello {
  function say_hello($name) {
    echo "hello, $name";
  }
}
```

  - **Install your library**

  go to settings file add your library in `library` array.

```php
$libraries = [
  'app/library/hello'
];
```

  - **Use library**

```php
class view extends Views {
  function hello() {
    return $this->hello->say_hello("World");
  }
}
```

  - **Set alias name to your library**

```php
$libraries = [
  //set alias name
  'app/library/hello' => 'say',
];
```

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function hello() {
    return $this->say->say_hello("World");
  }
}
```

  libraries can not be used in models.


## System Libraries

  Unic framework provide lots of pre-defined system libraries.

  There are several libraries available in Unic framework.

  - [Security Library](Libraries/Security.md)
  - [User Agent Library](Libraries/User-Agent.md)

  **Install system library**

```php
//install system library
$libraries = [
  'system.security',
  //add alias name
  'system.user_agent' => 'user',
];
```

