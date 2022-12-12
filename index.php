<?php
require('./vendor/autoload.php');

use Unic\App;

$app = new App();

$app->get('/', function($req, $res, $next) {
  $res->send('Hello, World!');
});

$app->start();
