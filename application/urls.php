<?php
defined('BASEPATH') OR exit('No direct access allowed');

//URLs routing
$urlpatterns = [
  '/' => urls('app/urls.php'),
];

//Error handler
$errorhandlers = [
  '404' => 'view.page_not_found',
];
