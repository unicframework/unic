<?php
require('./vendor/autoload.php');

use Unic\App;

$app = new App();

// Set public path
$app->static('/', base_path('public'));

// Set view path
$app->set('views', base_path('views'));

$app->get('/', function($req, $res) {
  $res->render('index.html');
});

$app->get('/api', function($req, $res) {
  $res->json(['status' => 'Ok']);
});

// Error handler middleware
$app->use(function($err, $req, $res, $next) {
  $res->send('Internal Server Error', 500);
});

$app->start();
