## Static files

#### Static files

  Websites are need some static files, these static files are js, css, images etc. Unic Framework help us to manage these static files.

  - Set your static files directory in settings file.

```php
$static_dir = '/application/static';
```

  - Set your static URL in settings file.

```php
$static_url = '/static';
```

  - Use static files in templates.

```html
<!DOCTYPE>
<html>
<head>
  <title>cat image</title>
</head>
<body>
  <img src='<?php echo $this->static_url.'/img/cat.jpg'; ?>' alt='cat image'/>
  <!-- or -->
  <img src='<?php echo $this->static('/img/cat.jpg'); ?>' alt='cat image'/>
</body>
</html>
```

  - `$this->static_url` variable store your static directory path.
  - `$this->static()` function return full path of static directory.
