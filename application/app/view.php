<?php
//Include models
require_once 'model.php';

//Create your views here
class view extends Views {
  function home(Request $req) {
    return $this->render('home');
  }

  function page_not_found(Request $req) {
    return $this->render('errors/404');
  }

  function forbidden(Request $req) {
    return $this->render('errors/403');
  }

  function internal_server_error(Request $req) {
    return $this->render('errors/500');
  }
}
