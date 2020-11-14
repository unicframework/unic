## Middleware

  A Middleware is a small piece of code that is used to alter web application request/response cycle.

### Create Middleware

  Let's create a `middleware.php` file, you can name it anything. you middleware class name should be match with file name.

```php
class middleware extends Middlewares {
  function __construct() {
    parent::__construct();
  }

  function hello() {
    $this->request->hello = "hello, world!";
  }
}
```

  This a example of `hello, world` middleware. this middleware add a `hello` variable in request.

### Install Middleware

  Go to your `settings.php` file and add your middleware in middlewares. you can set your middleware as global middleware and local middleware. a global middleware execute on every request and your local middleware runs when a specific view (Routes) called. In `settings.php` file you can install your global middlewares.
  
```php
//Install your middlewares
$middlewares = [
  'app/middleware.hello',
];
```

### Set Local Middleware

  You can set your local middleware in `urls.php` file.

```php
$urlpatterns = [
  '/' => 'view.home',
  '/hello' => ['view' => 'view.hello', 'middleware' => 'app/middleware.hello'],
];
```


### Set Group Middleware

  You can set your group middleware in `urls.php` file.

```php
$urlpatterns = [
  '/' => 'view.home',
  [
    'view' => [
      '/blog',
      '/blog/new',
      '/blog/delete'
    ],
    'middleware' => [
      'app/middleware.hello'
    ]
  ],
];
```
