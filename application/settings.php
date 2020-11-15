<?php

//Set debugging mode
$debug = true;

//Allowed hosts
$allowed_hosts = ['localhost'];

//Set templates directory
$templates = [
  'app/template'
];

//Libraries
$libraries = [
  'system.security',
];

//Global middlewares
$middlewares = [];

//Database settings
$db['db'] = [
    'dsn' => '',
    'hostname' => 'localhost',
    'port' => '',
    'username' => '',
    'password' => '',
    'database' => '',
    'driver' => 'mysqli',
    'char_set' => 'utf8',
];

//Static URL
$static_url = '/static';

//Static files DIR
$static_dir = '/app/static';

//Ignore trailing slashes
$ignore_trailing_slash = true;

//Set default timezone
date_default_timezone_set('Asia/Kolkata');
