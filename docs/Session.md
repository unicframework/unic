## Session

  sessions provide a way to store information about the user across multiple requests.

  **Create a New Session**

```php
//Create new session
$this->session->set('email', 'example@gmail.com');
```

  **Get Session Data**

```php
//Get session data
$this->session->email;
//OR
$this->session->get('email');
```


  **Check Session Data**

```php
//Get session exists or not
if($this->session->has('email')) {
  //Session data exists
} else {
  //Session data not exists
}
```


  **Delete Session Data**

```php
//Delete a session data
$this->session->delete('email');
```

  It will delete only session variable data.


  **Delete Session**

```php
//Delete all session
$this->session->destroy();
```

  It will delete all session data.
