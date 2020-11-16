<?php
//Include models
include_once 'model.php';

//Create your views here
class view extends Views {
  function __construct() {
    parent::__construct();
  }

  function home() {
    return $this->render('home');
  }

  function page_not_found() {
    return $this->render('404');
  }

  function internal_server_error() {
    return $this->render('500');
  }
}
