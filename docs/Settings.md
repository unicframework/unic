## Settings

  A settings file is a application default setting and configuration file.

#### Debug

  Set the error_reporting directive at runtime.

  ***SECURITY WARNING: don't run with debug turned on in production.***

```php
$debug = TRUE;
```
  Set `$debug = TRUE;` to show all error's.

  Set `$debug = FALSE` to hide all error's in production.


#### Libraries Configuration

  Allow hosts to access you web application.

```php
$allowed_hosts = ['localhost', 'example.com'];
```

  leave `allowed_hosts` empty to allow all hosts.


#### Libraries Configuration

  Install user defined libraries in your web application.

```php
$libraries = [
  //install system library
  'system.security',
  //install user defined library
  'app/library/my_library',
  'app/library/my_another_libraray' => 'mylib',
];
```

  
#### Middlewares Configuration

  set your global middlewares.

```php
$middlewares = [
  'app/middleware.auth',
];
```

#### Database Configuration

```php
$db['db']= [
    'dsn' => '',
    'hostname' => 'localhost',
    'port' => '',
    'username' => 'demo_user',
    'password' => '1234',
    'database' => 'demo',
    'driver' => 'mysqli',
    'char_set' => 'utf8',
];
```

  Database Configuration :

  - **dsn** : The full DSN string describe a connection to the database. by default you can leav it will blank.
  - **hostname** : The hostname of your database server.
  - **port** : The port of your database server.
  - **username** : The username used to connect to the database.
  - **password** : The password used to connect to the database.
  - **database** : The name of the database you want to connect to.
  - **driver** : The name of the database driver (mysqli,pdo,sqlite3).
  - **char_set** : The character set used in communicating with the database.


#### Static Files Configuration

  Add your static URL to serve static files.

```php
$static_url = '/static';
```

  Add your static files directory path.

```php
$static_dir = 'app/static';
```


#### Templates Configuration

  Add your templates directory path.

```php
$templates = [
  'app/templates',
];
```

#### Urls Settings

  Ignore trailing slashes

```php
$ignore_trailing_slash = FALSE;
```

  Set `$ignore_trailing_slash = TRUE` if you want to ignore trailing slashes.

  Set `$ignore_trailing_slash = FALSE` if you don't want to ignore trailing slashes.


#### Set Default timezone

  Set your default timezone.

```php
//Set default timezone
date_default_timezone_set('UTC');
```
