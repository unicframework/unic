## ErrorHandler

  Handle Errors like 404 (page not found), 500 (Internal Server Error), etc.

  Create you custom ErrorHandler to handle any server errors.

  **Example :**

  1. Create your ErrorHandler view.
```php
function page_not_found() {
  return $this->response('404 Page Not Found', 404);
}
```

  2. Include your views to urls file.
  3. Map your handler with errorhandler array.

```php
$errorhandlers = [
  '404' => 'view_name.page_not_found',
];
```

  it will redirect all 404 errors to your page_not_found view.

  ***Note : The ErrorHandler array, it must be in the main urls file only.***
