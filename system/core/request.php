<?php
/**
* Request Library
* Request Library store all the server request data.
*
* @package : Request
* @category : System Middleware
* @author : Unic Framework
* @link : https://github.com/unic-framework/unic
*/

defined('SYSPATH') OR exit('No direct access allowed');

//Global request object
$request = NULL;

class request {
  //Request header Information
  public $scheme;
  public $method;
  public $time;
  public $time_float;
  public $protocol;
  public $accept;
  public $language;
  public $encoding;
  public $connection;
  public $content_type;
  public $content_length;
  public $user_agent;
  public $referrer;

  //Request body information
  public $body;
  
  //Server information
  public $hostname;
  public $host;
  public $port;
  public $gateway_interface;
  public $server_addr;
  public $server_name;
  public $server_software;
  public $server_protocol;
  public $server_signature;
  public $document_root;

  //Path information
  public $uri;
  public $request_uri;
  public $url;
  public $path;
  public $path_info;

  //Request information
  public $get;
  public $post;
  public $put;
  public $delete;
  public $patch;
  public $head;
  public $options;
  public $connect;
  public $trace;
  public $copy;
  public $link;
  public $unlink;
  public $lock;
  public $unlock;
  public $purge;
  public $propfind;
  public $view;
  public $is_secure;
  public $is_ajax;
  public $is_get;
  public $is_post;
  public $is_put;
  public $is_delete;
  public $is_patch;
  public $is_head;
  public $is_options;
  public $is_connect;
  public $is_trace;
  public $is_copy;
  public $is_link;
  public $is_unlink;
  public $is_lock;
  public $is_unlock;
  public $is_purge;
  public $is_propfind;
  public $is_view;
  public $is_http;
  public $is_https;
  public $files;

  //User information
  public $remote_addr;
  public $is_referred;

