## Unic Framework

<p align="center">
  <img src="https://github.com/unicframework/docs/blob/main/unic-logo.jpg" width="400px" alt="Unic Logo">
</p>

Unic is a high performance, open source web application framework.
Unic framework is fast, minimal and unopinionated web framework inspired by express.
Unic is flexible and provide lots of HTTP methods to create APIs quickly.

## Features
  - Fast and flexible.
  - Extremely light weight.
  - Minimal and unopinionated.
  - Simple and robust routing.
  - Robust middlewares.

## Installation

  Unic web framework is for PHP, so it's requires PHP 5.6 or newer. now you won’t need to setup anything just yet.

  - Install `composer` if you have not installed.

```shell
composer create-project unicframework/unic blog
```

  It will create a `blog` project for you.


## Simple Example

  A simple `Hello, World` web application in unic framework.

```php
use Unic\App;

$app = new App();

$app->get('/', function($req, $res) {
    $res->send('Hello, World!');
});

$app->get('/api', function($req, $res) {
    $res->json([
        'status' => 'Ok',
    ]);
});

$app->start();
```

## Documentation

  - Learn more about Unic from [Documentation](https://github.com/unicframework/docs/) file.
  - Documentation : [https://unicframework.github.io/docs](https://unicframework.github.io/docs)

## License

  [MIT License](LICENSE)
