## Models

  Models are classes that are designed to work with database. it manages the database, logic and rules of the web application.

### Create a model

  Let’s create the first model. Open the `app/model.php` file and put the following PHP code in it:

```php
class blog extends Models {
  private $title;
  private $author;
  private $date;

  function __construct() {
    //Create database connection
    $this->connect('db');
  }

  function get_data() {
    $result = $this->db->query('select * from blog');
    //Close database connection
    $this->db->close();
    return $result;
  }
}
```

### Use Database

  Create database connection in model.

```php
class blog extends Models {
  function __construct() {
    $this->connect('blog_db');
  }

  function get_data() {
    //Select data from database
    $result = $this->blog_db->query('select * from blog');
    return $result;
  }

  function put_data($title,$author) {
    //Insert data in database
    return $this->blog_db->query("insert into blog values('$title','$author')");
  }
}
```

### Use Model

  Use models in views to use database in your application.

```php
//Include models
require_once 'model.php';

class view extends Views{
  private $blog;

  function __construct() {
    parent::__construct();

    //Create model object
    $this->blog = new blog();
  }

  function home() {
    //Get data from model
    foreach($this->blog->get_data() as $data) {
      $blog_data[] = $data;
    }
    //Response data
    return $this->response($blog_data);
  }
}
```
