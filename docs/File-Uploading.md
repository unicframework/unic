## File Uploading

  Unic Framework provide simplest way to upload files on the server.

### Files Information

  Uploaded files information stored in the `$this->request->files` object.

  - `$this->request->files->file_var['name']` : store the original name of uploaded files.
  - `$this->request->files->file_var['type']` : store mime type of the file, if the browser provided this information. An example would be `image/gif`.
  - `$this->request->files->file_var['size']` : store size, in bytes, of the uploaded file.
  - `$this->request->files->file_var['tmp_name']` : store the temporary filename of the file in which the uploaded file was stored on the server.
  - `$this->request->files->file_var['error']` : store the error code associated with this file upload.

### Example

  - Create HTML form

```html
<form action="/upload" method="post" enctype="multipart/form-data">
  <input type="file" name="image">
  <input type="submit" value="Upload Image" name="submit">
</form>
```
  - Upload files.

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function file_upload() {
    //source path.
    $source = $this->request->files->image['tmp_name'];

    //destination path.
    $destination = '/img/'.$this->request->files->image['name'];

    //upload files
    if($this->request->files->upload($source, $destination)) {
      return $this->response('File uploaded');
    } else {
      return $this->response('Error: File not uploaded');
    }
  }
}
```
