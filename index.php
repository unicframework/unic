<?php
require('./vendor/autoload.php');

use Unic\App;

$app = new App();

// Set public path
$app->static('/', base_path('public'));

// Set view path
$app->set('views', base_path('views'));

// Set view engine
$app->set('view_engine', 'twig');
$app->set('cache_path', base_path('.cache'));

$app->get('/', function($req, $res) {
    $res->render('index.twig', [
        'title' => 'Unic',
    ]);
});

$app->get('/api', function($req, $res) {
    $res->json([
        'status' => 'Ok',
    ]);
});

// Error handler middleware
$app->use(function($err, $req, $res, $next) {
    $res->status(500)
        ->render('error.twig', [
            'message' => $err->getMessage(),
            'stack' => $err->getTraceAsString(),
            'status' => 500,
        ]);
});

$app->start();
