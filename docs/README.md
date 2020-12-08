# Unic Framework

<p align="center">
  <img src="unic-logo.jpg" width="400px" alt="Unic Logo">
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


## User Guide

- [Introduction](Introduction.md)
  - [What is unic framework](Introduction.md#What-is-unic-framework)
  - [Why unic framework](Introduction.md#Why-unic-framework)
  - [Unic architecture](Introduction.md#Unic-architecture)
  - [Directory Structure](Introduction.md#Directory-Structure-of-Unic)
- [Installation](Installation.md)
- [Views](Views.md)
  - [Create Views](Views.md#Create-a-view)
  - [Render templates](Views.md#Render-templates)
  - [Render Files](Views.md#Render-Files)
  - [Send Files](Views.md#Send-Files)
  - [Response data](Views.md#Response-data)
  - [Json Response](Views.md#Json-Response)
  - [Set Http Response code](Views.md#Set-Http-Response-code)
  - [Set Http Response header](Views.md#Set-Http-Response-header)
  - [Use Models](Views.md#Use-Models)
- [URLs](URLs.md)
  - [Map Urls with Views](URLs.md#Map-Urls-with-Views)
  - [URL patterns and slug](URLs.md#URL-patterns-and-slug)
  - [Regular Expressions](URLs.md#Regular-Expressions)
  - [Include URLs](URLs.md#Include-URLs)
- [Models](Models.md)
  - [Create Models](Models.md#Create-a-model)
  - [Use Database](Models.md#Use-Database)
- [Templates](Templates.md)
- [Middlewares](Middlewares.md)
  - [Global Middleware](Middlewares.md#Global-Middleware)
  - [Local Middleware](Middlewares.md#Local-Middleware)
  - [Group Middleware](Middlewares.md#Group-Middleware)
- [Static files](Static-files.md)
- [File Uploading](File-Uploading.md)
- [Session](Session.md)
- [Cookie](Cookie.md)
- [Request](Request.md)
  - [GET Request](Request.md#Request-Data)
  - [POST Request](Request.md#Request-Data)
  - [PUT Request](Request.md#Request-Data)
  - [DELETE Request](Request.md#Request-Data)
- [Library](Library.md)
  - [What is Library](Library.md#What-is-Library)
  - [Create Library](Library.md#Create-Library)
  - [System Libraries](Library.md#System-Library)
    - [Security](Libraries/Security.md)
    - [User Agent](Libraries/User-Agent.md)
- [Databases](Databases.md)
  - [Connect Database](Databases.md#Connect-Database)
  - [Database Query](Databases.md#Database-Query)
- [Security](Libraries/Security.md)
  - [SQL Injection](Libraries/Security.md#SQL-Injection)
  - [XSS](Libraries/Security.md#XSS)
  - [CSRF](Libraries/Security.md#CSRF)
- [ErrorHandler](ErrorHandler.md)
- [Settings](Settings.md)
- [How to Deploy](How-to-Deploy.md)


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

  - Learn more about Unic from [Documentation](README.md) file.
  - Documentation : https://unic-framework.github.io/unic


## License

  [MIT License](https://github.com/unic-framework/unic/blob/main/LICENSE)