  function __construct() {
    /**
    * Request Header Information
    * Get Request header information.
    */
    //get scheme of request (https or http)
    $this->scheme = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS'])!== 'off') ? 'https' : 'http';

    //get request method get, post, put, delete
    $this->method = strtoupper($_SERVER['REQUEST_METHOD']);

    //get Request time
    $this->time = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : FALSE;

    $this->time_float = isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : FALSE;

    //get server protocol
    $this->protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : FALSE;

    //get http_accept
    $this->accept = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : FALSE;

    //get accept language
    $this->language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : FALSE;

    //get connection
    $this->connection = isset($_SERVER['HTTP_CONNECTION']) ? $_SERVER['HTTP_CONNECTION'] : FALSE;

    //get http encoding
    $this->encoding = isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : FALSE;

    //get content type, request MIME type from header
    $this->content_type = isset($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : (isset($_SERVER['HTTP_CONTENT_TYPE']) ? $_SERVER['HTTP_CONTENT_TYPE'] : FALSE);

    //get content length
    $this->content_length = isset($_SERVER['CONTENT_LENGTH']) ? $_SERVER['CONTENT_LENGTH'] : (isset($_SERVER['HTTP_CONTENT_LENGTH']) ? $_SERVER['HTTP_CONTENT_LENGTH'] : FALSE);

    //get user agent
    $this->user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : FALSE;

    //get http referer
    $this->referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : FALSE;


    /**
    * Request Body
    * Get Request body information.
    */
    $this->body = file_get_contents('php://input');


    /**
    * Server Information
    * Get web server information.
    */
    //get hostname
    $this->hostname = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : FALSE;

    //get host
    $this->host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : FALSE;

    //get port
    $this->port = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : FALSE;

    //get server gateway interface
    $this->gateway_interface = isset($_SERVER['GATEWAY_INTERFACE']) ? $_SERVER['GATEWAY_INTERFACE'] : FALSE;

    //get server addr
    $this->server_addr = isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : FALSE;

    //get server name
    $this->server_name = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : FALSE;

    //get server software
    $this->server_software = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : FALSE;

    //get server protocol
    $this->server_protocol = isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : FALSE;

    //get server signature
    $this->server_signature = isset($_SERVER['SERVER_SIGNATURE']) ? $_SERVER['SERVER_SIGNATURE'] : FALSE;

    //get server document root
    $this->document_root = isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : FALSE;


    /**
    * Path Information
    * Get all urls and path information.
    */
    //get request URI
    $this->uri = $_SERVER['REQUEST_URI'];

    //get request URI
    $this->request_uri = $_SERVER['REQUEST_URI'];

    //get site full url
    $this->url = $this->scheme.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    //get request path without query string.
    $this->path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    //get request path including query string.
    $this->path_info = $_SERVER['REQUEST_URI'];


    /**
    * Request Information
    * Get all Http request information.
    */
    //get all request data
    parse_str(file_get_contents('php://input'), $request_data);
    $this->get = json_decode(json_encode($_GET));
    $this->post = json_decode(json_encode($_POST));
    $this->put = ($this->method === 'PUT' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->delete = ($this->method === 'DELETE' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->patch = ($this->method === 'PATCH' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->head = ($this->method === 'HEAD' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->options = ($this->method === 'OPTIONS' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->connect = ($this->method === 'CONNECT' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->trace = ($this->method === 'TRACE' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->copy = ($this->method === 'COPY' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->link = ($this->method === 'LINK' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->unlink = ($this->method === 'UNLINK' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->lock = ($this->method === 'LOCK' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->unlock = ($this->method === 'UNLOCK' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->purge = ($this->method === 'PURGE' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->propfind = ($this->method === 'PROPFIND' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;
    $this->view = ($this->method === 'VIEW' && isset($request_data)) ? json_decode(json_encode($request_data)) : NULL;

    //check connection is secure
    $this->is_secure = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1)) || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS'])!== 'off') ? TRUE : FALSE;

    //check request made with ajax
    $this->is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' ? TRUE : FALSE;

    //check request method is get or not
    $this->is_get = $this->method==='GET' ? TRUE : FALSE;

    //check request method is post or not
    $this->is_post = $this->method==='POST' ? TRUE : FALSE;

    //check request method is put or not
    $this->is_put = $this->method==='PUT' ? TRUE : FALSE;

    //check request method is delete or not
    $this->is_delete = $this->method==='DELETE' ? TRUE : FALSE;

    //check request method is patch or not
    $this->is_patch = $this->method === 'PATCH' ? TRUE : FALSE;

    //check request method is head or not
    $this->is_head = $this->method === 'HEAD' ? TRUE : FALSE;

    //check request method is options or not
    $this->is_options = $this->method==='OPTIONS' ? TRUE : FALSE;

    //check request method is connect or not
    $this->is_connect = $this->method==='CONNECT' ? TRUE : FALSE;

    //check request method is trace or not
    $this->is_trace = $this->method==='TRACE' ? TRUE : FALSE;

    //check request method is copy or not
    $this->is_copy = $this->method==='COPY' ? TRUE : FALSE;

    //check request method is link or not
    $this->is_link = $this->method==='LINK' ? TRUE : FALSE;

    //check request method is unlink or not
    $this->is_unlink = $this->method==='UNLINK' ? TRUE : FALSE;

    //check request method is lock or not
    $this->is_lock = $this->method==='LOCK' ? TRUE : FALSE;

    //check request method is unlock or not
    $this->is_unlock = $this->method==='UNLOCK' ? TRUE : FALSE;

    //check request method is purge or not
    $this->is_purge = $this->method==='PURGE' ? TRUE : FALSE;

    //check request method is propfind or not
    $this->is_propfind = $this->method==='PROPFIND' ? TRUE : FALSE;

    //check request method is view or not
    $this->is_view = $this->method==='VIEW' ? TRUE : FALSE;

    //check protocol https or not
    $this->is_http = $this->scheme==='http' ? TRUE : FALSE;

    //check protocol is http or not
    $this->is_https = $this->scheme==='https' ? TRUE : FALSE;

    //get files data
    $this->files = new file_handler();


    /**
    * User Information
    * Get User web browser information.
    */
    //get remote ip address
    $this->remote_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : FALSE;

    //check request is redirected or not
    $this->is_referred = isset($_SERVER['HTTP_REFERER']) ? TRUE : FALSE;

  }

  /**
  * Get server all informarion
  *
  * @param string $server_index
  * @return string
  */
  public function server($server_index) {
    $server_index = strtoupper($server_index);
    return $_SERVER[$server_index];
  }
}
