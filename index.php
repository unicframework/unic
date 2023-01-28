<?php
require('./vendor/autoload.php');

use Unic\App;

$app = new App();

// Set view directory path and view engine
$app->set('views', __DIR__ . '/views');
$app->set('view_engine', 'twig');

// Set public path and static files directory
$app->use($app->static('/', __DIR__ . '/public'));

// Routes
$app->get('/', function ($req, $res) {
    $res->render('index.twig', [
        'title' => 'Unic',
    ]);
});

$app->get('/api', function ($req, $res) {
    $res->json([
        'status' => "ok",
    ]);
});

// Error handler middleware
$app->use(function ($err, $req, $res, $next) {
    $res->status(500)
        ->render('error.twig', [
            'message' => $err->getMessage(),
            'stack' => $err->getTraceAsString(),
            'status' => 500,
        ]);
});

$app->start();
