## URLs

  Unic allows to create simple and clean urls without any limitation. create URLs and map with views.

### Map URLs with Views

  Let's create URL and map to views. open `app/urls.php` file and put the following code in it:

```php
//Include views
include_once 'views.php';
include_once 'product_view.php';

$urlpatterns = [
  '/' => 'app_view.home',
  '/product/{id}' => 'product.data',
  '/about' => 'app_view.about',
];
```

### URL Patterns and slug

  Unic framework allows to create custom urls patterns.

  Example :
```
/product/1
/product/2
/product/3
```

  here the product id is dynamic it can be change on every request.

```php
$urlpatterns = [
  '/product/{id}' => 'view.product',
];
```

  To access slug pattern data create a function product and pass parameter. now we can access the id of product and render the product data.

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function product() {
    $id = $this->request->params->id;
    return $this->response('Product : '.$id);
  }
}
```

  Unic does not support any int, str, float type but you can use them in slug. {slug} support all the int, float, and string as well as Wildcards.

### Regular Expressions

  Unic allows to define URLs routing rules using regular expressions. Any valid regular expression is allowed.

```php
'/product/([0-9]+)' => 'view.product',
```

  this example is similar to :

```
/product/1
/product/2
/product/3
```

### Include URLs

  Include your application URLs file in main URLs file.

```php
$urlpatterns = [
  '/' => urls('app/urls.php'),
  '/product' => urls('product/urls.php'),
];
```
