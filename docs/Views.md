## Views

  Views are classes that render templates, communicate with models and contain all the business logic of web application.
  generally all the views are written in a views.php file that is in your application directory or apps directory, but you can create your own views file in Unic framework.

### Create a view

  Let’s write the first view. open the `app/views.php` file and put the following PHP code in it:

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }
  //Send response
  function home() {
    return $this->response('Hello, World !!');
  }
}
```

  a simple hello world view is created, to render views map your view to URLs.


### Render Html templates

  Render html templates, crate a template `hello.html` or `hello.php` in templates directory.

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Render HTML templats
    return $this->render('home');
  }
}
```

### Render Files

  Render files like (CSS, JS, Images, etc.).

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Render files.
    return $this->render_file('cat.jpg');
  }
}
```


### Send Files

  Send files like (CSS, JS, Images, audio, video etc.) to the client.

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Send files.
    return $this->send_file('cat.jpg');
  }
}
```

  `send_file()` send downloadable files to the client browser.


### Response data

  **Response simple string data :**

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Response string data
    return $this->response('Hello, World!');
  }
}
```

  **Response simple string data with http response code :**

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Response string data with http response code
    return $this->response('404 Page not found !!', 404);
  }
}
```

### Json Response

  Response json data for api response :

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Response json data
    return $this->response_json(array('data' => 'hello world'));
  }
}
```

### Set Http Response code

  Set Http Response status code :

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Response http response code
    return $this->response_code(404);
  }
}
```

### Set Http Response header

  Set Http Response header :

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Set response header
    $this->header('Content-Type: application/json');

    //Response data
    return $this->response('<h1>hello world</h1>');
  }
}
```

### Use Models

  Create a model blog and include models file in views file.

```php
//Include models
include_once 'models.php';

class view extends Views {
  private $blog;

  function __construct() {
    parent::__construct();

    //Create model object
    $this->blog = new blog_model();
  }

  function demo() {
    return $this->response($test->blog->get_data());
  }
}
```
