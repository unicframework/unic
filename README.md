# Unic Framework

<p align="center">
  <img src="docs/unic-logo.jpg" width="400px" alt="Unic Logo">
</p>

Unic is a high performance, open source web application framework.
Unic web framework follows the MVT (Model-View-Template) architectural pattern.

## Features

  - Fast and Powerful.
  - Extremely Light Weight.
  - MVT Architecture.
  - Security and XSS Filtering.
  - Simple and Easy to learn.
  - Easy to Deploy on any server.


## Installation

  Unic web framework is for PHP, so it's requires PHP 5.6 or newer. now you won’t need to setup anything just yet.

### Unic can be installed in few steps:

  - [Download](https://github.com/unicframework/unic/archive/main.zip) the Unic files.
  - Unzip the package.
  - Upload all the Unic folders and files (system, application, .htaccess, index.php) on the server.

  That's it, in the Unic web framework there is nothing to configure and setup. it's always ready to go.

### Install with composer :

  - Install `composer` if you have not installed.

```shell
composer create-project unicframework/unic blog
```

  It will create a `blog` project for you.


## Simple Example

  A simple `Hello, World` web application in Unic web framework.

### Create View

  Let’s write the first view. Open the `app/view.php` file and put the following PHP code in it:

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  //Home view
  function home() {
    return $this->response('Hello, World !!');
  }
}
```

  `home` view is created, now map this view to URL.

### Map URLs to Views

  Let's create URL and map to views. open `app/urls.php` file and put the following code in it:

```php
//Include views
require_once 'view.php';

$urlpatterns = [
  '/' => 'view.home',
];
```

  Now a simple `Hello World` web app is created.


## Simple Web Api Example

  A simple `Hello, World` web Api in Unic web framework.

### Create View

  Let’s write the first view. Open the `app/view.php` file and put the following PHP code in it:

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  //Home view
  function home() {
    $data = [
      'status' => true,
      'data' => 'Hello, World',
    ];
    //Send json response
    return $this->response_json($data);
  }
}
```

  `home` view is created, now map this view to URL.

### Map URLs to Views

  Let's create URL and map to views. open `app/urls.php` file and put the following code in it:

```php
//Include views
require_once 'view.php';

$urlpatterns = [
  '/' => 'view.home',
];
```

  Now a simple `Hello, World` web Api is created.


## Documentation

  - Learn more about Unic from [Documentation](https://github.com/unicframework/docs/) file.
  - Documentation : [https://unicframework.github.io/docs](https://unicframework.github.io/docs)


## License

  [MIT License](LICENSE)
