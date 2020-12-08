## Request

  Resquest handle all the HTTP Request and Server information.

  ### Request Header Information

  - `scheme` : Request scheme http or https.
  - `method` : Which request method was used to access the page; e.g. 'GET', 'HEAD', 'POST', 'PUT', 'DELETE'
  - `time` : The timestamp of the start of the request.
  - `time_float` : The timestamp of the start of the request, with microsecond precision.
  - `protocol` : Name and revision of the information protocol via which the page was requested e.g. 'HTTP/1.0'.
  - `accept` : Acceptable content types for the response. 
  - `language` : Acceptable languages for the response. Example: 'en'.
  - `encoding` : Acceptable encodings for the response. Example: 'gzip'.
  - `connection` : header from the current request, if there is one. Example: 'Keep-Alive'.
  - `content_type` : A string representing the MIME type of the request, parsed from the CONTENT_TYPE header.
  - `content_length` : The length of the request body (as a string).
  - `user_agent` : This is a string denoting the user agent being which is accessing the page. A typical example is: Mozilla/4.5 [en] (X11; U; Linux 2.2.9 i586).
  - `referrer` : The address of the page (if any) which referred the user agent to the current page. This is set by the user agent. Not all user agents will set this, and some provide the ability to modify HTTP_REFERER as a feature. In short, it cannot really be trusted.

  ### Server Information

  - `hostname` : The Host name from which the user is viewing the current page.
  - `host` : The HTTP Host header sent by the client.
  - `port` : The port on the server machine being used by the web server for communication. For default setups, this will be '80'; using SSL, for instance, will change this to whatever your defined secure HTTP port is.
  - `gateway_interface` : What revision of the CGI specification the server is using; e.g. 'CGI/1.1'.
  - `server_addr` : The IP address of the server under which the current script is executing.
  - `server_name` : The name of the server host under which the current script is executing. If the script is running on a virtual host, this will be the value defined for that virtual host.
  - `server_software` : Server identification string, given in the headers when responding to requests.
  - `server_protocol` : Name and revision of the information protocol via which the page was requested; e.g. 'HTTP/1.0'
  - `server_signature` : String containing the server version and virtual host name which are added to server-generated pages, if enabled.
  - `document_root` : The document root directory under which the current script is executing, as defined in the server's configuration file.

  ### Path Information

  - `uri` : The URI which was given in order to access this page; for instance, '/index.html'.
  - `request_uri` : The URI which was given in order to access this page; for instance, '/index.html'.
  - `url` : absolute URL of current request.
  - `path` : path of current request.
  - `path_info` : path of current request with query string.

  ### Request Data

  - `get` : get all GET request data.
  - `post` : get all POST request data.
  - `put` : get all PUT request data.
  - `delete` : get all DELETE request data.
  - `patch` : get all PATCH request data.
  - `head` : get all HEAD request data.
  - `options` : get all OPTIONS request data.
  - `connect` : get all CONNECT request data.
  - `trace` : get all TRACE request data.
  - `copy` : get all COPY request data.
  - `link` : get all LINK request data.
  - `unlink` : get all UNLINK request data.
  - `lock` : get all LOCK request data.
  - `unlock` : get all UNLOCK request data.
  - `purge` : get all PURGE request data.
  - `propfind` : get all PROPFIND request data.
  - `view` : get all VIEW request data.
  - `any` : get all request data.
  - `files` : get all FILES request data.

  ### Request Information

  - `is_secure` : TRUE if the current request is https.
  - `is_ajax` : TRUE if the current request is made by ajax.
  - `is_get` : TRUE if the current request is GET.
  - `is_post` : TRUE if the current request is POST.
  - `is_put` : TRUE if the current request is PUT.
  - `is_delete` : TRUE if the current request is DELETE.
  - `is_patch` : TRUE if the current request is PATCH.
  - `is_head` : TRUE if the current request is HEAD.
  - `is_options` : TRUE if the current request is OPTIONS.
  - `is_connect` : TRUE if the current request is CONNECT.
  - `is_trace` : TRUE if the current request is TRACE.
  - `is_copy` : TRUE if the current request is COPY.
  - `is_link` : TRUE if the current request is LINK.
  - `is_unlink` : TRUE if the current request is UNLINK.
  - `is_lock` : TRUE if the current request is LOCK.
  - `is_unlock` : TRUE if the current request is UNLOCK.
  - `is_purge` : TRUE if the current request is PURGE.
  - `is_propfind` : TRUE if the current request is PROPFIND.
  - `is_view` : TRUE if the current request is VIEW.
  - `is_http` : TRUE if the current request is http.
  - `is_https` : TRUE if the current request is https.

  ### User Information

  - `remote_addr` : The IP address from which the user is viewing the current page.
  - `is_referred` : True if user is redirected from somewhere.

  ### Example

  Get post request data

```php
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    //Check request method is post or not
    if($this->request->is_post) {
      //Do something
    }

    //Get post method data
    echo $this->request->post->name;
    echo $this->request->post->email;
    return $this->render('home');
  }
}
```
