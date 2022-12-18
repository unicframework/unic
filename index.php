<?php
require('./vendor/autoload.php');

use Unic\App;

$app = new App();

$app->get('/', function($req, $res) {
  $res->send('Hello, World!');
});

$app->get('/api', function($req, $res) {
  $res->json(['status' => 'Ok']);
});

// Error handler middleware
$app->use(function($err, $req, $res, $next) {
  $res->send('Internal Server Error', 500);
});

$app->start();
