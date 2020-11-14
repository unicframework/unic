## Templates

  The Template is a presentation layer which handles User Interface part. Unic Framework by default store all the template in templates directory, but you can change the template directory in settings. go to settings file add your template directory path in template array.

#### Create a HTML template

  Create a `hello.html` or `hello.php` file in a templates directory and put the following code in it.

```html
<!DOCTYPE>
<html>
<head>
  <title>Hello world</title>
</head>
<body>
  <h1>Hello world!!</h1>
</body>
</html>
```
 this is a simple hello world template file.

#### How to render templates

  render your templates.

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function hello() {
    //render html templates
    return $this->render('hello');
  }
}
```

#### How to pass data in templates

  we can pass any data in templates using array.

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function hello() {
    //data
    $blog = array(
      'title' => 'this is title',
      'author' => 'author name',
      'date' => '13-Fab-2020',
    );
    //pass data to template
    return $this->render('hello', $blog);
  }
}
```

#### How to access Data in templates

```html
<!DOCTYPE>
<html>
<head>
  <title><?php echo $title; ?></title>
</head>
<body>
  <?php echo $title; ?>
  <?php echo $author; ?>
  <?php echo $date; ?>
</body>
</html>
```
